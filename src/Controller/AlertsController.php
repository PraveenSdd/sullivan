<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class AlertsController extends AppController {

    public $paginate = [
        'limit' => 5,
        'order' => [
            'Alerts.tile' => 'asc'
        ]
    ];

    public function initialize() {

        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /* Function:inex()
     * Description: use for get all alrts listing 
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'Alerts';
        $pageHedding = 'Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Alerts');
        $conditions = ['Alerts.is_deleted' => 0, 'Alerts.user_id' => $this->Auth->user('id')];
        if (@$this->request->query['title'] != '' && @$this->request->query['status'] != '') {
            $conditions = ['Alerts.is_deleted' => 0, 'Alerts.question LIKE' => '%' . $this->request->query['title'] . '%', 'Alerts.is_active' => $this->request->query['status']];
        } else if (@$this->request->query['title'] != '') {
            $conditions = ['Alerts.is_deleted' => 0, 'Alerts.question LIKE' => '%' . $this->request->query['title'] . '%'];
        } else if (@$this->request->query['status'] != '') {
            $conditions = ['Alerts.is_deleted' => 0, 'Alerts.is_active' => $this->request->query['status']];
        }
        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }


        $this->paginate = [
            'conditions' => $conditions,
            'contain' => ['AlertTypes', 'AlertStaffs.Users', 'AlertPermits.Permits'],
            'order' => ['Alerts.title' => 'asc'],
            'limit' => 10,
        ];
        $alerts = $this->paginate($this->Alerts);

        $this->set(compact('alerts'));
    }

    /*
     *  Function: add()
     * Description:use for create new alert
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function add() {
        $pageTitle = 'Alerts | Add';
        $pageHedding = 'Add Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'faqs/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->Auth->user('role_id') == 3) {
            $userId = $this->Auth->user('user_id');
        } else {
            $userId = $this->Auth->user('id');
        }
        if ($this->request->is('post')) {

            $this->loadModel('AlertStaffs');
            $this->loadModel('Users');
            $this->loadModel('AlertPermits');

            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $this->request->data['user_id'] = $this->userId;
            if (!empty($this->request->data['interval'])) {
                $this->request->data['interval_alert'] = (int) $this->request->data['interval'];
            }
            $alerts = $this->Alerts->newEntity();
            $this->Alerts->patchEntity($alerts, $this->request->data, ['validate' => 'Add']);
            if (!$alerts->errors()) {
                $success = $this->Alerts->save($alerts);

                if ($success) {

                    /* code for save alert Staff */
                    if (!empty($this->request->data['staff_id']) && $this->request->data['alert_type_id'] == 3) {

                        foreach ($this->request->data['staff_id'] as $key => $value) {
                            $staff['user_id'] = $value;
                            $staff['created'] = date('Y-m-d');
                            $staff['alert_id'] = $success->id;
                            $staff['alert_type_id'] = $this->request->data['alert_type_id'];
                            $staffs = $this->AlertStaffs->newEntity();
                            $this->AlertStaffs->patchEntity($staffs, $staff);
                            $successAlert = $this->AlertStaffs->save($staffs);
                        }
                        if ($successAlert) {
                            $staffs = $this->Users->find('list', ['valueField' => 'email']);
                            $staffs->hydrate(false)->select(['Users.email'])->where(['Users.id in' => $this->request->data['staff_id'], 'Users.is_deleted' => 0, 'Users.is_active' => 1]);
                            $emails = $staffs->toArray();
                            /* code for send email to multiple users and companies */
                            $template = 'new_alert';
                            $subject = "New Alerts";
                            $this->Custom->sendMultipleEmail($emails, $template, $subject);
                        }
                    }
                    /* code for save alert industry */
                    if (!empty($this->request->data['form_id'])) {
                        $value = $this->request->data['form_id'];
                        $permit['form_id'] = $value;
                        $permit['created'] = date('Y-m-d');
                        $permit['alert_id'] = $success->id;
                        $permit['alert_type_id'] = $this->request->data['alert_type_id'];
                        $permits = $this->AlertPermits->newEntity();
                        $this->AlertPermits->patchEntity($permits, $permit);
                        $successAlert = $this->AlertPermits->save($permits);
                    }
                    $this->Flash->success(__('Alerts has been saved successfully.'));
                    return $this->redirect(['controller' => 'alerts', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Alerts could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($alerts->errors())));
            }
        }

        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_user' => 1, 'AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();

        $this->loadModel('Permits');
        $permits = $this->Permits->find('list', ['keyField' => 'form_id', 'valueField' => 'form_id']);
        $permits->hydrate(false)->select(['form_id'])->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1, 'Permits.user_id' => $userId]);
        $permitsList = $permits->toArray();
        if (!empty($permitsList)) {
            $this->loadModel('Forms');
            $forms = $this->Forms->find('list');
            $forms->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.is_active' => 1, 'Forms.id in' => $permitsList]);
            $formsList = $forms->toArray();
        }
        /* get all Operation list */
        $this->loadModel('Operations');
        $operations = $this->Operations->find('list');
        $operations->hydrate(false)->where(['Operations.is_deleted' => 0]);
        $operationsLists = $operations->toArray();
        $this->set(compact('operationsLists'));
        /* get all company list */
        $this->loadModel('Users');
        $userslist = $this->Users->getStaffList($userId, 3);
        $this->set(compact('userslist', 'alertTypesList', 'formsList'));
        $this->set('_serialize', ['userslist', 'alertTypesList', 'formsList']);
    }

    /*
     *  Function: edit()
     * Description:use for edit alert
     * @param type $id
     * @return type
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Alerts | Edit';
        $pageHedding = 'Add Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'faqs/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->Auth->user('role_id') == 3) {
            $userId = $this->Auth->user('user_id');
        } else {
            $userId = $this->Auth->user('id');
        }
        if ($this->request->is('post')) {
            $this->loadModel('AlertStaffs');
            $this->loadModel('Users');
            $this->loadModel('AlertPermits');
            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $this->request->data['user_id'] = $this->userId;
            if (!empty($this->request->data['interval'])) {
                $this->request->data['interval_alert'] = (int) $this->request->data['interval'];
            }
            $alerts = $this->Alerts->newEntity();
            $this->Alerts->patchEntity($alerts, $this->request->data, ['validate' => 'Add']);
            if (!$alerts->errors()) {
                $success = $this->Alerts->save($alerts);

                if ($success) {

                    /* code for save alert Staff */
                    if (!empty($this->request->data['staff_id']) && $this->request->data['alert_type_id'] == 3) {

                        $conditionstaff = array('AlertStaffs.alert_id in' => $this->request->data['id']);
                        $delStaff = $this->AlertStaffs->deleteAll($conditionstaff, false);

                        foreach ($this->request->data['staff_id'] as $key => $value) {
                            $staff['user_id'] = $value;
                            $staff['created'] = date('Y-m-d');
                            $staff['alert_id'] = $success->id;
                            $staff['alert_type_id'] = $this->request->data['alert_type_id'];
                            $staffs = $this->AlertStaffs->newEntity();
                            $this->AlertStaffs->patchEntity($staffs, $staff);
                            $successAlert = $this->AlertStaffs->save($staffs);
                        }
                        if ($successAlert) {
                            $staffs = $this->Users->find('list', ['valueField' => 'email']);
                            $staffs->hydrate(false)->select(['Users.email'])->where(['Users.id in' => $this->request->data['staff_id'], 'Users.is_deleted' => 0, 'Users.is_active' => 1]);
                            $emails = $staffs->toArray();
                            /* code for send email to multiple users and companies */
                            $template = 'new_alert';
                            $subject = "New Alerts";
                            $this->Custom->sendMultipleEmail($emails, $template, $subject);
                        }
                    }
                    /* code for save alert industry */
                    if (!empty($this->request->data['form_id'])) {
                        $value = $this->request->data['form_id'];
                        $permit['form_id'] = $value;
                        $permit['created'] = date('Y-m-d');
                        $permit['alert_id'] = $success->id;
                        $permit['alert_type_id'] = $this->request->data['alert_type_id'];
                        $permits = $this->AlertPermits->newEntity();
                        $this->AlertPermits->patchEntity($permits, $permit);
                        $successAlert = $this->AlertPermits->save($permits);
                    }
                    $this->Flash->success(__('Alerts has been updated successfully.'));
                    return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Alerts could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($alerts->errors())));
            }
        }
        /* get all Alert type list */

        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_user' => 1, 'AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        /* get all Permits list */

        $this->loadModel('Permits');
        $permits = $this->Permits->find('list', ['keyField' => 'form_id', 'valueField' => 'form_id']);
        $permits->hydrate(false)->select(['form_id'])->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1, 'Permits.user_id' => $userId]);
        $permitsList = $permits->toArray();

        $this->loadModel('Forms');
        $forms = $this->Forms->find('list');
        $forms->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.is_active' => 1, 'Forms.id in' => $permitsList]);
        $formsList = $forms->toArray();
        $this->loadModel('Users');
        $userslist = $this->Users->getStaffList($userId, 3);

        /* get all alert details */

        $id = $this->Encryption->decode($id);
        $alert = $this->Alerts->find()->contain(['AlertTypes', 'AlertStaffs', 'AlertPermits'])->where(['Alerts.id =' => $id, 'Alerts.is_active =' => 1, 'Alerts.is_deleted =' => 0])->first();

        $this->set(compact('userslist', 'alertTypesList', 'formsList', 'alert'));
        $this->set('_serialize', ['userslist', 'alertTypesList', 'formsList']);
    }

    /* Function: view()
     * Description: function use for view particular get data by select id
     * @param type $id
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Alerts | View';
        $pageHedding = 'View Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'faqs/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $alert = $this->Alerts->find()->contain(['AlertTypes', 'AlertStaffs.Users', 'AlertPermits'])->where(['Alerts.id =' => $id, 'Alerts.is_active =' => 1, 'Alerts.is_deleted =' => 0])->first();

        $this->set(compact('alert'));
    }

}
