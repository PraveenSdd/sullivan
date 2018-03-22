<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class StaffsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash');
    }

    /* Function:index() 
     * Description: function use for get all staff list of the auth loger client 
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function index() {
        $pageTitle = 'Staffs';
        $pageHedding = 'Staffs';
        $breadcrumb = array(
            array('label' => 'Staffs'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        if ($this->Auth->user('user_id') == 0) {
            $user_id = $this->Auth->user('id');
            $conditions = ['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.user_id' => $user_id];
        } else {
            $user_id = $this->Auth->user('user_id');
            $conditions = ['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.user_id' => $user_id, 'Users.id <>' => $this->Auth->user('id')];
        }


        $this->paginate = [
            'contain' => ['EditedBy' => function($q) {
                    return $q->select(['EditedBy.id', 'EditedBy.first_name', 'EditedBy.last_name']);
                }],
            'conditions' => $conditions,
            'order' => ['Users.first_name' => 'asc'],
            'limit' => 10,
        ];
        $staffs = $this->paginate($this->Users);
        $this->set(compact('staffs'));
    }

    /* Function:add() 
     * Description: function use for add nwe staff of the auth loger client 
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function add() {
        $pageTitle = 'Staffs | Add';
        $pageHedding = 'Staffs | Add';
        $breadcrumb = array(
            array('label' => 'Staffs', 'link' => 'staffs/'),
            array('label' => 'Add'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {

            $this->loadModel('Users');
            $this->loadModel('PermissionAccess');
            $this->loadModel('Addresses');
            $this->request->data['created'] = date('Y-m-d');
            $this->request->data['added_by'] = $this->Auth->user('id');
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['email_verification'] = $this->Custom->token();
            $password = $this->request->data['password'];
            $this->request->data['is_verify'] = 1;
            // $this->request->data['password'] = (new DefaultPasswordHasher)->hash($password);
            $this->request->data['role_id'] = 3;
            $staffs = $this->Users->newEntity($this->request->data);
            $this->Users->patchEntity($staffs, $this->request->data, ['validate' => 'Staff']);
            if (!$staffs->errors()) {
                if ($success = $this->Users->save($staffs)) {
                    $this->_updatedBy('Users', $success->id);
                    $address['address1'] = trim($this->request->data['Address']['address1']);
                    $address['address2'] = trim($this->request->data['Address']['address2']);
                    $address['city'] = trim($this->request->data['Address']['city']);
                    $address['state_id'] = $this->request->data['Address']['state_id'];
                    $address['zipcode'] = trim($this->request->data['Address']['zipcode']);

                    $address['user_id'] = $success->id;

                    $addresses = $this->Addresses->newEntity();
                    $this->Addresses->patchEntity($addresses, $address);
                    $successAddress = $this->Addresses->save($addresses);

                    /* code for send email verfication */

                    /* code for send email verfication */
                    $this->loadModel('EmailTemplates');
                    $token = $this->request->data['email_verification'];
                    $link = BASE_URL . '/users/emailVerification/' . $token;
                    $emailTemplate = $this->EmailTemplates->find()->where(['id' => 4])->first();
                    $emailData = $emailTemplate->description;
                    if (!empty($this->request->data['last_name'])) {
                        $fullName = $this->request->data['first_name'] . " " . $this->request->data['last_name'];
                    } else {
                        $fullName = $this->request->data['first_name'];
                    }
                    $emailData = str_replace('{USER_NAME}', $fullName, $emailData);
                    $emailData = str_replace('{LINK}', $link, $emailData);
                    $emailData = str_replace('{PASSWORD}', $password, $emailData);
                    $subject = $emailTemplate->subject;
                    $to = $this->request->data['email'];
                    $this->_sendSmtpMail($subject, $emailData, $to);
                    /* === Added by vipin for  add log=== */
                    $message = 'Staff added by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'users';
                    $saveActivityLog['module_name'] = 'Staff Front';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Add';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */
                    $this->Flash->success(__('Staff has been saved successfully.'));
                    return $this->redirect(['controller' => 'staffs', 'action' => 'index']);
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($staffs->errors())));
            }
        }
        /*  get all us state  list */
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();
        /*  get all us Permissions  list */
        $this->loadModel('Permissions');
        $permissions = $this->Permissions->find('list');
        $permissions->where(['Permissions.user_id' => 1, 'Permissions.is_deleted' => 0, 'Permissions.is_admin' => 0, 'Permissions.is_active' => 1]);
        $permissionsList = $permissions->toArray();

        $this->loadModel('UserLocations');
        $userLocation = $this->UserLocations->find()->hydrate(false)
                        ->where(['UserLocations.user_id =' => $this->LoggedCompanyId, 'UserLocations.is_company' => 1])->first();
        $this->set(compact('statesList', 'permissionsList','userLocation'));
    }

    /* Function:edit() 
     * Description: function use for edit staff of the auth loger client
     * @param type $id
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Staffs | Edit';
        $pageHedding = 'Staffs | Edit';
        $breadcrumb = array(
            array('label' => 'Staffs', 'link' => 'staffs/'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        if ($this->request->is('post')) {
            $this->loadModel('Users');
            $this->loadModel('PermissionAccess');
            $this->loadModel('Addresses');
            $this->request->data['created'] = date('Y-m-d');
            $this->request->data['added_by'] = $this->Auth->user('id');
            $this->request->data['user_id'] = $this->Auth->user('id');

            $staffs = $this->Users->get($this->request->data['id']);
            $this->Users->patchEntity($staffs, $this->request->data);
            if (!$staffs->errors()) {
                if ($success = $this->Users->save($staffs)) {
                    $this->_updatedBy('Users', $success->id);
                    $address['address1'] = trim($this->request->data['Address']['address1']);
                    $address['address2'] = trim($this->request->data['Address']['address2']);
                    $address['city'] = trim($this->request->data['Address']['city']);
                    $address['state_id'] = $this->request->data['Address']['state_id'];
                    $address['zipcode'] = trim($this->request->data['Address']['zipcode']);
                    $address['user_id'] = $success->id;
                    if ($this->request->data['Address']['id']) {
                        $addresses = $this->Addresses->get($this->request->data['Address']['id']);
                    } else {
                        $addresses = $this->Addresses->newEntity();
                    }
                    $this->Addresses->patchEntity($addresses, $address);
                    $successAddress = $this->Addresses->save($addresses);
                    /* === Added by vipin for  add log=== */
                    $message = 'Staff detail edit by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'users';
                    $saveActivityLog['module_name'] = 'Staff Front';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */

                    $this->Flash->success(__('Staff has been updated successfully.'));
                    return $this->redirect(['controller' => 'staffs', 'action' => 'index']);
                } else {
                    $this->Flash->success(__('Staff could not updated successfully.'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($staffs->errors())));
            }
        }

        $id = $this->Encryption->decode($id);
        $staff = $this->Users->find()->contain(['Addresses'])->hydrate(false)
                        ->where(['Users.id =' => $id])->first();
        $this->request->data = $staff;

        /*  get all us state  list */
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();
        /*  get all us Permissions  list */
        $this->loadModel('Permissions');
        $permissions = $this->Permissions->find('list');
        $permissions->where(['Permissions.user_id' => 1, 'Permissions.is_deleted' => 0, 'Permissions.is_admin' => 0, 'Permissions.is_active' => 1]);
        $permissionsList = $permissions->toArray();

        $this->set(compact('statesList', 'permissionsList', 'this->request->data'));
    }

    /* Function:view() 
     * Description: function use for view staff of the auth loger client
     * @param type $id
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Staffs | View';
        $pageHedding = 'Staffs | View';
        $breadcrumb = array(
            array('label' => 'Staffs', 'link' => 'staffs/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        $id = $this->Encryption->decode($id);
        $staff = $this->Users->find()->contain(['Addresses'])->hydrate(false)
                        ->where(['Users.id =' => $id])->first();
        $this->set(compact('staff'));
    }

}
