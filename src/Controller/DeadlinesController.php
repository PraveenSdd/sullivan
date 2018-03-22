<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class DeadlinesController extends AppController {

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
        $pageTitle = 'Deadlines';
        $pageHedding = 'Deadlines';
        $breadcrumb = array(
            array('label' => 'Deadlines'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->loadModel('LocationOperations');
        $this->loadModel('PermitOperations');
        $this->loadModel('UserPermits');
        $operationList = $this->LocationOperations->getOperationListByCompanyId(Configure::read('LoggedCompanyId'));
        $operationPermitList = $this->PermitOperations->getAssignedPermitListByOperationId($operationList);
        
        $deadlineByUser = $deadlineByAdmin = [];
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
                        ->toArray();
            }
        }

        $deadlineRenewable = null;
        $previousPermitList = $this->UserPermits->getPreviousPermitListByCompanyId(Configure::read('LoggedCompanyId'));
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
                    ->toArray();
        }

        $deadlines = array_merge($deadlineByAdmin, $deadlineByUser, $deadlineRenewable );
        foreach ($deadlines as $key => $data) {
            $date = str_replace('-', '/', $data["date"]);
            $date = $date . ' ' . $data["time"];
            $deadlines[strtotime($date)] = $data;
            unset($deadlines[$key]);
        }
        ksort($deadlines);
        $this->set(compact('deadlines'));
    }

    public function add() {
        $pageTitle = 'Deadlines | Add';
        $pageHedding = 'Add Deadline';
        $breadcrumb = array(
            array('label' => 'Deadlines', 'link' => 'deadlines/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $this->loadModel('Deadlines');
            $permitId = $this->request->data['Deadlines']['permit_id'];
            $response = $this->Deadlines->saveData($this->request->data['Deadlines'], $permitId);
            if (!empty($response['id']) && !empty($this->request->data['Deadlines']['deadline_type_id'])) {
                $this->loadModel('UserPermitDeadlines');
                $userPermitDeadline = [];
                $userPermitDeadline['user_id'] = Configure::read('LoggedCompanyId');
                $userPermitDeadline['added_by'] = Configure::read('LoggedUserId');
                $userPermitDeadline['permit_id'] = $permitId;
                $userPermitDeadline['deadline_id'] = $response['id'];
                $userPermitDeadline['user_permit_id'] = $this->request->data['Deadlines']['user_permit_id'];
                if ($this->request->data['Deadlines']['deadline_type_id'] == 1) {
                    $type = 'permit_form_id';
                } elseif ($this->request->data['Deadlines']['deadline_type_id'] == 2) {
                    $type = 'document_id';
                }
                if (!empty($this->request->data['UserPermitDeadlines'][$type])) {
                    foreach ($this->request->data['UserPermitDeadlines'][$type] as $data) {
                        $userPermitDeadline[$type] = $data;
                        $deadlines = $this->UserPermitDeadlines->newEntity($userPermitDeadline);
                        $deadlines = $this->UserPermitDeadlines->patchEntity($deadlines, $userPermitDeadline);
                        $this->UserPermitDeadlines->save($deadlines);
                    }
                }
            }
            if (!$response['flag']) {
                $this->Flash->error(__($response['msg']));
            } else {
                /* === Added by vipin for  add log=== */
                $message = 'Deadline added by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'deadlines';
                $saveActivityLog['module_name'] = 'Deadline Front';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Add';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__('Deadline has been added successfully'));
                return $this->redirect(['controller' => 'deadlines', 'action' => 'index']);
            }
        }
        $this->loadModel('UserPermits');
        $userPermitList = $this->UserPermits->getPermitList();
        $this->loadModel('DeadlineTypes');
        $deadlineTypeList = $this->DeadlineTypes->getCompanyDeadlineType();
        $this->set(compact('userPermitList', 'deadlineTypeList'));
    }

    public function edit($deadlineId) {
        $this->set(compact('deadlineId'));
        $pageTitle = 'Deadline | Edit';
        $pageHedding = 'Edit Deadline';
        $breadcrumb = array(
            array('label' => 'Deadlines', 'link' => 'deadlines/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $deadlineId = $this->Encryption->decode($deadlineId);
        $this->loadModel('Deadlines');
        $deadline = $this->Deadlines->getDeadlineData($deadlineId);
        if (empty($deadline)) {
            $this->Flash->error(__('Deadline not available!'));
            return $this->redirect(['controller' => 'deadlines', 'action' => 'index']);
        }
        $this->set(compact('deadline'));
        if ($this->request->is('post')) {
            $this->loadModel('Deadlines');
            $this->request->data['Deadlines']['id'] = $deadlineId;
            $permitId = $this->request->data['Deadlines']['permit_id'];
            $response = $this->Deadlines->saveData($this->request->data['Deadlines'], $permitId);
            if (!empty($response['id']) && !empty($this->request->data['Deadlines']['deadline_type_id'])) {
                $this->loadModel('UserPermitDeadlines');
                if (!empty($this->request->data['Deadlines']['id'])) {
                    $this->UserPermitDeadlines->updateAll(['is_deleted' => 1], ['deadline_id' => $this->request->data['Deadlines']['id']]);
                }
                $userPermitDeadline = [];
                $userPermitDeadline['user_id'] = Configure::read('LoggedCompanyId');
                $userPermitDeadline['added_by'] = Configure::read('LoggedUserId');
                $userPermitDeadline['permit_id'] = $permitId;
                $userPermitDeadline['deadline_id'] = $response['id'];
                $userPermitDeadline['user_permit_id'] = $this->request->data['Deadlines']['user_permit_id'];
                if ($this->request->data['Deadlines']['deadline_type_id'] == 1) {
                    $type = 'permit_form_id';
                } elseif ($this->request->data['Deadlines']['deadline_type_id'] == 2) {
                    $type = 'document_id';
                }
                if (!empty($this->request->data['UserPermitDeadlines'][$type])) {
                    foreach ($this->request->data['UserPermitDeadlines'][$type] as $data) {
                        $userPermitDeadline[$type] = $data;
                        $deadlines = $this->UserPermitDeadlines->newEntity($userPermitDeadline);
                        $deadlines = $this->UserPermitDeadlines->patchEntity($deadlines, $userPermitDeadline);
                        $this->UserPermitDeadlines->save($deadlines);
                    }
                }
            }
            if (!$response['flag']) {
                $this->Flash->error(__($response['msg']));
            } else {
                /* === Added by vipin for  add log=== */
                $message = 'Deadline updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'deadlines';
                $saveActivityLog['module_name'] = 'Deadline Front';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__('Deadline has been added Updated.'));
                return $this->redirect(['controller' => 'deadlines', 'action' => 'index']);
            }
        }
        if (empty($this->request->data)) {
            $this->request->data['Deadlines'] = $deadline;
        }

        $this->loadModel('UserPermits');
        $userPermitList = $this->UserPermits->getPermitList();
        $this->loadModel('DeadlineTypes');
        $deadlineTypeList = $this->DeadlineTypes->getCompanyDeadlineType();
        $this->set(compact('userPermitList', 'deadlineTypeList'));
    }

    public function getRelatedFormAndDocument($permitId) {
        $this->autoRender = false;
        if ($this->request->is('post') && !empty($permitId)) {
            $response['document'] = '';
            $response['form'] = '';
            $this->loadModel('PermitDocuments');
            $this->loadModel('Documents');
            $docList = $this->PermitDocuments->getAssignedDocumentListByPermitId($permitId);
            $permitDocumentList = $this->Documents->getAssignedDocumentList($docList);
            $listDocumentHtml = null;
            if (!empty($permitDocumentList)) {
                foreach ($permitDocumentList as $key => $value) {
                    $listDocumentHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
                }
                $response['document'] = $listDocumentHtml;
            }
            $this->loadModel('PermitForms');
            $permitFormList = $this->PermitForms->getAssignedPermitFormList($permitId);
            $listFormHtml = null;
            if (!empty($permitFormList)) {
                foreach ($permitFormList as $key => $value) {
                    $listFormHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
                }
                $response['form'] = $listFormHtml;
            }
            echo json_encode($response);
            exit;
        }
    }

}
