<?php

namespace App\Controller\Admin;
;

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
        $user_id = $this->Auth->user('id');

        $conditions = ['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.role_id' => 3, 'Users.user_id' => $user_id];

        if (isset($this->request->query['name']) && $this->request->query['name'] != '') {
            $conditions['Users.name LIKE'] = '%' . $this->request->query['name'] . '%';
        }

        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }



        $this->paginate = [
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
            $password = mt_rand(10000000, 99999999);
            // $this->request->data['password'] = (new DefaultPasswordHasher)->hash($password);
            $this->request->data['role_id'] = 4;
            $this->request->data['password'] = $password;
            $staffs = $this->Users->newEntity($this->request->data);
            $this->Users->patchEntity($staffs, $this->request->data, ['validate' => 'Staff']);
            if (!$staffs->errors()) {
                if ($success = $this->Users->save($staffs)) {
                    $address['address1'] = trim($this->request->data['Address']['address1']);
                    $address['address2'] = trim($this->request->data['Address']['address2']);
                    $address['city'] = trim($this->request->data['Address']['city']);
                    $address['state_id'] = $this->request->data['Address']['state_id'];
                    $address['zipcode'] = trim($this->request->data['Address']['zipcode']);
                    $address['phone'] = $this->request->data['Address']['phone'];
                    $address['phone_extension'] = $this->request->data['Address']['phone_extension'];
                    $address['user_id'] = $success->id;

                    $addresses = $this->Addresses->newEntity();
                    $this->Addresses->patchEntity($addresses, $address);
                    $successAddress = $this->Addresses->save($addresses);

                    $permission['user_id'] = $success->id;
                    $permission['permission_id'] = $this->request->data['permission_id'];
                    $permission['added_by'] = $this->request->data['added_by'];
                    $permissions = $this->PermissionAccess->newEntity();
                    $this->PermissionAccess->patchEntity($permissions, $permission);
                    $successAddress = $this->Addresses->save($permissions);

                    /* code for send email verfication */

                    $data = array('token' => $success->email_verification, 'name' => $this->request->data['first_name'], 'password' => $password);
                    $to = $this->request->data['email'];
                    $template = 3;
                    $subject = 'Wellcome NYCompliance';
                    $send = $this->sendEmail($data, $to, $template, $subject);

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
        $permissions->where(['Permissions.user_id' => 1, 'Permissions.is_deleted' => 0, 'Permissions.is_active' => 1]);
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
                    $address['address1'] = trim($this->request->data['Address']['address1']);
                    $address['address2'] = trim($this->request->data['Address']['address2']);
                    $address['city'] = trim($this->request->data['Address']['city']);
                    $address['state_id'] = $this->request->data['Address']['state_id'];
                    $address['zipcode'] = trim($this->request->data['Address']['zipcode']);
                    $address['phone'] = $this->request->data['Address']['phone'];
                    $address['phone_extension'] = $this->request->data['Address']['phone_extension'];
                    $address['user_id'] = $success->id;

                    $addresses = $this->Addresses->get($this->request->data['Address']['id']);
                    $this->Addresses->patchEntity($addresses, $address);
                    $successAddress = $this->Addresses->save($addresses);

                    $permission['user_id'] = $success->id;
                    $permission['permission_id'] = $this->request->data['permission_id'];
                    $permission['added_by'] = $this->request->data['added_by'];
                    $permissions = $this->PermissionAccess->get($this->request->data['PermissionAcces']['id']);
                    $this->PermissionAccess->patchEntity($permissions, $permission);
                    $successAddress = $this->PermissionAccess->save($permissions);

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
        $staff = $this->Users->find()->contain(['Addresses', 'PermissionAccess'])->hydrate(false)
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
        $permissions->where(['Permissions.user_id' => 1, 'Permissions.is_deleted' => 0, 'Permissions.is_active' => 1]);
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
        $pageTitle = 'Staffs | View';
        $pageHedding = 'Staffs | View';
        $breadcrumb = array(
            array('label' => 'Staffs', 'link' => 'staffs/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        $id = $this->Encryption->decode($id);
        $staff = $this->Users->find()->contain(['Addresses', 'PermissionAccess'])->hydrate(false)
                        ->where(['Users.id =' => $id])->first();
        $this->set(compact('staff'));
    }

}
