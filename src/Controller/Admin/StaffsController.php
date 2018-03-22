<?php

namespace App\Controller\Admin;

;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Core\Configure;

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
        $pageTitle = 'Manage Staffs';
        $pageHedding = 'Manage Staffs';
        $breadcrumb = array(
            array('label' => 'Setting', 'link' => 'staffs/'),
            array('label' => 'Manage Staffs '),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        $conditions = ['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.user_id' => $this->LoggedCompanyId];
        if (isset($this->request->query['name']) && $this->request->query['name'] != '') {
            $conditions['OR']['Users.first_name LIKE'] = '%' . $this->request->query['name'] . '%';
            $conditions['OR']['Users.last_name LIKE'] = '%' . $this->request->query['name'] . '%';
            $conditions['OR']['Users.email LIKE'] = '%' . $this->request->query['name'] . '%';
        }
        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
            'contain' => ['EditedBy' => function($q) {
                    return $q->select(['EditedBy.id', 'EditedBy.first_name', 'EditedBy.last_name']);
                }],
            'conditions' => $conditions,
            'order' => ['Users.id' => 'DESC'],
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
        $pageTitle = 'Add Staff';
        $pageHedding = 'Add Staff';
        $breadcrumb = array(
            array('label' => 'Manage Staffs', 'link' => 'staffs/'),
            array('label' => 'Add'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {

            $this->loadModel('Users');
            $this->loadModel('PermissionAccess');
            $this->loadModel('Addresses');
            $this->request->data['created'] = date('Y-m-d');
            $this->request->data['added_by'] = Configure::read('LoggedUserId');
            $this->request->data['user_id'] = Configure::read('LoggedCompanyId');
            $this->request->data['role_id'] = 4;
            $this->request->data['email_verification'] = $this->Custom->token();
            $password = mt_rand(10000000, 99999999);
            $this->request->data['password'] = $password;
            $staffs = $this->Users->newEntity($this->request->data);
            $this->Users->patchEntity($staffs, $this->request->data, ['validate' => 'Staff']);
            if (!$staffs->errors()) {
                if ($success = $this->Users->save($staffs)) {
                    $this->_updatedBy('Users', $success->id);
                    /* === Added by vipin for  add log=== */
                    $staff_member_name = $this->request->data('first_name') . ' ' . $this->request->data('last_name');
                    $message = 'Staff memeber ' . $staff_member_name . ' Added by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'users';
                    $saveActivityLog['module_name'] = 'Staff';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Add';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */


                    $this->request->data['Address']['user_id'] = $success->id;
                    $this->request->data['Address']['added_by'] = Configure::read('LoggedUserId');

                    $addresses = $this->Addresses->newEntity();
                    $this->Addresses->patchEntity($addresses, $this->request->data['Address']);
                    $successAddress = $this->Addresses->save($addresses);

                    /* code for send email verfication */
                    $this->loadModel('EmailTemplates');
                    $link = BASE_URL . '/admin/users/emailVerification/' . $success->email_verification;
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
        $permissions->where(['Permissions.user_id' => 1, 'Permissions.is_deleted' => 0, 'Permissions.is_admin' => 1, 'Permissions.is_active' => 1]);
        $permissionsList = $permissions->toArray();

        $this->set(compact('statesList', 'permissionsList'));
    }

    /* Function:edit() 
     * Description: function use for edit staff of the auth loger client
     * @param type: $id 
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Edit Staff ';
        $pageHedding = 'Edit Staff';
        $breadcrumb = array(
            array('label' => 'Manage Staffs', 'link' => 'staffs/'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        $this->loadModel('Addresses');
        if ($this->request->is('post')) {
            $this->loadModel('Users');
            //$this->loadModel('PermissionAccess');
            $this->loadModel('Addresses');
            $this->request->data['created'] = date('Y-m-d');
            $this->request->data['added_by'] = $this->Auth->user('id');
            $this->request->data['user_id'] = $this->Auth->user('id');
            $staffs = $this->Users->get($this->request->data['id']);
            $this->Users->patchEntity($staffs, $this->request->data);
            if (!$staffs->errors()) {
                if ($success = $this->Users->save($staffs)) {
                    $this->_updatedBy('Users', $success->id);
                    /* === Added by vipin for  add log=== */
                    $staff_member_name = $this->request->data('first_name') . ' ' . $this->request->data('last_name');
                    $message = 'Staff memeber ' . $staff_member_name . ' Updated by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'users';
                    $saveActivityLog['module_name'] = 'Staff';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */


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

                    $permission['user_id'] = $success->id;
                    $permission['permission_id'] = $this->request->data['permission_id'];
                    $permission['added_by'] = $this->request->data['added_by'];

                    /* if ($this->request->data['PermissionAcces']['id']) {
                      $permissions = $this->PermissionAccess->get($this->request->data['PermissionAcces']['id']);
                      } else {
                      $permissions = $this->PermissionAccess->newEntity();
                      }

                      $this->PermissionAccess->patchEntity($permissions, $permission);
                      $successAddress = $this->PermissionAccess->save($permissions); */

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
        $permissions->where(['Permissions.user_id' => 1, 'Permissions.is_deleted' => 0, 'Permissions.is_admin' => 1, 'Permissions.is_active' => 1]);
        $permissionsList = $permissions->toArray();

        $this->set(compact('statesList', 'permissionsList', 'this->request->data'));
    }

    /* Function:view() 
     * Description: function use for view staff of the auth loger client 
     * @param type: $id
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function view($id = null) {
        $pageTitle = 'View Staff';
        $pageHedding = 'View Staff';
        $breadcrumb = array(
            array('label' => 'Manage Staffs', 'link' => 'staffs/'),
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
