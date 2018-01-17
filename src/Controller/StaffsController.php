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
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Staffs';
        $pageHedding = 'Staffs';
        $breadcrumb = array(
            array('label' => 'Staffs'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Users');
        $user_id = $this->Auth->user('id');
        $conditions = ['Users.is_deleted' => 0, 'Users.role_id' => 3, 'Users.user_id' => $user_id];
        if (@$this->request->query['first_name'] != '' && @$this->request->query['status'] != '') {
            $conditions = ['Users.is_deleted' => 0, 'Users.first_name LIKE' => '%' . $this->request->query['first_name'] . '%', 'Users.is_active' => $this->request->query['status']];
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
            $this->request->data['created'] = date('Y-m-d');
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['role_id'] = 3;
            $staffs = $this->Users->newEntity($this->request->data);
            $this->Users->patchEntity($staffs, $this->request->data);
            if (!$staffs->errors()) {
                $success = $this->Users->save($staffs);
                if ($success) {
                    $this->Flash->success(__('Staff has been saved successfully.'));
                    return $this->redirect(['controller' => 'staffs', 'action' => 'index']);
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($staffs->errors())));
            }
        }
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
            $id = $this->request->data['id'];
            $staffs = $this->Users->get($id);
            //$staffs = $this->Users->newEntity();
            $this->Users->patchEntity($staffs, $this->request->data, ['validate' => 'Default']);
            if (!$staffs->errors()) {
                $success = $this->Users->save($staffs);
                if ($success) {
                    $this->Flash->success(__('Staff has been updated successfully.'));
                    return $this->redirect(['controller' => 'staffs', 'action' => 'index']);
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($staffs->errors())));
            }
        }

        $id = $this->Encryption->decode($id);
        $staff = $this->Users->find()->hydrate(false)
                        ->where(['Users.id =' => $id])->first();
        $this->set(compact('staff'));
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
        $staff = $this->Users->find()->hydrate(false)
                        ->where(['Users.id =' => $id])->first();
        $this->set(compact('staff'));
    }

}
