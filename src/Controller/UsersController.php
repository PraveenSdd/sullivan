<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Upload');
        $this->loadComponent('Payment');
        $this->loadComponent('Encryption');
        $this->loadComponent('Flash'); // Include the FlashComponent        
        $this->Auth->allow(['signup', 'signup', 'registration', 'resendVerification', 'ajaxLogin', 'forgotPassword', 'EmployeeSignup', 'emailVerification', 'token', 'resetPassword', 'token']);
    }

    /* Function:login()
     * Decription:function use for logoin user function    
     * By @Ahsan Ahamad
     * Date :  5th Nov. 2017
     */

    public function login() {
        $this->viewBuilder()->setLayout('login');
        $pageTitle = 'Login';
        $this->set('pageTitle', $pageTitle);
        if ($this->request->is('post')) {
            $this->loadModel('Subscriptions');
            $user = $this->Users->find()->select(['Users.id', 'Users.user_id', 'role_id', 'is_verify'])->where(['Users.email' => $this->request->data['email'], 'Users.is_active' => 1, 'Users.is_deleted' => 0])->first();
            if ($user) {
                /* check company staff verfy or not  **** */

                if ($user->role_id == 3 && $user->is_verify == 1) {
                    $this->Flash->error(__('Sorry you are not authorize, Plese contact to company.'));
                    return $this->redirect(['controller' => 'users', 'action' => 'login']);
                }
                /*                 * *** check user company or staff **** */
                if ($user->user_id == 0) {

                    $userId = $user->id;
                    $messageUser = 'Please complate payment process fistly.';
                    $msgto = "Plese contact to administrator";
                } else {
                    $userId = $user->user_id;
                    $messageUser = "Company account is not active, please contact to the company";
                    $msgto = "Plese contact to company";
                }
                /**                 * *** check company Payment pay or not  **** */
                $subscriptions = $this->Subscriptions->find()->where(['Subscriptions.user_id' => $userId, 'Subscriptions.is_registration' => 1])->first();
                if ($subscriptions) {

                    $user = $this->Auth->identify();
                    if ($user) {
                        if ($user['role_id'] == 2 || $user['role_id'] == 3) {
                            $this->Auth->setUser($user);
                            return $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
                        } else {
                            return $this->redirect('/dashboard');
                        }
                    } else {
                        $this->Flash->error(__('You could not login successfully.'));
                    }
                } else {
                    $this->Flash->error(__($messageUser));
                }
            } else {
                $this->Flash->error(__('Sorry you are not authorize, ' . $msgto));
            }
        }
    }

    /* Function:ajaxLogin()
     * Decription:function use for logoin user from popup    
     * By @Ahsan Ahamad
     * Date :  5th Nov. 2017
     */

    public function ajaxLogin() {
        $this->autoRender = FALSE;
        $pageTitle = 'Login';
        $this->set('pageTitle', $pageTitle);
        $this->viewBuilder()->setLayout('');
        if ($this->request->is('post')) {

            $this->loadModel('Subscriptions');
            $user = $this->Users->find()->select(['Users.id', 'Users.user_id', 'role_id', 'is_verify'])->where(['Users.email' => $this->request->data['email'], 'Users.is_active' => 1, 'Users.is_deleted' => 0])->first();
            if ($user) {
                /**                 * *** check company staff verify or not  **** */
                if ($user->role_id == 3 && $user->is_verify == 0) {
                    echo $msg = "Sorry you are not authorize, plese contact to administrator";
                    exit;
                }

                /**                 * *** check company staff verfy or not  **** */
                if ($user->user_id == 0) {
                    $userId = $user->id;
                    $messageUser = 'Please complate payment process fistly.';
                    $msgto = "plese contact to administrator";
                } else {
                    $userId = $user->user_id;
                    $messageUser = "Company account is not active, please contact to the company";
                    $msgto = "plese contact to company";
                }
                $subscriptions = $this->Subscriptions->find()->where(['Subscriptions.user_id' => $userId, 'Subscriptions.is_registration' => 1])->first();
                if ($subscriptions) {
                    $user = $this->Auth->identify();
                    if ($user) {
                        if ($user['role_id'] == 2) {
                            $this->Auth->setUser($user);
                            echo $msg = "success";
                        }
                    } else {

                        echo $msg = "You could not login successfully";
                    }
                } else {
                    echo $msg = $messageUser;
                }
            } else {
                echo $msg = "Sorry you are not authorize, " . $msgto;
            }
        }
    }

    /* Function: logout()
     * Description: function use for logout user     
     * By @Ahsan Ahamad
     * Date : 5th Nov. 2017
     */

    public function logout() {
        if ($this->Auth->logout()) {
            return $this->redirect('/');
        }
    }

    /* Function: changePassword()
     * Desription: function use for change password     
     * By @Ahsan Ahamad
     * Date : 25 setp. 2017
     */

    public function changePassword() {
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'ChangePassword']);
            if ($user->errors()) {
                $error_msg = [];
                foreach ($user->errors() as $errors) {
                    if (is_array($errors)) {
                        foreach ($errors as $error) {
                            $error_msg[] = $error;
                        }
                    } else {
                        $error_msg[] = $errors;
                    }
                }
                if (!empty($error_msg)) {

                    $this->Flash->error(
                            __("Please fix the following error(s):" . implode("\n \r", $errors))
                    );
                    return $this->redirect($this->referer());
                }
            }
            if ($this->Users->save($user)) {
                $massage = ['message' => 'Password hsa been updated successfully, try again', 'title' => 'Success'];
                $this->set('massage', $massage);
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            } else {

                $massage = ['message' => 'Password could not updated, try again', 'title' => 'Error'];
                $this->set('massage', $massage);
                return $this->redirect($this->referer());
            }
        }
    }

    /* Function: forgotPassword()
     * Decription: function use for send forgot password email user function    
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function forgotPassword() {
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Users->find()->select(['id', 'email', 'token', 'first_name'])->where(['email' => $this->request->data['email']])->first();
            if ($user) {
                $token = $this->Custom->token();
                $users = TableRegistry::get('Users');

                $query = $users->query();
                $update = $query->update()
                        ->set(['token' => $token])
                        ->where(['id' => $user['id']])
                        ->execute();
                if ($update == true) {

                    $data = array('token' => $token, 'name' => $user['first_name']);
                    $to = $this->request->data['email'];
                    $template = 'client_forgot_password';
                    $subject = 'Reset Password';
                    $send = $this->sendEmail($data, $to, $template, $subject);
                    $this->Flash->success(__('Please check Email account inbox or span.'));
                }
            } else {
                $this->Flash->error(__('Email not found'));
            }

            return $this->redirect($this->referer());
        }
    }

    /* Function: resetPassword()
     * Description: function use for create new password user function    
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function resetPassword($token) {
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $users = $this->Users->find()->select(['id'])->where(['token' => $this->request->data['token']])->first();

            if ($users) {
                $id = $users['id'];
                $user = $this->Users->get($id);
                $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'ChangePassword']);
                if (!$user->errors()) {
                    $password = (new DefaultPasswordHasher)->hash($this->request->data['password']);
                    $userTable = TableRegistry::get('Users');
                    $query = $userTable->query();
                    $data = $query->update()
                            ->set(['password' => $password, 'token' => null])
                            ->where(['id' => $user['id']])
                            ->execute();
                    if ($data) {
                        $this->Flash->success(__('Password hsa been updated successfully'));
                        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                    } else {
                        $this->Flash->success(__('Password could not updated, try again'));
                        return $this->redirect($this->referer());
                    }
                } else {
                    $this->Flash->error(__($this->Custom->multipleFlash($alerts->errors())));
                }
            }
        }
        $this->set('token', $token);
    }

    /* Function: dashboard()
     * Description: function use for client dashboard    
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function dashboard() {
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Dashnoard';
        $this->set('pageTitle', $pageTitle);
        $this->loadModel('Permits');
        $accessPermits = $this->Permits->find()->contain(['UserLocations', 'Industries', 'Forms'])->where(['Permits.user_id' => $this->userId, 'Permits.permit_status_id' => 2])->all();
        $this->set(compact('accessPermits'));
    }

    /* Function:profile()
     * Description: function use for show user profile 
     * @param type $id   
     * By @Ahsan Ahamad
     * Date : 7 Dec. 2017   
     */

    public function profile($id = null) {
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Profile ';
        $pageHedding = 'Profile';
        $breadcrumb = array(
            array('label' => 'Profile')
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $uid = $this->Encryption->decode($id);

        if ($this->Auth->user('role_id') == 3) {
            $users = $this->Users->find()->where(['Users.id' => $uid])->first();
            $companyDetails = $this->Users->getCompanyInfo($this->Auth->user('user_id'));
            $this->set('companyDetails', $companyDetails);
        } else {
            $users = $this->Users->find()->contain(['UserLocations'])->where(['Users.id' => $uid])->first();
        }

        $this->set('users', $users);
    }

    /* Function: editProfile()
     * Description: function use for show edit user profile
     * @param type $id
     * @return type    
     * By @Ahsan Ahamad
     * Date : 7 Dec. 2017
     */

    public function editProfile($id = null) {
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Profile | Edit';
        $pageHedding = 'Edit';
        $breadcrumb = array(
            array('label' => 'Profile | Edit')
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {

            $user['first_name'] = $this->request->data['Contact']['first_name'];
            $user['last_name'] = $this->request->data['Contact']['last_name'];
            $user['position'] = $this->request->data['Contact']['position'];
            $user['email'] = $this->request->data['Contact']['email'];
            $user['phone'] = $this->request->data['Contact']['phone'];
            if (!empty($this->request->data['logo']['name'])) {
                $path = 'img/logo';
                $fineData = $this->Upload->imagesUpload($this->request->data['logo'], $path);
                $user['logo'] = $fineData;
            }
            if (!empty($this->request->data['profile_image']['name'])) {
                $path = 'img/profile';
                $profileData = $this->Upload->imagesUpload($this->request->data['profile_image'], $path);
                $user['profile_image'] = $profileData;
            }


            $users = $this->Users->get($this->request->data['Contact']['id']);
            $this->Users->patchEntity($users, $user);
            if (!$users->errors()) {
                if ($success = $this->Users->save($users)) {
                    /* for save company address */
                    if (!empty($this->request->data['Company'])) {

                        $this->loadModel('UserLocations');
                        $location['address1'] = $this->request->data['Company']['address_1'];
                        $location['address2'] = $this->request->data['Company']['address_2'];
                        $location['phone'] = $this->request->data['Company']['phone'];
                        $location['email'] = $this->request->data['Company']['email'];
                        $location['email'] = $this->request->data['Company']['email'];
                        $location['country_id'] = 254;
                        $location['state_id'] = 154;
                        $location['is_company'] = 1;
                        $location['user_id'] = $success->id;
                        if (!empty($this->request->data['Company']['id'])) {
                            $UserLocation = $this->UserLocations->get($this->request->data['Company']['id']);
                        } else {
                            $UserLocation = $this->UserLocations->newEntity();
                        }
                        $this->UserLocations->patchEntity($UserLocation, $location);
                        $this->UserLocations->save($UserLocation);
                    }

                    $this->Flash->success(__('Profile has been updated successfully.'));
                    $uid = $this->Encryption->encode($this->request->data['Contact']['id']);
                    return $this->redirect(['controller' => 'users', 'action' => 'profile', $uid]);
                }
            }
        }

        $uid = $this->Encryption->decode($id);
        if ($this->Auth->user('role_id') == 3) {
            $users = $this->Users->find()->where(['Users.id' => $uid])->first();
            $companyDetails = $this->Users->getCompanyInfo($this->Auth->user('user_id'));
            $this->set('companyDetails', $companyDetails);
        } else {
            $users = $this->Users->find()->contain(['UserLocations'])->where(['Users.id' => $uid])->first();
        }
        $this->set('users', $users);
        $this->loadModel('Industries');
        $industries = $this->Industries->find('list', ['valueField' => 'name']);
        $industries->hydrate(false)->select(['Industries.name'])->where(['Industries.is_deleted' => 0, 'Industries.is_active' => 1]);
        $industryList = $industries->toArray();
        $this->set(compact('industryList'));
    }

    public function index() {
        
    }

    /* Function: signup()
     * Description: function use for create new client user    
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function signup() {
        $this->viewBuilder()->setLayout('login');
        /* code for send payment */

        if ($this->request->is('post')) {
            set_time_limit(180);
            $user['company'] = $this->request->data['Company']['name'];
            $user['first_name'] = $this->request->data['Contact']['first_name'];
            $user['last_name'] = $this->request->data['Contact']['last_name'];
            $user['position'] = $this->request->data['Contact']['position'];
            $user['email'] = $this->request->data['Contact']['email'];
            $user['phone'] = $this->request->data['Contact']['phone'];
            $user['is_active'] = 0;
            $user['email_verification'] = $this->Custom->token();
            $user['password'] = (new DefaultPasswordHasher)->hash($this->request->data['Contact']['password']);
            $user['created'] = date('Y-m-d H:i:s');
            $users = $this->Users->newEntity($user);
            $this->Users->patchEntity($users, $user);
            if (!$users->errors()) {
                if ($success = $this->Users->save($users)) {
                    /* for save company address */
                    $this->loadModel('UserLocations');
                    $location['address1'] = $this->request->data['Company']['address_1'];
                    $location['address2'] = $this->request->data['Company']['address_2'];
                    $location['phone'] = $this->request->data['Company']['phone'];
                    $location['email'] = $this->request->data['Company']['email'];
                    $location['is_company'] = 1;
                    $location['user_id'] = $success->id;
                    $UserLocation = $this->UserLocations->newEntity();
                    $this->UserLocations->patchEntity($UserLocation, $location);
                    $companyAddress = $this->UserLocations->save($UserLocation);
                    /* code for saved User industries */
                    $this->loadModel('LocationIndustries');
                    foreach ($this->request->data['industry_id'] as $industry) {
                        $companyrIndustry['industry_id'] = $industry;
                        $companyrIndustry['user_location_id'] = $companyAddress->id;
                        $companyrIndustry['user_id'] = $success->id;
                        $companyIndustries = $this->LocationIndustries->newEntity();
                        $this->LocationIndustries->patchEntity($companyIndustries, $companyrIndustry);
                        $this->LocationIndustries->save($companyIndustries);
                    }



                    /* for save multiple address  */
                    $count = count($this->request->data['Address']['title']);

                    for ($number = 0; $number < $count; $number++) {
                        $locationAddress['country_id'] = 254;
                        $locationAddress['state_id'] = 154;
                        $locationAddress['address1'] = $this->request->data['Address']['title'][$number];
                        $locationAddress['address1'] = $this->request->data['Address']['address_1'][$number];
                        $locationAddress['address2'] = $this->request->data['Address']['address_2'][$number];
                        $locationAddress['phone'] = $this->request->data['Address']['phone'][$number];
                        $locationAddress['email'] = $this->request->data['Address']['email'][$number];
                        $locationAddress['user_id'] = $success->id;
                        $locationAddress['industry_id'] = $this->request->data['industry_id'][$number];

                        $UserLocationAddress = $this->UserLocations->newEntity();
                        $this->UserLocations->patchEntity($UserLocationAddress, $locationAddress);
                        $additionalAddress = $this->UserLocations->save($UserLocationAddress);

                        /* code for saved User industries */
                        $addressOperations = $this->request->data['Address']['operations'][$number];
                        $addressOperations = explode(',', $addressOperations);
                        if (is_array($addressOperations)) {
                            foreach ($addressOperations as $operation) {
                                $addressIndustry['industry_id'] = $operation;
                                $addressIndustry['user_location_id'] = $additionalAddress->id;
                                $addressIndustry['user_id'] = $success->id;
                                $addressIndustries = $this->LocationIndustries->newEntity();
                                $this->LocationIndustries->patchEntity($addressIndustries, $addressIndustry);
                                $this->LocationIndustries->save($addressIndustries);
                            }
                        }
                    }

                    /* code for send email verfication */

                    $data = array('token' => $success->email_verification, 'name' => $this->request->data['Contact']['first_name']);
                    $to = $this->request->data['Contact']['email'];
                    $template = 'email_verfication';
                    $subject = 'Wellcome NYCompliance';
                    $send = $this->sendEmail($data, $to, $template, $subject);
                    /* send email for payment */
                    $userId = base64_encode($success->id);
                    $token = $this->Custom->token();
                    $data = array('token' => $token, 'userId' => $userId, 'name' => $this->request->data['Contact']['first_name'], 'url' => BASE_URL . '/payments/index/' . $userId);
                    $to = $this->request->data['Contact']['email'];
                    $template = 'for_payment';
                    $subject = 'Payment';
                    $send = $this->sendEmail($data, $to, $template, $subject);
                    /* code for send payment  */
                    $locationCount = $this->UserLocations->getCountByUserId($success->id);
                    $amount = 500;
                    if ($locationCount > 5) {
                        $amount = 1000;
                    } else if ($locationCount <= 5 && $locationCount > 3) {
                        $amount = 750;
                    }

                    $cardDetails['cardNumber'] = $this->request->data['Payment']['card_number'];
                    $cardDetails['cvv'] = $this->request->data['Payment']['cvv'];
                    $expiry = explode('/', $this->request->data['Payment']['expiry']);
                    $cardDetails['expireMonth'] = $expiry[0];
                    $cardDetails['expireYear'] = $expiry[1];
                    $cardDetails['cardholder'] = $this->request->data['Payment']['card_holder'];
                    $cardDetails['location'] = $locationCount;
                    $cardDetails['amount'] = $amount;
                    // make payment 
                    $paymentResponse = $this->Payment->paypalRecurring($success->id, $cardDetails);
                    if ($paymentResponse['status']) {
                        $paymentResponse['status'] = 'done';
                    } else {
                        $paymentResponse['status'] = '';
                    }
                    return $this->redirect(['controller' => 'users', 'action' => 'registration', $this->Encryption->encode($success->id), 'company', $paymentResponse['status']]);
                } else {
                    $this->Flash->error(__('Comapny could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
            }
        }

        $this->loadModel('Industries');
        $industries = $this->Industries->find('list', ['valueField' => 'name']);
        $industries->hydrate(false)->select(['Industries.name'])->where(['Industries.is_deleted' => 0, 'Industries.is_active' => 1]);
        $industryList = $industries->toArray();
        $this->set(compact('industryList'));

        $companyList = $this->Users->getCompanyList();
        $this->set(compact('companyList'));
    }

    /* Function: EmployeeSignup()
     * Description: function use for create new admin user     
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function EmployeeSignup() {
        $this->viewBuilder()->setLayout('login');
        /* code for send payment */
        $this->autoRender = FALSE;

        if ($this->request->is('post')) {
            $user['role_id'] = 3;
            $user['first_name'] = $this->request->data['Employee']['first_name'];
            $user['user_id'] = $this->request->data['Employee']['company_id'];
            $user['last_name'] = $this->request->data['Employee']['last_name'];
            $user['position'] = $this->request->data['Employee']['position'];
            $user['email'] = $this->request->data['Employee']['email'];
            $user['phone'] = $this->request->data['Employee']['phone'];
            $user['is_active'] = 0;
            $user['email_verification'] = $this->Custom->token();
            $user['password'] = (new DefaultPasswordHasher)->hash($this->request->data['Employee']['password']);
            $user['created'] = date('Y-m-d H:i:s');
            $users = $this->Users->newEntity($user);
            $this->Users->patchEntity($users, $user);
            if (!$users->errors()) {
                if ($success = $this->Users->save($users)) {
                    /* code for send email verfication to employee */
                    $data = array('token' => $success->email_verification, 'name' => $this->request->data['Employee']['first_name']);
                    $to = $this->request->data['Employee']['email'];
                    $template = 'email_verfication';
                    $subject = 'Wellcome NYCompliance';
                    $send = $this->sendEmail($data, $to, $template, $subject);
                    /* code for send email to comany */
                    $comaony = $this->Users->find()->select(['first_name', 'email'])->where(['id' => $this->request->data['Employee']['company_id']])->first();

                    $data = array('name' => $comaony['first_name'], 'empalyee' => $this->request->data['Employee']['first_name'] . ' ' . $this->request->data['Employee']['last_name']);
                    $to = $comaony['email'];
                    $template = 'new_employee';
                    $subject = 'Add New Employee';
                    $send = $this->sendEmail($data, $to, $template, $subject);
                    return $this->redirect(['controller' => 'users', 'action' => 'registration', $this->Encryption->encode($success->id), 'employee']);
                } else {
                    $this->Flash->error(__('Registration could not be success'));
                    $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
            }
        }

        $this->loadModel('Industries');
        $industries = $this->Industries->find('list', ['valueField' => 'name']);
        $industries->hydrate(false)->select(['Industries.name'])->where(['Industries.is_deleted' => 0, 'Industries.is_active' => 1]);
        $industryList = $industries->toArray();
        $this->set(compact('industryList'));

        $companyList = $this->Users->getCompanyList();
        $this->set(compact('companyList'));
    }

    /**
     * Display registration message after sign-up
     * @param type $userId
     * @param type $registationType
     * @param type $registrationStatus
     * $registationType = company, employee
     * $registrationStatus = done,NULL
     */
    public function registration($userId, $registationType, $registrationStatus = null) {
        $this->viewBuilder()->setLayout('login');
        $userId = $this->Encryption->decode($userId);

        $this->Users = TableRegistry::get('Users');
        $userEmail = $this->Users->getEmailById($userId);
        $this->set(compact('userId', 'registationType', 'registrationStatus', 'userEmail'));
    }

    /* Function: checkUniqueCompany()
     * Description: check Unique user unique company name
     * @param type $company
     * @param type $userId
     * @return type
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function checkUniqueCompany($company = null, $userId = null) {
        $this->autoRender = FALSE;
        $responseFlag = false;
        $responseFlag = $this->Custom->checkUniqueCompany($company, $userId);
        return $responseFlag;
    }

    /* Function: resendVerification()
     * Description:  resend verification link
     * @param type $userId
     * By @Ahsan Ahamad
     * Date : 5 Dec. 2017
     */

    public function resendVerification($userId) {
        $this->viewBuilder()->setLayout('login');
        $userId = $this->Encryption->decode($userId);
        $verificationData = $this->Users->getVerificationDataById($userId);
        $responseFlag = false;
        if ($verificationData) {
            $data = array('token' => $verificationData->email_verification, 'name' => $verificationData->first_name);
            $responseFlag = $this->sendEmail($data, $verificationData->email, 'email_verfication', 'Email Verification');
        }
        $this->set(compact('userId', 'verificationData', 'responseFlag'));
    }

    /* Function: resetPassword()
     * Description: function use for create new password 
     * @param type $emailVerification    
     * By @Ahsan Ahamad
     * Date : 26 setp. 2017
     */

    public function emailVerification($emailVerification = null) {
        $this->viewBuilder()->setLayout('login');
        $verificationData = $this->Users->getIdByEmailVerification($emailVerification);
        $responseFlag = false;
        if ($verificationData) {
            $userTable = TableRegistry::get('Users');
            $query = $userTable->query();
            $data = $query->update()
                    ->set(['is_active' => 1, 'email_verification' => 1])
                    ->where(['id' => $verificationData->id])
                    ->execute();
            if ($data) {
                $responseFlag = true;
            }
        }
        $this->set(compact('verificationData', 'responseFlag'));
    }

}
