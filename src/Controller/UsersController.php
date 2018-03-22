<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use Cake\Core\Configure;
use Cake\Utility\Inflector;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Upload');
        $this->loadComponent('Stripe');
        $this->loadComponent('Paypal');
        $this->loadComponent('Encryption');
        $this->loadComponent('Flash'); // Include the FlashComponent  
        $this->loadComponent('ValidateCompanyAndUser');
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
        /* role_id 2 for company role _id 3 for employee */
        $this->set('pageTitle', $pageTitle);
        $message = [];
        if ($this->request->is('post')) {

            $user = $this->Users->find()->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email', 'Users.user_id', 'Users.role_id', 'Users.permission_id', 'Users.is_verify', 'Users.is_active', 'Users.email_verification'])->where(['Users.email' => $this->request->data['email'], 'Users.is_deleted' => 0])->first();
            $role_id = isset($user['role_id']) ? trim($user['role_id']) : '';

            if ($role_id == 3 || $role_id == 2) {
                if ($role_id == 2) {

                    $response = $this->ValidateCompanyAndUser->validateCompanyProfle($user);
                    if ($response['statusCode'] == 200) {
                        $this->Auth->setUser($user);
                        return $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
                    } else {
                        $message = $response;
                    }
                } else if ($role_id == 3) {

                    $response = $this->ValidateCompanyAndUser->validateCompanyUserProfle($user);
                    if ($response['statusCode'] == 200) {
                        $this->Auth->setUser($user);
                        return $this->redirect(['controller' => 'users', 'action' => 'dashboard']);
                    } else {
                        $message = $response;
                    }
                }
                if (isset($message) && $message['statusCode'] != 200) {
                    $this->Flash->error(__($message['message']));
                    return $this->redirect($this->referer());
                }
            }/* for invalid Role id */ else {
                $message['message'] = 'Anauthorized user';
                $message['statusCode'] = 202;
            }
        }/* for invalid request */
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
        $message = [];
        if ($this->request->is('post')) {

            $user = $this->Users->find()->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email', 'Users.user_id', 'Users.role_id', 'Users.permission_id', 'Users.is_verify', 'Users.is_active', 'Users.email_verification'])->where(['Users.email' => $this->request->data['email'], 'Users.is_deleted' => 0])->first();
            $role_id = isset($user['role_id']) ? trim($user['role_id']) : '';

            if ($role_id == 3 || $role_id == 2) {
                if ($role_id == 2) {

                    $response = $this->ValidateCompanyAndUser->validateCompanyProfle($user);
                    if ($response['statusCode'] == 200) {
                        $this->Auth->setUser($user);
                        $message = $response;
                    } else {
                        $message = $response;
                    }
                } else if ($role_id == 3) {

                    $response = $this->ValidateCompanyAndUser->validateCompanyUserProfle($user);
                    if ($response['statusCode'] == 200) {
                        $this->Auth->setUser($user);
                        $message = $response;
                    } else {
                        $message = $response;
                    }
                }
                if (isset($message) && $message['statusCode'] != 200) {
                    
                }
            }/* for invalid Role id */ else {
                $message['message'] = 'Anauthorized user';
                $message['statusCode'] = 202;
            }
            echo json_encode($message);
            die;
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
     * Update : 21 Jan. 2018
     */

    public function dashboard() {
        $pageTitle = 'Dashboard';
        $this->set('pageTitle', $pageTitle);
        $loggedCompanyId = Configure::read('LoggedCompanyId');
        $this->LocationOperations = TableRegistry::get('LocationOperations');
        $operationList = $this->LocationOperations->getOperationListByUserId($loggedCompanyId);
        $this->PermitOperations = TableRegistry::get('PermitOperations');
        $operationList = $this->PermitOperations->getOperationListByOperationId($operationList);
        if (empty($operationList)) {
            $operationList[0] = 0;
        }
        $this->loadModel('UserLocations');
        $this->loadModel('Operations');
        $userLocationList = $this->UserLocations->getUserLocationListByUserId($loggedCompanyId);
        $userOperationList = $this->Operations->getOperationListById($operationList);
        $data = $this->LocationOperations->find()
                ->contain([
                    'Operations', 'UserLocations',
                    'Operations.PermitOperations.Permits',
                    'Operations.PermitOperations.Permits.PermitAgencies.Agencies',
                ])
                ->where([
            'LocationOperations.user_id' => $loggedCompanyId,
            'LocationOperations.operation_id IN' => $operationList,
                ])/*
          ->toArray();prx($data) */;
        $permitStatusTable = TableRegistry::get('PermitStatus');
        $permitStatusses = $permitStatusTable->find('list')->toArray();
        $this->set(compact('data', 'permitStatusses', 'userLocationList', 'userOperationList'));
    }

    

    /* Function:profile()
     * Description: function use for show user profile 
     * @param type $id   
     * By @Ahsan Ahamad
     * Date : 7 Dec. 2017   
     */

    public function profile($userId = null) {
        $this->set(compact('userId'));
        $pageTitle = 'Profile ';
        $pageHedding = 'Profile';
        $breadcrumb = array(
            array('label' => 'Profile')
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $userId = $this->Encryption->decode($userId);
        $userData = $this->Users->getCompanyInfo($userId);
        $this->set('userData', $userData);
    }

    /* Function: editProfile()
     * Description: function use for show edit user profile
     * @param type $id
     * @return type    
     * By @Ahsan Ahamad
     * Date : 7 Dec. 2017
     */

    public function editProfile($userId = null) {
        $this->set(compact('userId'));
        $pageTitle = 'Profile | Edit';
        $pageHedding = 'Edit';
        $breadcrumb = array(
            array('label' => 'Profile | Edit')
        );
        $this->loadModel('UserLocations');
        $this->loadModel('LocationOperations');
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $userId = $this->Encryption->decode($userId);
        $userData = $this->Users->getCompanyInfo($userId);
        $this->set('userData', $userData);

        $locationOperationIds = $this->LocationOperations->getOperationIdByLocationId($userData['location_info']->id);
        $this->set(compact('locationOperationIds'));

        if ($this->request->is('post')) {
            $user['first_name'] = $this->request->data['Contact']['first_name'];
            $user['last_name'] = $this->request->data['Contact']['last_name'];
            $user['position'] = $this->request->data['Contact']['position'];
            $user['email'] = $this->request->data['Contact']['email'];
            $user['phone'] = $this->request->data['Contact']['phone'];
            if ($userData['basic_info']->role_id == 2) {
                if (!empty($this->request->data['logo']['name'])) {
                    $path = 'img/logo';
                    $fineData = $this->Upload->uploadImage($this->request->data['logo'], $path);
                    $user['logo'] = $fineData;
                }
            }
            if (!empty($this->request->data['profile_image']['name'])) {
                $path = 'img/profile';
                $profileData = $this->Upload->uploadImage($this->request->data['profile_image'], $path);
                $user['profile_image'] = $profileData;
            }


            $users = $this->Users->get($userId);
            $this->Users->patchEntity($users, $user);
            if (!$users->errors()) {
                if ($success = $this->Users->save($users)) {
                    /* for save company address */
                    if ($userData['basic_info']->role_id == 2) {
                        if (isset($this->request->data['Company']) && !empty($this->request->data['Company'])) {
                            $location['address1'] = $this->request->data['Company']['address_1'];
                            $location['address2'] = $this->request->data['Company']['address_2'];
                            $location['phone'] = $this->request->data['Company']['phone'];
                            $location['email'] = $this->request->data['Company']['email'];
                            $location['email'] = $this->request->data['Company']['email'];
                            $location['country_id'] = 254;
                            $location['state_id'] = 154;
                            $location['is_company'] = 1;
                            $location['user_id'] = $success->id;
                            $location['id'] = $userData['location_info']->id;

                            if (isset($this->request->data['is_operation'])) {
                                $location['is_operation'] = 1;
                            } else {
                                $location['is_operation'] = 0;
                            }
                            $userLocation = $this->UserLocations->get($location['id']);
                            $this->UserLocations->patchEntity($userLocation, $location);
                            $this->UserLocations->save($userLocation);

                            # Save Type of Operation for Company location
                            if ($location['is_operation'] == 1) {
                                $this->LocationOperations->updateOperations($userData['basic_info']->id, $userData['location_info']->id, $this->request->data['operation_id']);
                            } else {
                                # delete all Assocaited Operation basis on user-location-id
                                $this->LocationOperations->updateOperations($userData['basic_info']->id, $userData['location_info']->id);
                            }
                        }
                    }
                    /* === Added by vipin for  add log=== */
                    $message = 'Profile updated by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'Users';
                    $saveActivityLog['module_name'] = 'Profile Front';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */
                    $this->Flash->success(__('Profile has been updated successfully.'));
                    return $this->redirect(['controller' => 'users', 'action' => 'profile', $this->Encryption->encode($userId)]);
                }
            }
        }
        $this->loadModel('Operations');
        $operationList = $this->Operations->getList();
        $this->set(compact('operationList'));
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

        $subscriptionPlanId = 3;
        if (isset($this->request->query['plan'])) {
            $subscriptionPlanId = $this->Encryption->decode($this->request->query['plan']);
        }
        $this->set(compact('subscriptionPlanId'));

        if ($this->request->is('post')) {
            set_time_limit(180);
            /* Save Company/User Data */
            $user['company'] = $this->request->data['Company']['name'];
            $user['first_name'] = $this->request->data['Contact']['first_name'];
            $user['last_name'] = $this->request->data['Contact']['last_name'];
            $user['position'] = $this->request->data['Contact']['position'];
            $user['email'] = $this->request->data['Contact']['email'];
            $user['phone'] = $this->request->data['Contact']['phone'];
            $user['is_active'] = 0;
            $user['email_verification'] = $this->Custom->token();
            $user['password'] = $this->request->data['Contact']['password'];
            $user['created'] = date('Y-m-d H:i:s');
            $user['permission_id'] = 4;
            $users = $this->Users->newEntity($user);
            $this->Users->patchEntity($users, $user);
            if (!$users->errors()) {
                if ($success = $this->Users->save($users)) {
                    /* Save Company/Default Location */
                    $this->loadModel('UserLocations');
                    $companyOperation['title'] = 'Company (Default)';
                    $companyOperation['address1'] = $this->request->data['Company']['address_1'];
                    $companyOperation['address2'] = $this->request->data['Company']['address_2'];
                    $companyOperation['phone'] = $this->request->data['Company']['phone'];
                    $companyOperation['email'] = $this->request->data['Company']['email'];
                    $companyOperation['user_id'] = $success->id;
                    $companyOperation['created'] = date('Y-m-d H:i:s');
                    if (isset($this->request->data['Company']['is_operation']) && !empty($this->request->data['Company']['is_operation'])) {
                        $companyOperation['is_operation'] = 1;
                    } else {
                        $companyOperation['is_operation'] = 0;
                    }

                    $companyOperation['is_company'] = 1;
                    $companyOperation['country_id'] = 254; // US
                    $companyOperation['state_id'] = 154;  //New York
                    $companyLocations = $this->UserLocations->newEntity();
                    $this->UserLocations->patchEntity($companyLocations, $companyOperation);
                    $companyLocations = $this->UserLocations->save($companyLocations);

                    /* Save Type of Operation for Company Location */
                    $this->loadModel('LocationOperations');
                    if ($companyOperation['is_operation'] == 1) {
                        $this->LocationOperations->saveOperations($success->id, $companyLocations->id, $this->request->data['Company']['operation_id']);
                    }

                    /* Save Additonal Location along with  Type of Operations */
                    if (isset($this->request->data['Address']['title'])) {
                        $locationCount = count($this->request->data['Address']['title']);
                        for ($count = 0; $count < $locationCount; $count++) {
                            $additionalLocation = [];
                            $additionalLocation['title'] = $this->request->data['Address']['title'][$count];
                            $additionalLocation['address1'] = $this->request->data['Address']['address_1'][$count];
                            $additionalLocation['address2'] = $this->request->data['Address']['address_2'][$count];
                            $additionalLocation['phone'] = $this->request->data['Address']['phone'][$count];
                            $additionalLocation['email'] = $this->request->data['Address']['email'][$count];
                            $additionalLocation['user_id'] = $success->id;
                            $additionalLocation['created'] = date('Y-m-d H:i:s');
                            if (isset($this->request->data['is_operation'])) {
                                $additionalLocation['is_operation'] = 1;
                            } else {
                                $this->request->data['is_operation'] = 0;
                            }
                            $additionalLocation['is_company'] = 0;
                            $additionalLocation['country_id'] = 254; //US
                            $additionalLocation['state_id'] = 154; //New York                        
                            $additionalLocations = $this->UserLocations->newEntity();
                            $this->UserLocations->patchEntity($additionalLocations, $additionalLocation);
                            $additionalLocations = $this->UserLocations->save($additionalLocations);

                            /* Save Type of Operation for Additional Location */
                            $additionalOperations = $this->request->data['Address']['operations'][$count];
                            $additionalOperations = explode(',', $additionalOperations);
                            if (is_array($additionalOperations)) {
                                $this->LocationOperations->saveOperations($success->id, $additionalLocations->id, $additionalOperations);
                            }
                        }
                    }

                    /* code for send email verfication */
                    $this->loadModel('EmailTemplates');
                    $token = $user['email_verification'];
                    $link = HTTP_ROOT . 'users/emailVerification/' . $token;
                    $emailTemplate = $this->EmailTemplates->find()->where(['id' => 3])->first();
                    $emailData = $emailTemplate->description;
                    if (!empty($this->request->data['Contact']['last_name'])) {
                        $fullName = $this->request->data['Contact']['first_name'] . " " . $this->request->data['Contact']['last_name'];
                    } else {
                        $fullName = $this->request->data['Contact']['first_name'];
                    }
                    $emailData = str_replace('{USER_NAME}', $fullName, $emailData);
                    $emailData = str_replace('{LINK}', $link, $emailData);
                    $subject = $emailTemplate->subject;
                    $to = $this->request->data['Contact']['email'];

                    $this->_sendSmtpMail($subject, $emailData, $to);
                    // Make payment
                    $cardDetails['cardNumber'] = $this->request->data['Payment']['card_number'];
                    $cardDetails['cvv'] = $this->request->data['Payment']['cvv'];
                    $expiry = explode('/', $this->request->data['Payment']['expiry']);
                    $cardDetails['expireMonth'] = $expiry[0];
                    $cardDetails['expireYear'] = $expiry[1];
                    $cardDetails['cardholder'] = $this->request->data['Payment']['card_holder'];
                    $cardDetails['location'] = $this->UserLocations->getCountByUserId($success->id);
                    // Make payment via Stripe
                    $paymentResponse = $this->Stripe->createSubscription($success->id, $cardDetails, $this->request->data['SubscriptionPlan']['id']);
                    // Make payment via Paypal
                    //$paymentResponse = $this->Paypal->createSubscription($success->id, $cardDetails, $this->request->data['SubscriptionPlan']['id']);
                    if ($paymentResponse['status']) {
                        $paymentResponse['status'] = 'done';
                    } else {
                        $paymentResponse['status'] = '';
                        /* send email for payment */
                        $emailTemplate = $this->EmailTemplates->find()->where(['id' => 5])->first();
                        $emailData = $emailTemplate->description;
                        $subject = $emailTemplate->subject;
                        $userId = base64_encode($success->id);
                        $url = HTTP_ROOT . 'payments/index/' . $userId;
                        $emailData = str_replace('{USER_NAME}', $fullName, $emailData);
                        $emailData = str_replace('{LINK}', $url, $emailData);
                        $this->_sendSmtpMail($subject, $emailData, $to);
                    }
                    return $this->redirect(['controller' => 'users', 'action' => 'registration', $this->Encryption->encode($success->id), 'company', $paymentResponse['status']]);
                } else {
                    $this->Flash->error(__('Comapny could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
            }
        }
        $this->loadModel('Operations');
        $operationList = $this->Operations->getList();
        $this->set(compact('operationList'));

        $companyList = $this->Users->getCompanyList();
        $this->set(compact('companyList'));

        # Get Subscription-plan data
        $this->loadModel('SubscriptionPlans');
        $subscriptionPlans = $this->SubscriptionPlans->getAllPlans();
        $this->set(compact('subscriptionPlans'));
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
            $user['permission_id'] = 6;
            $user['email_verification'] = $this->Custom->token();
            $user['password'] = $this->request->data['Employee']['password'];
            $user['created'] = date('Y-m-d H:i:s');
            $users = $this->Users->newEntity($user);
            $this->Users->patchEntity($users, $user);
            if (!$users->errors()) {
                if ($success = $this->Users->save($users)) {
                    /* code for send email verfication to employee */
                    $this->loadModel('EmailTemplates');
                    $token = $success->email_verification;
                    $link = BASE_URL . '/users/emailVerification/' . $token;
                    $emailTemplate = $this->EmailTemplates->find()->where(['id' => 3])->first();
                    $emailData = $emailTemplate->description;
                    if (!empty($this->request->data['Employee']['last_name'])) {
                        $fullName = $this->request->data['Employee']['first_name'] . " " . $this->request->data['Employee']['last_name'];
                    } else {
                        $fullName = $this->request->data['Employee']['first_name'];
                    }
                    $emailData = str_replace('{USER_NAME}', $fullName, $emailData);
                    $emailData = str_replace('{LINK}', $link, $emailData);
                    $subject = $emailTemplate->subject;
                    $to = $this->request->data['Employee']['email'];
                    $this->_sendSmtpMail($subject, $emailData, $to);
//                    $data = array('token' => $success->email_verification, 'name' => $this->request->data['Employee']['first_name']);
//                    $to = $this->request->data['Employee']['email'];
//                    $template = 3;
//                    $subject = 'Wellcome NYCompliance';
//                    $send = $this->sendEmail($data, $to, $template, $subject);
                    /* code for send email to comany */
                    $company = $this->Users->find()->select(['first_name', 'last_name', 'email'])->where(['id' => $this->request->data['Employee']['company_id']])->first();
                    $emailTemplate = $this->EmailTemplates->find()->where(['id' => 6])->first();
                    $emailData = $emailTemplate->description;
                    if (!empty($company['last_name'])) {
                        $cfullName = $company['first_name'] . " " . $company['last_name'];
                    } else {
                        $cfullName = $company['first_name'];
                    }
                    $emailData = str_replace('{LINK}', BASE_URL, $emailData);
                    $emailData = str_replace('{USER_NAME}', $cfullName, $emailData);
                    $emailData = str_replace('{EMPLOYEE_NAME}', $fullName, $emailData);
                    $subject = $emailTemplate->subject;
                    $to = $company['email'];
                    $this->_sendSmtpMail($subject, $emailData, $to);
//                    $data = array('name' => $comaony['first_name'], 'empalyee' => $this->request->data['Employee']['first_name'] . ' ' . $this->request->data['Employee']['last_name']);
//                    $to = $company['email'];
//                    $template = 6;
//                    $subject = 'Add New Employee';
//                    $send = $this->sendEmail($data, $to, $template, $subject);
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
            $responseFlag = $this->sendEmail($data, $verificationData->email, 3, 'Email Verification');
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
        //prx($verificationData);
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
