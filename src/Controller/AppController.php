<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\View\Helper;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;

class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public $helpers = ['Encryption', 'Flash', 'Custom'];
    public $companyId;
    public $emaployeeId;
    public $userId;
    public $subAdminAdd = 0;
    public $subAdminEdit = 0;
    public $subAdminDelete = 0;
    public $CompanyAdminAdd = 0;
    public $CompanyAdminEdit = 0;
    public $CompanyAdminDelete = 0;
    public $CompanyAdminStaff = 0;
    public $LoggedRoleId = 0;
    public $LoggedPermissionId = 0;
    public $LoggedUserId = 0;
    public $LoggedCompanyId = 0;
    public $LoggedUserName = 'Welcome';
    public $paginationLimit = 10;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Encryption');
        $this->loadComponent('Custom');
        $this->loadComponent('Flash');
        $this->loadComponent('Paginator');
        $this->loadComponent('Cookie');
        $this->loadComponent('Custom');
        /* These are codes use for auth login */
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                        'is_active' => 1,
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);
        /* These are code use for check auth user */
        if ($this->Auth->user('user_id') != 0) {
            $this->companyId = $this->Auth->user('user_id');
            $this->userId = $this->Auth->user('id');
            $this->loggedusername = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
        } else {
            $this->userId = $this->Auth->user('id');
            $this->companyId = $this->Auth->user('id');
            $this->companyName = $this->Auth->user('company');
            $this->loggedusername = $this->Auth->user('first_name') . ' ' . $this->Auth->user('last_name');
        }

        Configure::write('CompanyId', $this->companyId);
        Configure::write('userId', $this->userId);
        $this->set('userId', $this->userId);
        $this->set('Authuser', $this->Auth->user());

//  Permission for admin /admin employee  If value is 1 that mince access permission for the operation

        if ($this->Auth->user('role_id') == 1 && $this->Auth->user('permission_id') == 1) {
            $this->subAdminAdd = 1;
            $this->subAdminEdit = 1;
            $this->subAdminDelete = 1;
            $this->subAdminStaff = 1;
        }
        if ($this->Auth->user('role_id') == 4 && $this->Auth->user('permission_id') == 2) {
            $this->subAdminAdd = 1;
            $this->subAdminEdit = 1;
            $this->subAdminDelete = 1;
            $this->subAdminStaff = 0;
        }
        if ($this->Auth->user('role_id') == 4 && $this->Auth->user('permission_id') == 3) {
            $this->subAdminAdd = 1;
            $this->subAdminEdit = 1;
            $this->subAdminDelete = 0;
            $this->subAdminStaff = 0;
        }
        $this->set(['subAdminAdd' => $this->subAdminAdd, 'subAdminEdit' => $this->subAdminEdit, 'subAdminDelete' => $this->subAdminDelete, 'subAdminStaff' => $this->subAdminStaff]);

//  Permission for client /company employee ( If value is 1 that mince access permission for the operation )      

        if ($this->Auth->user('role_id') == 2 && $this->Auth->user('permission_id') == 4) {
            $this->CompanyAdminAdd = 1;
            $this->CompanyAdminEdit = 1;
            $this->CompanyAdminDelete = 1;
            $this->CompanyAdminStaff = 1;
        }
        if ($this->Auth->user('role_id') == 3 && $this->Auth->user('permission_id') == 5) {
            $this->CompanyAdminAdd = 0;
            $this->CompanyAdminEdit = 1;
            $this->CompanyAdminDelete = 1;
            $this->CompanyAdminStaff = 0;
        }
        if ($this->Auth->user('role_id') == 3 && $this->Auth->user('permission_id') == 6) {
            $this->CompanyAdminAdd = 1;
            $this->CompanyAdminEdit = 1;
            $this->CompanyAdminDelete = 0;
            $this->CompanyAdminStaff = 0;
        }

        $this->set(['CompanyAdminAdd' => $this->CompanyAdminAdd, 'CompanyAdminEdit' => $this->CompanyAdminEdit, 'CompanyAdminDelete' => $this->CompanyAdminDelete, 'CompanyAdminStaff' => $this->CompanyAdminStaff]);

        # Get Logged Detail for Using various type - START
        if ($this->Auth->user()) {
            $this->LoggedRoleId = $this->Auth->user('role_id');
            $this->LoggedPermissionId = $this->Auth->user('permission_id');
            $this->LoggedUserId = $this->Auth->user('id');
            $this->LoggedCompanyId = $this->Auth->user('user_id');
            $this->LoggedUserName = $this->Auth->user('first_name');
            if (in_array($this->LoggedRoleId, array(1, 2))) {
                $this->LoggedCompanyId = $this->Auth->user('id');
            }


            if (strtolower($this->request->getParam('controller')) != 'customs') {
                if ($this->request->getParam('prefix') == 'admin' && !in_array($this->LoggedRoleId, array(1, 4))) {
                    $this->redirect(['controller' => 'Users', 'action' => 'logout', 'prefix' => 'admin']);
                } else if ($this->request->getParam('prefix') != 'admin' && !in_array($this->LoggedRoleId, array(2, 3))) {
                    $this->redirect(['controller' => 'Users', 'action' => 'logout']);
                }
            }
        }
        Configure::write('LoggedRoleId', $this->LoggedRoleId);
        Configure::write('LoggedPermissionId', $this->LoggedPermissionId);
        Configure::write('LoggedUserId', $this->LoggedUserId);
        Configure::write('LoggedCompanyId', $this->LoggedCompanyId);
        Configure::write('LoggedUserName', $this->LoggedUserName);
        $this->set(['LoggedRoleId' => $this->LoggedRoleId, 'LoggedPermissionId' => $this->LoggedPermissionId, 'LoggedUserId' => $this->LoggedUserId, 'LoggedCompanyId' => $this->LoggedCompanyId, 'LoggedUserName' => $this->LoggedUserName]);
        # Get Logged Detail for Using various type - END

        Configure::write('paginationLimit', $this->paginationLimit);

        if ($this->request->getParam('prefix') != 'admin') {
            $this->_getPageLabels();
        }
        
        if ($this->Auth->user()) {
            $this->_getAlertNotifications();
            $this->_getActivityLog();
            if (in_array($this->LoggedRoleId, array(2, 3))) {
                $this->_getDeadlines();
                $this->_getUpcomingAlertNotifications();
            }
        }
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /* @Functio: sendEmail() function use for common send email function
     * @param array $data
     * @param type $to
     * @param type $templateId
     * @return boolean    
     * @By @Ahsan Ahamad
     * @Date : 26 Nov. 2017
     */

    public function sendEmail($data, $to, $templateId, $subject = null) {
        $this->loadModel('EmailTemplates');
        $template = $this->EmailTemplates->find()->where(['id' => $templateId])->first();
        $subject = $template->subject;
        $templateName = $template->email_type;
        $data['url'] = HTTP_ROOT;
        $response = false;
        try {
            $Email = new Email();
            $Email->transport('gmail3');
            $Email->viewVars(array("data" => $data));
            $Email->to($to);
            $Email->subject($subject);
            $Email->template($templateName);
            $Email->emailFormat('html');
            if ($Email->send()) {
                $response = true;
            }
        } catch (Exception $ex) {
            $response = false;
        }
        return $response;
    }

    public function _sendSmtpMail($subject = null, $emailTemplate = null, $to = null, $cc = null) {
        $email = new Email();
        $email->transport('gmail3');
        $email->emailFormat('html');
        $res = $email->to($to)
                ->subject($subject)
                ->send($emailTemplate);
    }

    private function _getAlertNotifications() {
        $this->loadModel('AlertNotifications');
        $conditions = ['AlertNotifications.is_readed' => 0, 'AlertNotifications.is_unsubscribed' => 0, 'AlertNotifications.is_deleted' => 0, 'AlertNotifications.user_id' => Configure::read('LoggedUserId')];
        $headerAlertNotifications = $this->AlertNotifications->find()
                        ->contain(['Alerts'])
                        ->hydrate(false)
                        ->select(['Alerts.title', 'AlertNotifications.created', 'AlertNotifications.id', 'AlertNotifications.alert_id'])
                        ->where($conditions)
                        ->order(['AlertNotifications.created' => 'DESC'])
                        ->limit(5)->toArray();
        $this->set(compact('headerAlertNotifications'));
        $headerAlertNotificationCount = $this->AlertNotifications->find()
                ->contain(['Alerts'])
                ->hydrate(false)
                ->where($conditions)
                ->order(['AlertNotifications.created' => 'DESC'])
                ->count();
        $this->set(compact('headerAlertNotifications', 'headerAlertNotificationCount'));
    }

    private function _getUpcomingAlertNotifications() {
        $this->loadModel('Alerts');
        $conditions = ['is_completed' => 0, 'is_active' => 1, 'is_deleted' => 0, 'date >=' => date('m-d-Y')];
        $upcomingAlertNotifications = $this->Alerts->find()
                        ->hydrate(false)
                        ->select(['Alerts.title', 'Alerts.alert_type_id', 'Alerts.date', 'Alerts.created', 'Alerts.id', 'Alerts.user_id','Alerts.is_admin','Alerts.added_by'])
                        ->where($conditions)
//                        ->where(function ($exp, $q) {
//                            return $exp->between('date', date('m-d-Y'), date('m-d-Y', strtotime('+1 months')));
//                        })
                        ->order(['Alerts.date' => 'DESC'])
                        ->limit(30)->toArray();
        $headerUpcomingAlerts = [];
        if (!empty($upcomingAlertNotifications)) {
            foreach ($upcomingAlertNotifications as $alertData) {
                $this->loadModel('Users');
                $this->loadModel('AlertNotifications');
                $this->loadModel('AlertOperations');
                $this->loadModel('AlertStaffs');
                $this->loadModel('AlertCompanies');
                $userIds = [];
                $userData = [];
                switch ($alertData['alert_type_id']) {
                    case 1://Persnal- Role 1
                        $userIds[] = $alertData['user_id'];
                        break;
                    case 2://Sullivan PC- Role 1,4
                        $userIds = $this->AlertStaffs->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                    case 3://Company- Role 2,3
                        $userIds = $this->AlertCompanies->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                    case 4://Operation- Role 2,3
                        $userIds = $this->AlertOperations->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                    case 5:// Company Staff 
                        $userIds = $this->AlertStaffs->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                }

                if (in_array($this->LoggedUserId, $userIds)) {
                    $headerUpcomingAlerts[$alertData['id']] = $alertData;
                }
            }
        }
        $this->set(compact('headerUpcomingAlerts'));
    }

    public function _getActivityLog() {
        $this->loadModel('ActivityLogs');
        $conditions = ['ActivityLogs.user_id' => $this->LoggedCompanyId];
        $headerActivityLogs = $this->ActivityLogs->find()
                        ->hydrate(false)
                        ->select(['ActivityLogs.id', 'ActivityLogs.message', 'ActivityLogs.created', 'ActivityLogs.module_name', 'ActivityLogs.activity'])
                        ->where($conditions)
                        ->order(['ActivityLogs.created' => 'DESC'])
                        ->limit(5)->toArray();
        $this->set(compact('headerActivityLogs'));
    }

    protected function _getAlertListForUser() {
        $this->loadModel('Alerts');
        $conditions = ['is_active' => 1, 'is_deleted' => 0];
        $upcomingAlertNotifications = $this->Alerts->find()
                ->hydrate(false)
                ->select(['Alerts.alert_type_id', 'Alerts.id', 'Alerts.user_id'])
                ->where($conditions)
                ->toArray();
        $headerUpcomingAlerts = [];
        if (!empty($upcomingAlertNotifications)) {
            foreach ($upcomingAlertNotifications as $alertData) {
                $this->loadModel('Users');
                $this->loadModel('AlertNotifications');
                $this->loadModel('AlertOperations');
                $this->loadModel('AlertStaffs');
                $this->loadModel('AlertCompanies');
                $userIds = [];
                switch ($alertData['alert_type_id']) {
                    case 1://Persnal- Role 1
                        $userIds[] = $alertData['user_id'];
                        break;
                    case 2://Sullivan PC- Role 1,4
                        $userIds = $this->AlertStaffs->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                    case 3://Company- Role 2,3
                        $userIds = $this->AlertCompanies->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                    case 4://Operation- Role 2,3
                        $userIds = $this->AlertOperations->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                    case 5:// Company Staff 
                        $userIds = $this->AlertStaffs->getUserIdListForEmail($alertData['id'], $alertData['user_id']);
                        break;
                }
                if (in_array($this->LoggedUserId, $userIds)) {
                    $headerUpcomingAlerts[$alertData['id']] = $alertData['id'];
                }
            }
        }
        return $headerUpcomingAlerts;
    }

    protected function _getDeadlineListForUser() {
        $this->loadModel('UserPermits');
        return $this->UserPermits->find('list', ['valueField' => 'permit_id'])
                        ->hydrate(false)
                        ->select(['UserPermits.permit_id'])
                        ->where(['UserPermits.user_id' => $this->LoggedCompanyId, 'is_active' => 1, 'is_deleted' => 0])
                        ->order(['UserPermits.created' => 'DESC'])
                        ->toArray();
    }

    public function _getPageLabels() {
        $this->loadModel('PageLabels');
        $pageLabelsData = $this->PageLabels->find('list', ['keyField' => 'id', 'valueField' => 'value'])->toArray();
        $this->set(compact('pageLabelsData'));
    }

    public function _updatedBy($modalName, $id = null) {
        if (!empty($id)) {
            $tableName = TableRegistry::get($modalName);
            $tableData = $tableName->get($id);
            $tableData->modified_by = $this->LoggedUserId;
            $tableName->save($tableData);
        }
    }

    private function _getDeadlines() {
        $this->loadModel('LocationOperations');
        $this->loadModel('PermitOperations');
        $this->loadModel('UserPermits');
        $operationList = $this->LocationOperations->getOperationListByCompanyId($this->LoggedCompanyId);
        $operationPermitList = $this->PermitOperations->getAssignedPermitListByOperationId($operationList);

        $deadlineByUser = $deadlineByAdmin = $deadlineRenewable = [];
        if (!empty($operationPermitList)) {
            $this->loadModel('Deadlines');
            $deadlineByAdmin = $this->Deadlines->find()
                    ->hydrate(false)
                    ->select(['Deadlines.id', 'Deadlines.date', 'Deadlines.time', 'Deadlines.is_renewable', 'Deadlines.is_admin', 'Deadlines.added_by', 'Deadlines.modified'])
                    ->contain([
                        'Permits' => function($q) {
                            return $q
                                    ->select(['id', 'name']);
                        }])
                    ->where(['Deadlines.permit_id IN ' => $operationPermitList, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'Deadlines.date >= ' => date('m-d-Y'), 'Deadlines.is_admin' => 1])
                    ->group('Deadlines.permit_id')
                    ->order(['Deadlines.date' => 'ASC'])
                    ->limit(5)
                    ->toArray();
            $aPermitList = [];
            if (!empty($deadlineByAdmin)) {
                foreach ($deadlineByAdmin as $dList) {
                    if (!empty($dList['permit'])) {
                        $aPermitList[] = $dList['permit']['id'];
                    }
                }
            }
            $operationPermitList = array_diff($operationPermitList, $aPermitList);

            if (!empty($operationPermitList)) {
                $deadlineByUser = $this->Deadlines->find()
                        ->hydrate(false)
                        ->select(['Deadlines.id', 'Deadlines.date', 'Deadlines.time', 'Deadlines.is_renewable', 'Deadlines.is_admin', 'Deadlines.added_by', 'Deadlines.modified'])
                        ->contain([
                            'Permits' => function($q) {
                                return $q
                                        ->select(['id', 'name']);
                            }])
                        ->where(['Deadlines.permit_id IN ' => $operationPermitList, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'Deadlines.date >= ' => date('m-d-Y'), 'Deadlines.is_admin' => 0, 'Deadlines.is_renewable' => 0])
                        ->group('Deadlines.permit_id')
                        ->order(['Deadlines.date' => 'ASC'])
                        ->limit(5)
                        ->toArray();
            }
        }
        
        $previousPermitList = $this->UserPermits->getPreviousPermitListByCompanyId($this->LoggedCompanyId);
        if (!empty($previousPermitList)) {
            $deadlineRenewable = $this->Deadlines->find()
                    ->hydrate(false)
                    ->select(['Deadlines.id', 'Deadlines.date', 'Deadlines.time', 'Deadlines.is_renewable', 'Deadlines.is_admin', 'Deadlines.added_by', 'Deadlines.modified'])
                    ->contain([
                        'Permits' => function($q) {
                            return $q
                                    ->select(['id', 'name']);
                        }])
                    ->where(['Deadlines.permit_id IN ' => $previousPermitList, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'Deadlines.date >= ' => date('m-d-Y'), 'Deadlines.is_admin' => 0, 'Deadlines.is_renewable' => 1])
                    //->group('Deadlines.permit_id')
                    ->order(['Deadlines.date' => 'ASC'])
                    ->limit(5)
                    ->toArray();
        }

        $deadlines = array_merge($deadlineByAdmin, $deadlineByUser, $deadlineRenewable);
        foreach ($deadlines as $key => $data) {
            $date = str_replace('-', '/', $data["date"]);
            $date = $date . ' ' . $data["time"];
            $deadlines[strtotime($date)] = $data;
            unset($deadlines[$key]);
        }
        ksort($deadlines);
        $this->set('upcomingDeadlines', $deadlines);
    }

}
