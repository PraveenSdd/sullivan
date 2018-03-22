<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        if (!$this->request->getParam('admin')) {
            if ($this->Auth->user()) {
                if ($this->Auth->user('role_id') != 1 && $this->Auth->user('role_id') != 4) {
                    $this->redirect('/');
                }
            }
        }
        /* these are code for get admin and employee id */
        if ($this->Auth->user('user_id') != 0) {
            $this->companyId = $this->Auth->user('user_id');
            $this->userId = $this->Auth->user('id');
        } else {
            $this->emaployeeId = $this->Auth->user('id');
            $this->userId = $this->Auth->user('id');
        }
        $this->loadComponent('Upload');
        $this->Auth->allow(['login', 'forgotPassword', 'resetPassword', 'emailVerification']);
    }

    /* Function: login()
     * @Description:  function use for logoin user function    
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function login() {
        $pageTitle = 'Login';
        $this->set(compact('pageTitle'));
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $emailExist = $this->Users->find()->where(['email' => $this->request->data['email'], 'role_id in' => array(1, 4)])->first();
            if (empty($emailExist)) {
                $this->Flash->error(__('Combination of username/password is not correct, try again.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => 'admin']);
            }
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                if (!empty($this->request->data) && @$this->request->data['remember_me']) {
                    $cookie = array();
                    $cookie['admin']['email'] = $this->request->data['email'];
                    $cookie['admin']['password'] = $this->Encryption->encode($this->request->data['password']);
                    $this->Cookie->config([
                        'expires' => '+10 days',
                        'httpOnly' => true,
                        'secure' => FALSE,
                    ]);
                    $this->Cookie->write('Sullivan', $cookie, true);
                } else {
                    $this->Cookie->delete('Sullivan');
                }

                return $this->redirect(['controller' => 'Users', 'action' => 'dashboard', 'prefix' => 'admin']);
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login', 'prefix' => 'admin']);
            }
        }

        if (empty($this->request->data)) {
            $cookie = $this->Cookie->read('Sullivan');
            if (!empty($cookie)) {
                $this->request->data['email'] = $cookie['admin']['email'];
                $this->request->data['password'] = $this->Encryption->decode($cookie['admin']['password']);
                $this->request->data['remember_me'] = '1';
            }
        }
    }

    /* Function: logout()
     * @Description: function use for logout user function    
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function logout() {
        $this->Flash->success(__('user has been logout successfully'));
        $this->redirect($this->Auth->logout());
    }

    /* Function: dashboard()
     * Description: function use for view dashoard details    
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function dashboard() {
        $pageTitle = 'Dashboard';
        $pageHedding = 'Dashboard';
        $this->set(compact('pageTitle', 'pageHedding'));
        $this->loadModel('Permits');
        $this->loadModel('Operations');
        $this->loadModel('Agencies');
        $company = $this->Users->find()->where(['Users.role_id' => 2, 'Users.is_active' => 1, 'Users.is_deleted' => 0])->count('id');
        $permits = $this->Permits->find()->where(['Permits.is_active' => 1, 'Permits.is_deleted' => 0])->count('id');
        $agencies = $this->Agencies->find()->where(['Agencies.is_active' => 1, 'Agencies.is_deleted' => 0])->count('id');
        $operations = $this->Operations->find()->where(['Operations.is_active' => 1, 'Operations.is_deleted' => 0])->count('id');

        $acticitylogs = TableRegistry::get('ActivityLogs');
        $conditions = [];
        $this->paginate = [
            'conditions' => $conditions,
            'order' => ['ActivityLogs.id' => 'desc'],
            'limit' => 5,
        ];
        $logs = $this->paginate($acticitylogs);
        $this->set(compact('logs'));



        $this->set(compact('company', 'permits', 'agencies', 'operations'));
    }

    /* Function: forgotPassword()
     * @Description: Function use for send forgot password email user function    
     * By @Ahsan Ahamad
     * Date : 9th Nov. 2017
     */

    public function forgotPassword() {
        $pageTitle = 'Login';
        $this->set(compact('pageTitle'));
        $this->viewBuilder()->setLayout('login');

        if ($this->request->is('post')) {
            $user = $this->Users->find()->select(['id', 'email', 'first_name'])->where(['email' => $this->request->data['email'], 'role_id' => 1])->first();

            if ($user) {
                /* get token for verfication user */
                $token = $this->Custom->token();
                $userTable = TableRegistry::get('Users');
                $query = $userTable->query();
                $data = $query->update()
                        ->set(['token' => $token])
                        ->where(['id' => $user['id']])
                        ->execute();

                $data = array('token' => $token, 'name' => $user['first_name']);
                $to = $this->request->data['email'];
                $template = 'forgot_password';
                $subject = 'Reset Password';
                /* send email to user */
                $send = $this->Custom->sendEmail($data, $to, $template, $subject);

                if ($send) {
                    $this->Flash->success(__('Please check Email account inbox or span'));
                } else {
                    $this->Flash->error(__('Email does not send, try again'));
                }
            } else {
                $this->Flash->error(__('Email not found, try again'));
            }
            return $this->redirect($this->referer());
        }
    }

    /* Function: resetPassword()
     * @Description: function use for create new password user function    
     * By @Ahsan Ahamad
     * Date : 9th Nov. 2017
     */

    public function resetPassword($token) {

        $pageTitle = 'Reset Password';
        $this->set(compact('pageTitle'));

        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $users = $this->Users->find()->select(['id'])->where(['token' => $this->request->data['token']])->first();
            if ($users) {
                $id = $users['id'];
                $user = $this->Users->get($id);
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
                        $this->Flash->error(__($error_msg));

                        return $this->redirect($this->referer());
                    }
                }
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
            }
        }
        $this->set('token', $token);
    }

    /* Function: changePassword()
     * @Description: Function use for change password user function    
     * By @Ahsan Ahamad
     * Date : 25 setp. 2017
     */

    public function changePassword() {
        $pageTitle = 'Change Password';
        $pageHedding = 'Change Password';
        $breadcrumb = array(
            array('label' => 'Setting', 'link' => 'users/changePassword'),
            array('label' => 'Change Password'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is(['post', 'put'])) {
            $user = $this->Users->get($this->userId);
            $user = $this->Users->patchEntity($user, $this->request->data, ['validate' => 'ChangePassword']);

            if ($user->errors()) {

                if ($success = $this->Users->save($user)) {
                    /* === Added by vipin for  add log=== */
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'users';
                    $saveActivityLog['module_name'] = 'Change Password';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = 'Password updated by' . $this->loggedusername;
                    $saveActivityLog['activity'] = 'Update';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */

                    $massage = ['message' => 'Password has been updated successfully, try again', 'title' => 'Success'];
                    $this->set('massage', $massage);
                    return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
                } else {

                    $massage = ['message' => 'Password could not updated, try again', 'title' => 'Error'];
                    $this->set('massage', $massage);
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($user->errors())));
            }
        }
    }

    /* Function: companies()
     * Description: Function use for get all companies   
     * By @Ahsan Ahamad
     * Date : 17th Nov. 2017
     */

    public function companies() {
        $pageTitle = 'Companies';
        $pageHedding = 'Companies';
        $breadcrumb = array(
            array('label' => 'Companies'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $conditions = ['Users.is_deleted' => 0, 'Users.role_id' => 2];
        if ($this->request->query('name')) {
            $conditions['HomePages.title LIKE'] = '%' . $this->request->query('name') . '%';
        }
        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 10,
        ];
        $companies = $this->paginate($this->Users);
        $this->set(compact('companies'));
    }

    /*  Function: addCompany()
     * Description:  function use for add new Company   
     * By @Ahsan Ahamad
     * Date : 17sth Nov. 2017
     */

    public function addCompany() {
        $pageTitle = 'Companies | Add';
        $pageHedding = 'Companies | Add';
        $breadcrumb = array(
            array('label' => 'Companies', 'link' => 'users/Companies'),
            array('label' => 'Add'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $users = $this->Users->newEntity();
            /* these are line check serversite validation and save data  */
            $this->Users->patchEntity($users, $this->request->data, ['validate' => 'Default']);
            if (!$users->errors()) {
                $success = $this->Users->save($users);
                if ($success) {
                    $this->Flash->success(__('The company has been saved successfully.'));
                    return $this->redirect(['controller' => 'users', 'action' => 'companies']);
                } else {
                    $this->Flash->error(__('company could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
            }
        }
    }

    /*  Function: editCompany()
     * Description:  Function use for add Company 
     * @param type $id
     * @return type  
     * By @Ahsan Ahamad
     * Date : 17sth Nov. 2017
     */

    public function editCompany($id = null) {
        $pageTitle = 'Companies | Edit';
        $pageHedding = 'Companies | Edit';
        $breadcrumb = array(
            array('label' => 'Companies', 'link' => 'users/Companies'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $mailId = $id;
        if ($this->request->is(['post', 'put'])) {
            $id = $this->request->data['id'];
            $users = $this->Users->get($id);
            /* these are line check serversite validation and save data  */

            $this->Users->patchEntity($users, $this->request->data, ['validate' => 'Default']);
            if (!$users->errors()) {
                $success = $this->Users->save($users);
                if ($success) {
                    $this->Flash->success(__('company has been saved successfully.'));
                    return $this->redirect(['controller' => 'users', 'action' => 'companies']);
                } else {
                    $this->Flash->error(__('company could not be saved'));
                    return $this->redirect(['controller' => 'users', 'action' => 'editCompany', $mailId]);
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
                return $this->redirect(['controller' => 'users', 'action' => 'editCompany', $mailId]);
            }
        }

        $id = $this->Encryption->decode($id);
        $company = $this->Users->find()->hydrate(false)
                        ->where(['Users.id =' => $id])->first();
        $this->request->data = $company;
    }

    /*  Function: profile()
     * Description: Function use for view admin and employee profile details   
     * By @Ahsan Ahamad
     * Date : 14th Dec. 2017
     */

    public function profile() {
        $pageTitle = 'Profile';
        $pageHedding = 'Profile';
        $breadcrumb = array(
            array('label' => 'Setting', 'link' => 'users/profile'),
            array('label' => 'Profile'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $profile = $this->Users->find()->where(['id' => $this->userId])->first();
        $this->set(compact('profile'));
    }

    /*  Function: profileEdit()
     * Description: Function use for edit admin and employee profile details   
     * By @Ahsan Ahamad
     * Date : 14th Dec. 2017
     */

    public function profileEdit() {
        $pageTitle = 'Edit Profile';
        $pageHedding = 'Edit Profile';
        $breadcrumb = array(
            array('label' => 'Setting', 'link' => 'users/profile'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is(['post', 'put'])) {
            $users = $this->Users->get($this->userId);
            if ($users) {
                $this->Users->patchEntity($users, $this->request->data, ['validate' => 'Default']);
                if (!$users->errors()) {
                    $success = $this->Users->save($users);
                    if ($success) {
                        /* === Added by vipin for  add log=== */
                        $message = 'Profile updated by ' . $this->loggedusername;
                        $saveActivityLog = [];
                        $saveActivityLog['table_id'] = $success->id;
                        $saveActivityLog['table_name'] = 'users';
                        $saveActivityLog['module_name'] = 'Profile';
                        $saveActivityLog['url'] = $this->referer();
                        $saveActivityLog['message'] = $message;
                        $saveActivityLog['activity'] = 'Edit';
                        $this->Custom->saveActivityLog($saveActivityLog);
                        /* === Added by vipin for  add log=== */
                        $this->Flash->success(__('Profile has been saved successfully.'));
                        return $this->redirect(['controller' => 'users', 'action' => 'profile']);
                    } else {
                        $this->Flash->error(__('Profile could not be saved'));
                        return $this->redirect(['controller' => 'users', 'action' => 'profile']);
                    }
                } else {
                    $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
                }
            } else {
                $this->Flash->error(__('profile could not be find'));
                return $this->redirect(['controller' => 'users', 'action' => 'profile']);
            }
        }

        $profile = $this->Users->find()->where(['id' => $this->userId])->first();
        $this->set(compact('profile'));
    }

    /*  Function: upladProfileImg()
     * Description: Function use for edit profile photo   
     * By @Ahsan Ahamad
     * Date : 15 Jan 2018
     */

    public function upladProfileImg() {
        if ($this->request->is('post')) {
            $pathDocument = 'img/profile';
            $profileImg = $this->Upload->uploadImage($this->request->data['photo'], $pathDocument);
            $profile['profile_image'] = $profileImg;

            $users = $this->Users->get($this->Auth->user('id'));

            $users = $this->Users->patchEntity($users, $profile);
            if (!$users->errors()) {
                if ($this->Users->save($users)) {
                    $this->Flash->success(__('Profile photo has been changed successfully.'));
                    return $this->redirect(['controller' => 'users', 'action' => 'profile']);
                } else {
                    $this->Flash->error(__('profile photo could not be change'));
                    return $this->redirect(['controller' => 'users', 'action' => 'profile']);
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($users->errors())));
            }
        }
    }

    /* Function: resetPassword()
     * Description: function use for create new password 
     * @param type $emailVerification    
     * By @Ahsan Ahamad
     * Date : 26 setp. 2017
     */

    public function emailVerification($emailVerification = null) {
        $this->autoRender = false;
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
                $this->Flash->success(__('Email verification has been successfully.'));
            } else {
                $this->Flash->error(__('Email could not be verified'));
            }
        }
        return $this->redirect(['controller' => 'users', 'action' => 'login']);
    }

}
