<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Model\Table\Users;

class AlertsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamads
     * Date : 2nd Nov. 2017
     */

    public $paginate = [
        'limit' => 5,
        'order' => [
            'Alerts.tile' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        if (!$this->request->getParam('admin') && $this->Auth->user('role_id') != 1 && $this->Auth->user('role_id') != 4) {
            return $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $this->loadComponent('Upload');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * @Function: index()
     * @Description: use for listing of alerts
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'Manage Alerts';
        $pageHedding = 'Manage Alerts';
        $breadcrumb = array(
            array('label' => 'Manage Alerts'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $conditions = ['Alerts.is_deleted' => 0, 'Alerts.is_active' => 1];
        if (!empty($this->request->query)) {
            if (isset($this->request->query['title']) && $this->request->query['title'] != '') {
                $conditions['LOWER(Alerts.title) LIKE'] = '%' . strtolower(trim($this->request->query['title'])) . '%';
            }
            # Save searched value in search-form input-fields
            $this->request->data = $this->request->query;
        }

        $orCondition = ['Alerts.is_admin' => 1];
        if ($this->LoggedRoleId == 1) {
            $orCondition['Alerts.alert_type_id IN'] = [1, 2];
        } else {
            $orCondition['Alerts.alert_type_id'] = 2;
        }
        $this->paginate = [
            'conditions' => ['OR' => $orCondition, 'AND' => $conditions],
            'contain' => ['AlertTypes', 'AlertStaffs.Users', 'AlertPermits.Permits', 'Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'order' => ['Alerts.title' => 'asc'],
            'limit' => 10,
        ];

        $alerts = $this->paginate($this->Alerts);
        $this->set(compact('alerts'));
    }

    /**
     * 
     * @return type
     */
    public function add() {
        $pageTitle = 'Add Alert';
        $pageHedding = 'Add Alert';
        $breadcrumb = array(
            array('label' => 'Manage Alerts', 'link' => 'alerts/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        if ($this->request->is('post')) {
            $this->request->data['Alert']['id'] = null;
            $response = $this->Alerts->saveAdminData($this->request->data['Alert']);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                $this->_updatedBy('Alerts', $response['id']);
                /* === Added by vipin for  add log=== */
                $message = 'Alert added by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'alerts';
                $saveActivityLog['module_name'] = 'Alert';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Add';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__('Alerts has been added successfully.'));
                return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
            }
        }
        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getAlertType();
        $this->set(compact('alertTypeList'));

        $this->loadModel('Users');
        $subAdminList = $this->Users->getSullivanStaffList();
        $this->set(compact('subAdminList'));

        $companyList = $this->Users->getCompanyList();
        $this->set(compact('companyList'));

        $this->loadModel('Operations');
        $operationList = $this->Operations->getList();
        $this->set(compact('operationList'));
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function edit($alertId = null) {
        $this->set(compact('alertId'));
        $pageTitle = 'Edit Alert';
        $pageHedding = 'Edit Alert';
        $breadcrumb = array(
            array('label' => 'Manage Alerts', 'link' => 'alerts/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));


        $alertId = $this->Encryption->decode($alertId);
        $alerts = $this->Alerts->getDataId($alertId);
        if (empty($alertId)) {
            $this->Flash->error(__('Permit not available!'));
            return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('alerts'));

        if ($this->request->is('post')) {
            $this->request->data['Alert']['id'] = $alertId;
            $response = $this->Alerts->saveAdminData($this->request->data['Alert']);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                $this->_updatedBy('Alerts', $response['id']);
                /* === Added by vipin for  add log=== */
                $message = 'Alert updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'alerts';
                $saveActivityLog['module_name'] = 'Alert';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__('Alerts has been updated successfully.'));
                return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
            }
        }

        if (empty($this->request->data)) {
            $this->request->data['Alert'] = $alerts;
        }

        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getAlertType();
        $this->set(compact('alertTypeList'));

        $this->loadModel('Users');
        $subAdminList = $this->Users->getSullivanStaffList();
        $this->set(compact('subAdminList'));

        $companyList = $this->Users->getCompanyList();
        $this->set(compact('companyList'));

        $this->loadModel('Operations');
        $operationList = $this->Operations->getList();
        $this->set(compact('operationList'));
    }

    /* @Function: view()
     * @Description: function use for view particular alert
     * @param: $id if the alert
     * @By @Ahsan Ahamad
     * @Date : 23rd Nov. 2017
     */

    public function view($alertId, $alertNotificationId = null) {
        $this->set(compact('alertId', 'alertNotificationId'));
        $pageTitle = 'View Alert ';
        $pageHedding = 'View Alert';
        $breadcrumb[] = array('label' => 'Alerts', 'link' => 'alerts/');
        if ($alertNotificationId) {
            $breadcrumb[] = array('label' => 'Notifications', 'link' => 'alerts/notification');
            $alertNotificationId = $this->Encryption->decode($alertNotificationId);
            $this->loadModel('AlertNotifications');
            $this->AlertNotifications->updateAll(['is_readed' => 1], ['id' => $alertNotificationId, 'user_id' => Configure::read('LoggedUserId')]);
        }
        $breadcrumb[] = array('label' => 'View');
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $alertId = $this->Encryption->decode($alertId);
        $alerts = $this->Alerts->find()->contain(['AlertTypes', 'AlertStaffs', 'AlertStaffs.Users', 'AlertCompanies', 'AlertCompanies.Users', 'AlertOperations', 'AlertOperations.Operations'])->where(['Alerts.id' => $alertId, 'Alerts.is_active' => 1, 'Alerts.is_deleted' => 0])->first();
        if (empty($alertId)) {
            $this->Flash->error(__('Alert not available!'));
            return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('alerts'));
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
                    return $q->select(['Alerts.title', 'Alerts.id', 'Alerts.is_admin', 'Alerts.added_by'], 'AlertNotifications.is_unsubscribed')->where(['Alerts.is_active' => 1, 'Alerts.is_deleted' => 0,]);
                }
            ], 'order' => ['AlertNotifications.created' => 'desc'], 'limit' => 10];
        $alertNotifications = $this->paginate($this->AlertNotifications);
        $this->set(compact('alertNotifications', 'breadcrumb', 'pageTitle', 'pageHedding'));
    }

    /* @Function: getAlertList()
     * @Description: function use for all alerts lising 
     * @param: $id if the alert
     * @By @Ahsan Ahamad
     * @Date : 23rd Nov. 2017
     */

    public function getAlertList() {
        $this->loadModel('Categories');
        $this->loadModel('Industries');
        $this->autoRender = FALSE;
        $id = $this->request->data['id'];
        if ($id == 3) {
            $this->loadModel('Users');
            $lists = $this->Users->getCompanyList();
            $listHtml = '<option value="">-- Select Companies -- </option>';
        }
        if ($id == 4) {
            $industries = $this->Industries->find('list');
            $industries->hydrate(false)->where(['Industries.is_deleted' => 0, 'Industries.is_active' => 1]);
            $lists = $industries->toArray();
            $listHtml = '<option value="">-- Select Industries -- </option>';
        }

        $listArray = array();

        foreach ($lists as $key => $value) {
            $listHtml .= '<option value="' . $key . '">' . $value . '</option>';
            $listArray[$key] = $value;
        }
        echo $listHtml;
        exit;
    }

}
