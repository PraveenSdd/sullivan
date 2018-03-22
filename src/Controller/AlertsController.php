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
        $alertList = $this->_getAlertListForUser();
        if (!empty($alertList)) {
            $this->paginate = [
                'conditions' => ['OR' => ['Alerts.id IN' => $alertList, 'Alerts.user_id' => $this->LoggedCompanyId], 'AND' => ['Alerts.is_active' => 1, 'Alerts.is_deleted' => 0]],
                'contain' => ['AlertTypes', 'AlertStaffs.Users', 'AlertPermits.Permits', 'Users' => function($q) {
                        return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                    }],
                'order' => ['Alerts.title' => 'asc'],
                'limit' => 10,
            ];

            $alerts = $this->paginate($this->Alerts);
        }
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
        $pageHedding = 'Add Alert';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'alerts/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $this->request->data['Alert']['id'] = null;
            $response = $this->Alerts->saveCompanyData($this->request->data['Alert']);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                $this->_updatedBy('Alerts', $response['id']);
                /* === Added by vipin for  add log=== */
                $message = 'Alert added by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'alerts';
                $saveActivityLog['module_name'] = 'Alert Front';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Add';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__('Alerts has been added successfully.'));
                return $this->redirect(['controller' => 'alerts', 'action' => 'index']);
            }
        }

        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getCompanyAlertType();
        $this->set(compact('alertTypeList'));

        $this->loadModel('Users');
        $companyStaffList = $this->Users->getStaffList(Configure::read('LoggedCompanyId'));
        $this->set(compact('companyStaffList'));
    }

    /*
     *  Function: edit()
     * Description:use for edit alert
     * @param type $id
     * @return type
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function edit($alertId) {
        $this->set(compact('alertId'));
        $pageTitle = 'Alerts | Edit';
        $pageHedding = 'Edit Alert';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'alerts/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $alertId = $this->Encryption->decode($alertId);
        $alerts = $this->Alerts->getDataId($alertId);
        if (empty($alertId)) {
            $this->Flash->error(__('Alert not available!'));
            return $this->redirect(['controller' => 'alerts', 'action' => 'index']);
        }
        $this->set(compact('alerts'));

        if ($this->request->is('post')) {
            $this->request->data['Alert']['id'] = $alertId;
            $response = $this->Alerts->saveCompanyData($this->request->data['Alert']);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                $this->_updatedBy('Alerts', $response['id']);
                /* === Added by vipin for  add log=== */
                $message = 'Alert updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'alerts';
                $saveActivityLog['module_name'] = 'Alert Front';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                $this->Flash->success(__('Alerts has been updated successfully.'));
                return $this->redirect(['controller' => 'alerts', 'action' => 'index']);
            }
        }

        if (empty($this->request->data)) {
            $this->request->data['Alert'] = $alerts;
        }

        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getCompanyAlertType();
        $this->set(compact('alertTypeList'));

        $this->loadModel('Users');
        $companyStaffList = $this->Users->getStaffList(Configure::read('LoggedCompanyId'));
        $this->set(compact('companyStaffList'));
    }

    /* Function: view()
     * Description: function use for view particular get data by select id
     * @param type $id
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function view($alertId, $alertNotificationId = null) {
        $this->set(compact('alertId'));
        $pageTitle = 'Alerts | View';
        $pageHedding = 'View Alerts';
        $breadcrumb[] = array('label' => 'Alerts', 'link' => 'alerts/');
        if ($alertNotificationId) {
            $breadcrumb[] = array('label' => 'Notifications', 'link' => 'alerts/notification');
        }
        $breadcrumb[] = array('label' => 'View');
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $alertId = $this->Encryption->decode($alertId);
        $alerts = $this->Alerts->getAllDataId($alertId);
        if (empty($alertId)) {
            $this->Flash->error(__('Alert not available!'));
            return $this->redirect(['controller' => 'alerts', 'action' => 'index']);
        }
        $this->set(compact('alerts'));
        if (!empty($alertNotificationId)) {
            $alertNotificationId = $this->Encryption->decode($alertNotificationId);
            $this->loadModel('AlertNotifications');
            $this->AlertNotifications->updateAll(['is_readed' => 1], ['id' => $alertNotificationId, 'user_id' => Configure::read('LoggedUserId')]);
            if (!empty($alerts->is_repeated)) {
                $isSubscribed = $this->AlertNotifications->find()
                        ->hydrate(false)
                        ->select(['AlertNotifications.is_unsubscribed'])
                        ->where(['id' => $alertNotificationId])
                        ->first();
            }
        }
        $this->set(compact('alertNotificationId', 'isSubscribed'));
    }

    public function notification() {
        $pageTitle = 'Alert Notifications';
        $pageHedding = 'Alert Notifications';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'alerts/'),
            array('label' => 'Notifications'),
        );
        $this->loadModel('AlertNotifications');
        $conditions = ['AlertNotifications.is_deleted' => 0, 'AlertNotifications.user_id' => Configure::read('LoggedUserId')];
        $this->paginate = ['conditions' => $conditions, 'contain' => ['Alerts' => function($q) {
                    return $q->select(['Alerts.title', 'Alerts.id', 'Alerts.is_admin', 'Alerts.added_by'], 'AlertNotifications.is_unsubscribed')->where(['Alerts.is_active' => 1, 'Alerts.is_deleted' => 0]);
                }
            ], 'order' => ['AlertNotifications.created' => 'desc'], 'limit' => 10];
        $alertNotifications = $this->paginate($this->AlertNotifications);
        $this->set(compact('alertNotifications', 'breadcrumb', 'pageTitle', 'pageHedding'));
    }

    /*
     * @Functon:saveAgencyData()
     * @Description: use for subscribe-unsubscribe alert
     * @By 
     * @Date : 
     */

    public function subscribeUnsubscribeAlert() {
        $this->autoRender = false;
        if ($this->request->is('ajax') && !empty($this->request->data['alertNotificationId'])) {
            $alertNotificationId = $this->Encryption->decode($this->request->data['alertNotificationId']);
            $status = $this->request->data['status'];
            $this->loadModel('AlertNotifications');
            $result = $this->AlertNotifications->updateAll(['is_unsubscribed' => $status], ['id' => $alertNotificationId]);
            if ($result) {
                $responce['flag'] = true;
                if ($status) {
                    $responce['msg'] = "Alert unsubscribed successfully.";
                } else {
                    $responce['msg'] = "Alert subscribed successfully.";
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = "Something went wrong!";
            }
            echo json_encode($responce);
            exit;
        }
    }

}
