<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class PermitsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamad
     * Date : 26 Jan 2018
     */

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Upload');
    }

    /*
     * @Function: index()
     * @Description: use for listing of data table
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'Manage Permits';
        $pageHedding = 'Manage Permits';
        $breadcrumb = array(
            array('label' => 'Manage Permits'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $conditions = ['Permits.is_deleted' => 0, 'Permits.is_active' => 1,'Permits.is_admin' => 1];
        if (!empty($this->request->query)) {
            if (isset($this->request->query['name']) && $this->request->query['name'] != '') {
                $conditions['LOWER(Permits.name) LIKE'] = '%' . strtolower(trim($this->request->query['name'])) . '%';
            }
            # Save searched value in search-form input-fields
            $this->request->data = $this->request->query;
        }

        $this->paginate = [
            'contain' => ['Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'conditions' => $conditions,
            'order' => ['Permits.id' => 'DESC'],
            'limit' => $this->paginationLimit,
        ];
        $permits = $this->paginate($this->Permits);
        $this->set(compact('permits'));
    }

    /**
     * 
     * @param type $permitId
     */
    public function view($permitId = null) {
        $this->set(compact('permitId'));
        $pageTitle = 'View Permit ';
        $pageHedding = 'View Permit';
        $breadcrumb = array(
            array('label' => 'Manage Permits', 'link' => 'permits/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $permitId = $this->Encryption->decode($permitId);
        $permits = $this->Permits->find()->where(['Permits.id =' => $permitId])->first();
        if (empty($permits)) {
            $this->Flash->error(__('Permit not available!'));
            return $this->redirect(['controller' => 'Permits', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('permits'));

        $this->loadModel('Agencies');
        $agencyList = $this->Agencies->getList();
        $this->set(compact('agencyList'));

        $this->loadModel('PermitAgencies');
        $permitAgencies = $this->PermitAgencies->getDataByPermitId($permitId);
        $this->set(compact('permitAgencies'));

        $this->loadModel('PermitForms');
        $permitForms = $this->PermitForms->getDataByPermitId($permitId);
        $this->set(compact('permitForms'));

        $this->loadModel('PermitInstructions');
        $permitInstructions = $this->PermitInstructions->getDataByPermitId($permitId);
        $this->set(compact('permitInstructions'));

        $this->loadModel('PermitDocuments');
        $permitDocuments = $this->PermitDocuments->getDataByPermitId($permitId);
        $this->set(compact('permitDocuments'));

        $this->loadModel('PermitOperations');
        $permitOperations = $this->PermitOperations->getDataByPermitId($permitId);
        $this->set(compact('permitOperations'));

        $this->loadModel('Deadlines');
        $permitDeadline = $this->Deadlines->getAdminDataByPermitId($permitId);
        $this->set(compact('permitDeadline'));

        $this->loadModel('AlertPermits');
        $alertPermits = $this->AlertPermits->getDataByPermitId($permitId);
        $this->set(compact('alertPermits'));

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

        $redirectHere = '/admin/permits/view/' . $this->Encryption->encode($permitId);
        $this->set(compact('redirectHere'));
    }

    public function add() {
        $pageTitle = 'Add Permit';
        $pageHedding = 'Add Permit';
        $breadcrumb = array(
            array('label' => 'Manage Permits', 'link' => 'permits/index'),
            array('label' => 'Add '),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $response = $this->Permits->savePermitData($this->request->data, $this->request->data['Permit']['id']);
            if ($response['flag']) {
                $this->_updatedBy('Permits', $response['permit_id']);
                /* === Added by vipin for  add log=== */
                $message = 'Permit added by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['permit_id'];
                $saveActivityLog['table_name'] = 'permits';
                $saveActivityLog['module_name'] = 'Permit';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Add';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__($response['msg']));
                return $this->redirect(['controller' => 'Permits', 'action' => 'index', 'prefix' => 'admin']);
            } else {
                $this->Flash->error(__((is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg']));
            }
        }

        $this->loadModel('Agencies');
        $agencyList = $this->Agencies->getList();
        $this->set(compact('agencyList'));

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

    public function edit($permitId) {
        $this->set(compact('permitId'));
        $pageTitle = 'Edit Permit';
        $pageHedding = 'Edit Permit';
        $breadcrumb = array(
            array('label' => 'Manage Permits', 'link' => 'permits/index'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $permitId = $this->Encryption->decode($permitId);
        $permits = $this->Permits->find()->where(['Permits.id =' => $permitId])->first();
        if (empty($permits)) {
            $this->Flash->error(__('Permit not available!'));
            return $this->redirect(['controller' => 'Permits', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('permits'));
        if ($this->request->is(['post', 'put'])) {
            $response = $this->Permits->savePermitData($this->request->data, $permitId);
            if ($response['flag']) {
                $this->_updatedBy('Permits', $response['permit_id']);
                /* === Added by vipin for  add log=== */
                $message = 'Permit updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['permit_id'];
                $saveActivityLog['table_name'] = 'permits';
                $saveActivityLog['module_name'] = 'Permit';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__($response['msg']));
                return $this->redirect(['controller' => 'Permits', 'action' => 'index', 'prefix' => 'admin']);
            } else {
                $this->Flash->error(__((is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg']));
            }
        }

        $this->loadModel('Agencies');
        $agencyList = $this->Agencies->getList();
        $this->set(compact('agencyList'));

        $this->loadModel('PermitAgencies');
        $permitAgencies = $this->PermitAgencies->getDataByPermitId($permitId);
        $this->set(compact('permitAgencies'));

        $this->loadModel('PermitForms');
        $permitForms = $this->PermitForms->getDataByPermitId($permitId);
        $this->set(compact('permitForms'));

        $this->loadModel('PermitInstructions');
        $permitInstructions = $this->PermitInstructions->getDataByPermitId($permitId);
        $this->set(compact('permitInstructions'));

        $this->loadModel('PermitDocuments');
        $permitDocuments = $this->PermitDocuments->getDataByPermitId($permitId);
        $this->set(compact('permitDocuments'));

        $this->loadModel('PermitOperations');
        $permitOperations = $this->PermitOperations->getDataByPermitId($permitId);
        $this->set(compact('permitOperations'));

        $this->loadModel('Deadlines');
        $permitDeadline = $this->Deadlines->getAdminDataByPermitId($permitId);
        $this->set(compact('permitDeadline'));

        $this->loadModel('AlertPermits');
        $alertPermits = $this->AlertPermits->getDataByPermitId($permitId);
        $this->set(compact('alertPermits'));

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

        $redirectHere = '/admin/permits/edit/' . $this->Encryption->encode($permitId);
        $this->set(compact('redirectHere'));
    }

    /**
     * 
     * @param type $permitId
     */
    public function savePermitData($permitId = null) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('ajax')) {
            $response = $this->Permits->savePermitData($this->request->data, $permitId);
            $response['msg'] = (is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg'];
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /*
     * Function:checkPermitUniqueName()
     * Description: use for check Unique permit by ajax
     * By @Ahsan Ahamad
     * Date : 13th Jan. 2018
     */

    public function checkPermitUniqueName($permitName = null, $permitId = null) {
        $this->autorander = FALSE;
        if (isset($this->request->data['name'])) {
            $permitName = $this->request->data['name'];
        }
        if (isset($this->request->data['id'])) {
            $permitId = $this->request->data['id'];
        }
        $nameStatus = $this->Permits->checkPermitUniqueName($permitName, $permitId);


        echo json_encode($nameStatus);

        exit;
    }

    public function getUnAssignedPermitList() {
        $this->autorander = FALSE;
        $assinedPermitId = null;
        if (isset($this->request->data['assinedPermitId'])) {
            $assinedPermitId = $this->request->data['assinedPermitId'];
        }
        $unAssignPermitList = $this->Permits->getUnAssignedPermitList($assinedPermitId);

        $listHtml = '<option value="">-- Select Permit -- </option>';
        foreach ($unAssignPermitList as $key => $value) {
            $listHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
        }
        echo $listHtml;
        exit;
    }

    /**
     * 
     */
    public function saveRelatedAgency() {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';

        if ($this->request->is('post')) {
            $this->loadModel('PermitAgencies');
            $response = $this->PermitAgencies->saveRelatedData($this->request->data);
            /* === Added by vipin for  add log=== */
            if (!empty($response['permit_agency_id'])) {
                if (!empty($this->request->data['permit_agency_id'])) {
                    $message = 'Permit Related Agency updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                } else {
                    $message = 'Permit Related Agency added by ' . $this->loggedusername;
                    $activity = 'Add';
                }
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['permit_agency_id'];
                $saveActivityLog['table_name'] = 'permit_agencies';
                $saveActivityLog['module_name'] = 'Permit Related Agency';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = $activity;
                $this->Custom->saveActivityLog($saveActivityLog);
            }
            /* === Added by vipin for  add log=== */
            if (!empty($this->request->data['permit_id'])) {
                $this->_updatedBy('Permits', $this->request->data['permit_id']);
            }
        } else {
            $response['msg'] = 'Permit could not be added!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getRelatedAgency($permitId) {
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->autoRender = false;
        $this->loadModel('PermitAgencies');
        $permitAgencies = $this->PermitAgencies->getDataByPermitId($permitId);
        $this->set(compact('permitAgencies', 'redirectHere'));
        echo $this->render('/Element/backend/permit/agency_list');
        exit;
    }

    public function getUnAssignedOperationList($permitId) {
        $this->autorander = FALSE;
        $assinedOperationId = null;
        if (isset($this->request->data['assinedOperationId'])) {
            $assinedOperationId = $this->request->data['assinedOperationId'];
        }
        $this->Operations = TableRegistry::get('Operations');
        $unAssignOperationList = $this->Operations->getUnAssignedOperationList($permitId, $assinedOperationId);

        $listHtml = null;
        foreach ($unAssignOperationList as $key => $value) {
            $listHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
        }
        echo $listHtml;
        exit;
    }

    /**
     * 
     */
    public function saveRelatedOperation() {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitOperations');
            if (empty($this->request->data['permit_id'])) {
                $response['msg'] = 'Permit is not selected!';
            } else if (empty($this->request->data['operation_id'])) {
                $response['msg'] = 'Operation is not selected!';
            } else {
                foreach ($this->request->data['operation_id'] as $operation) {
                    $permitOperationData = [];
                    $permitOperationData['permit_id'] = $this->request->data['permit_id'];
                    $permitOperationData['operation_id'] = $operation;
                    if ($this->request->data['permit_operation_id']) {
                        $permitOperationData['id'] = $this->request->data['permit_operation_id'];
                    } else {
                        $permitOperationData['id'] = $this->PermitOperations->getIdByPermitAndOperationId($permitOperationData['permit_id'], $operation);
                    }

                    $permitOperations = [];
                    if (!empty($permitOperationData['id'])) {
                        $permitOperations = $this->PermitOperations->get($permitOperationData['id']);
                        $message = 'Permit Operation updated by ' . $this->loggedusername;
                        $activity = 'Edit';
                    } else {
                        $permitOperationData['added_by'] = Configure::read('LoggedCompanyId');
                        $permitOperations = $this->PermitOperations->newEntity();
                        $message = 'Permit Operation added by ' . $this->loggedusername;
                        $activity = 'Add';
                    }
                    $this->PermitOperations->patchEntity($permitOperations, $permitOperationData);
                    if ($permitOperations = $this->PermitOperations->save($permitOperations)) {
                        /* === Added by vipin for  add log=== */
                        $saveActivityLog = [];
                        $saveActivityLog['table_id'] = $permitOperations->id;
                        $saveActivityLog['table_name'] = 'permit_operations';
                        $saveActivityLog['module_name'] = 'Permit Operation';
                        $saveActivityLog['url'] = $this->referer();
                        $saveActivityLog['message'] = $message;
                        $saveActivityLog['activity'] = $activity;
                        $this->Custom->saveActivityLog($saveActivityLog);
                        /* === Added by vipin for  add log=== */
                        $response['flag'] = true;
                        $response['msg'] = 'Operation has been added successfully!';
                    } else {
                        $response['msg'] = 'Operation could not be added!';
                    }
                }
            }
            if (!empty($this->request->data['permit_id'])) {
                $this->_updatedBy('Permits', $this->request->data['permit_id']);
            }
        } else {
            $response['msg'] = 'Permit could not be added!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getRelatedOperation($permitId) {
        $this->autoRender = false;
        $this->loadModel('PermitOperations');
        $permitOperations = $this->PermitOperations->getDataByPermitId($permitId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('permitOperations', 'redirectHere'));
        echo $this->render('/Element/backend/permit/operation_list');
        exit;
    }

    /**
     * 
     */
    public function validateFormName($name) {
        /* this is function is for that user can not inser <script> tag here */
        foreach ($name as $key => $value) {
            if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._ ]+$/', $value['name'])) {
                return false;
            }
        }
        return true;
    }

    public function saveRelatedForm($permitId) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $receivingName = $this->request->data['PermitForm'];
            $validateResult = $this->validateFormName($receivingName);
            if ($validateResult) {
                $this->loadModel('PermitForms');
                $errorFile = [];
                if (!empty($this->request->data['PermitForm'])) {
                    $formPath = 'files/permits/forms';
                    $formSamplePath = 'files/permits/forms/samples';
                    foreach ($this->request->data['PermitForm'] as $key => $permitForm) {
                        $uploadResponse = true;
                        $permitFormData = [];
                        if ($permitForm['file']['name']) {
                            $uploadResponse = $this->Upload->uploadOtherFile($permitForm['file'], $formPath);
                            if ($uploadResponse) {
                                $permitFormData['path'] = $uploadResponse;
                            } else {
                                $errorFile[] = $permitForm['file']['name'];
                            }
                        }
                        $permitFormData['permit_id'] = $permitId;
                        $permitFormData['name'] = $permitForm['name'];

                        $permitForms = [];
                        if ($permitForm['id']) {
                            $permitForms = $this->PermitForms->get($permitForm['id']);
                            $this->PermitForms->patchEntity($permitForms, $permitFormData);
                            $permitForms = $this->PermitForms->save($permitForms);
                            $message = 'Permit Add Form updated by ' . $this->loggedusername;
                            $activity = 'Edit';
                        } else {
                            if ($uploadResponse) {
                                $permitFormData['created'] = date('y-m-d H:i:s');
                                $permitFormData['added_by'] = Configure::read('LoggedCompanyId');
                                $permitForms = $this->PermitForms->newEntity();
                                $this->PermitForms->patchEntity($permitForms, $permitFormData);
                                $permitForms = $this->PermitForms->save($permitForms);
                                $message = 'Permit Add Form added by ' . $this->loggedusername;
                                $activity = 'Add';
                            }
                        }
                        /* === Added by vipin for  add log=== */
                        if (!empty($permitForms->id)) {
                            $saveActivityLog = [];
                            $saveActivityLog['table_id'] = $permitForms->id;
                            $saveActivityLog['table_name'] = 'permit_forms';
                            $saveActivityLog['module_name'] = 'Permit';
                            $saveActivityLog['url'] = $this->referer();
                            $saveActivityLog['message'] = $message;
                            $saveActivityLog['activity'] = 'Edit';
                            $this->Custom->saveActivityLog($saveActivityLog);
                        }
                        /* === Added by vipin for  add log=== */

                        # Save Permit-Form Sample File
                        if (!empty($permitForms) && !empty($permitForm['sample'])) {
                            $this->loadModel('PermitFormSamples');
                            foreach ($permitForm['sample'] as $formSample) {
                                if ($formSample['name']) {
                                    $uploadResponse = false;
                                    $permitFormSample = [];
                                    $uploadResponse = $this->Upload->uploadOtherFile($formSample, $formSamplePath);
                                    if ($uploadResponse) {
                                        $permitFormSample['path'] = $uploadResponse;
                                        $permitFormSample['permit_id'] = $permitId;
                                        $permitFormSample['added_by'] = Configure::read('LoggedCompanyId');
                                        $permitFormSample['permit_form_id'] = $permitForms->id;
                                        $permitFormSample['created'] = date('y-m-d H:i:s');
                                        $permitFormSamples = $this->PermitFormSamples->newEntity();
                                        $this->PermitFormSamples->patchEntity($permitFormSamples, $permitFormSample);
                                        $this->PermitFormSamples->save($permitFormSamples);
                                    } else {
                                        $errorFile[] = $formSample['name'];
                                    }
                                }
                            }
                        }
                    }
                    if ($errorFile) {
                        $response['msg'] = $this->Custom->multipleFlash($errorFile);
                    } else {
                        $response['flag'] = true;
                        $response['msg'] = 'Form has been added successfully';
                    }
                    if (!empty($permitId)) {
                        $this->_updatedBy('Permits', $permitId);
                    }
                } else {
                    $response['msg'] = 'Please upload form';
                }
            } else {
                $response['msg'] = 'Form name can only Alphanumeric';
            }
        } else {
            $response['msg'] = 'Invalid request';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $permitId
     */
    public function getRelatedForm($permitId) {
        $this->autoRender = false;
        $this->loadModel('PermitForms');
        $permitForms = $this->PermitForms->getDataByPermitId($permitId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('permitForms', 'redirectHere'));
        echo $this->render('/Element/backend/permit/form_list');
        exit;
    }

    public function saveRelatedInstruction($permitId) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitInstructions');
            $errorFile = [];
            if (!empty($this->request->data['PermitInstruction'])) {
                $instructionPath = 'files/permits/instructions';
                $this->request->data['PermitInstruction']['permit_id'] = $permitId;
                $this->request->data['PermitInstruction']['id'] = $this->request->data['PermitInstruction']['permit_instruction_id'];
                $uploadResponse = true;
                if ($this->request->data['PermitInstruction']['file']['name']) {
                    $uploadResponse = $this->Upload->uploadOtherFile($this->request->data['PermitInstruction']['file'], $instructionPath);
                    if ($uploadResponse) {
                        $this->request->data['PermitInstruction']['path'] = $uploadResponse;
                    } else {
                        $errorFile[] = $this->request->data['PermitInstruction']['file']['name'];
                    }
                }

                $permitInstructions = null;
                if ($this->request->data['PermitInstruction']['id']) {
                    $permitInstructions = $this->PermitInstructions->get($this->request->data['PermitInstruction']['id']);
                    $this->PermitInstructions->patchEntity($permitInstructions, $this->request->data['PermitInstruction']);
                    $permitInstructions = $this->PermitInstructions->save($permitInstructions);
                    $message = 'Permit Instruction Document updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                } else {
                    if ($uploadResponse) {
                        $this->request->data['PermitInstruction']['added_by'] = Configure::read('LoggedCompanyId');
                        $permitInstructions = $this->PermitInstructions->newEntity();
                        $this->PermitInstructions->patchEntity($permitInstructions, $this->request->data['PermitInstruction']);
                        $permitInstructions = $this->PermitInstructions->save($permitInstructions);
                        $message = 'Permit Instruction Document added by ' . $this->loggedusername;
                        $activity = 'Add';
                    }
                }

                if ($permitInstructions) {
                    /* === Added by vipin for  add log=== */
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $permitInstructions->id;
                    $saveActivityLog['table_name'] = 'permit_instructions';
                    $saveActivityLog['module_name'] = 'Permit Instruction Document';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = $activity;
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */
                    $response['msg'] = 'Instruction has been added successfully';
                    $response['flag'] = true;
                } else {
                    $response['msg'] = 'Instruction could not be added';
                    if (!$uploadResponse) {
                        $response['msg'] = 'Please upload another instruction file.';
                    }
                }
                if (!empty($permitId)) {
                    $this->_updatedBy('Permits', $permitId);
                }
            } else {
                $response['msg'] = 'Please upload instruction';
            }
        } else {
            $response['msg'] = 'Invalid request';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $permitId
     */
    public function getRelatedInstruction($permitId) {
        $this->autoRender = false;
        $this->loadModel('PermitInstructions');
        $permitInstructions = $this->PermitInstructions->getDataByPermitId($permitId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('permitInstructions', 'redirectHere'));
        echo $this->render('/Element/backend/permit/instruction_list');
        exit;
    }

    public function saveDocument() {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Documents');
            $errorFile = [];
            if (!empty($this->request->data)) {
                if (!empty($this->request->data['Document']['name'])) {
                    foreach ($this->request->data['Document']['name'] as $key => $documentName) {
                        $documents = [];
                        $document['name'] = $documentName;
                        $document['slug'] = $documentName;
                        $documents = $this->Documents->newEntity();
                        $this->Documents->patchEntity($documents, $document);
                        if ($success = $this->Documents->save($documents)) {
                            /* === Added by vipin for  add log=== */
                            $message = 'Permit Document added by ' . $this->loggedusername;
                            $saveActivityLog = [];
                            $saveActivityLog['table_id'] = $success->id;
                            $saveActivityLog['table_name'] = 'documents';
                            $saveActivityLog['module_name'] = 'Permit Document';
                            $saveActivityLog['url'] = $this->referer();
                            $saveActivityLog['message'] = $message;
                            $saveActivityLog['activity'] = 'Add';
                            $this->Custom->saveActivityLog($saveActivityLog);
                            /* === Added by vipin for  add log=== */
                        } else {
                            $errorFile[] = $document['name'];
                        }
                    }
                }
                if ($errorFile) {
                    $response['msg'] = $this->Custom->multipleFlash($errorFile);
                } else {
                    $response['flag'] = true;
                    $response['msg'] = 'Document has been saved successfully';
                }
            } else {
                $response['msg'] = 'Request data not found!';
            }
        } else {
            $response['msg'] = 'Invalid request';
        }
        echo json_encode($response);
        exit;
    }

    public function getUnAssignedDocumentList($permitId) {
        $this->autorander = FALSE;
        $this->Documents = TableRegistry::get('Documents');
        $unAssignDocumentList = $this->Documents->getUnAssignedDocumentList($permitId);
        $listHtml = null;
        foreach ($unAssignDocumentList as $key => $value) {
            $listHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
        }
        echo $listHtml;
        exit;
    }

    public function saveRelatedDocument($permitId) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitDocuments');
            $this->loadModel('Documents');
            $errorFile = [];
            if (!empty($this->request->data)) {
                if (!empty($this->request->data['PermitDocument'])) {
                    foreach ($this->request->data['PermitDocument']['document_id'] as $key => $document_id) {
                        $permitDocuments = [];
                        $permitDocument['permit_id'] = $permitId;
                        $permitDocument['added_by'] = Configure::read('LoggedCompanyId');
                        $check = $this->PermitDocuments->checkPermitAndDocumentExistOrNot($permitId, $document_id);
                        if ($check == 0) {
                            $permitDocument['document_id'] = $document_id;
                            $permitDocuments = $this->PermitDocuments->newEntity();
                            $this->PermitDocuments->patchEntity($permitDocuments, $permitDocument);
                            if ($success = $this->PermitDocuments->save($permitDocuments)) {
                                /* === Added by vipin for  add log=== */
                                $message = 'Permit Document List added by ' . $this->loggedusername;
                                $saveActivityLog = [];
                                $saveActivityLog['table_id'] = $success->id;
                                $saveActivityLog['table_name'] = 'permit_documents';
                                $saveActivityLog['module_name'] = 'Permit Document';
                                $saveActivityLog['url'] = $this->referer();
                                $saveActivityLog['message'] = $message;
                                $saveActivityLog['activity'] = 'Add';
                                $this->Custom->saveActivityLog($saveActivityLog);
                                /* === Added by vipin for  add log=== */
                            } else {
                                $errorFile[] = $permitDocument['name'];
                            }
                        }
                    }
                    if (!empty($permitId)) {
                        $this->_updatedBy('Permits', $permitId);
                    }
                }

                if ($errorFile) {
                    $response['msg'] = $this->Custom->multipleFlash($errorFile);
                } else {
                    $response['flag'] = true;
                    $response['msg'] = 'Document has been added successfully';
                }
            } else {
                $response['msg'] = 'Please upload document';
            }
        } else {
            $response['msg'] = 'Invalid request';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $permitId
     */
    public function getRelatedDocument($permitId) {
        $this->autoRender = false;
        $this->loadModel('PermitDocuments');
        $permitDocuments = $this->PermitDocuments->getDataByPermitId($permitId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('permitDocuments', 'redirectHere'));
        echo $this->render('/Element/backend/permit/document_list');
        exit;
    }

    /**
     * 
     */
    public function saveRelatedDeadline($permitId) {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Deadlines');
            $this->request->data['PermitDeadline']['id'] = $this->request->data['PermitDeadline']['deadline_id'];
            $response = $this->Deadlines->saveAdminPermitData($this->request->data['PermitDeadline'], $permitId);
            if (!$response['flag']) {
                $response['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                if (!empty($permitId)) {
                    $this->_updatedBy('Permits', $permitId);
                }
                /* === Added by vipin for  add log=== */
                if (!empty($this->request->data['PermitDeadline']['deadline_id'])) {
                    $message = 'Permit Deadline updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                } else {
                    $message = 'Permit Deadline added by ' . $this->loggedusername;
                    $activity = 'Add';
                }

                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'deadlines';
                $saveActivityLog['module_name'] = 'Permit Deadline';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = $activity;
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
            }
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getRelatedDeadline($permitId) {
        $this->autoRender = false;
        $this->loadModel('Deadlines');
        $permitDeadline = $this->Deadlines->getAdminDataByPermitId($permitId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('permitDeadline', 'redirectHere'));
        echo $this->render('/Element/backend/permit/deadline_list');
        exit;
    }

    /**
     * 
     */
    public function saveRelatedAlert($permitId) {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Alerts');
            $this->request->data['PermitAlert']['id'] = $this->request->data['PermitAlert']['alert_id'];
            $response = $this->Alerts->saveAdminPermitData($this->request->data['PermitAlert'], $permitId);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                if (!empty($permitId)) {
                    $this->_updatedBy('Permits', $permitId);
                }
                /* === Added by vipin for  add log=== */
                if (!empty($this->request->data['PermitAlert']['alert_id'])) {
                    $message = 'Permit Alert updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                } else {
                    $message = 'Permit Alert added by ' . $this->loggedusername;
                    $activity = 'Add';
                }
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'alerts';
                $saveActivityLog['module_name'] = 'Permit Alert';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = $activity;
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
            }
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getRelatedAlert($permitId) {
        $this->autoRender = false;
        $this->loadModel('AlertPermits');
        $alertPermits = $this->AlertPermits->getDataByPermitId($permitId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('alertPermits', 'redirectHere'));
        echo $this->render('/Element/backend/permit/alert_list');
        exit;
    }

    # OLD ACTION


    /*
     * @Function: getAgencyContacts()
     * @Description: use for get conatct person related to agency
     * @param type $categoryId
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function getAgencyContacts($categoryId = null) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        if ($this->request->is('post')) {
            $agencyContacts = $this->AgencyContacts->find('list');
            $agencyContacts->hydrate(false)->where(['AgencyContacts.agency_id' => $this->request->data['categoryId'], 'AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1]);
            $agencyContactslist = $agencyContacts->toArray();

            $listHtml = '<option value="">-- Select contact person -- </option>';
            $listArray = array();

            foreach ($agencyContactslist as $key => $value) {
                $listHtml .= '<option value="' . $key . '">' . $value . '</option>';
                $listArray[$key] = $value;
            }

            echo $listHtml;
            exit;
        }
    }

    /*
     * @Function: edit()
     * @Description: use for edit permit
     *  @param type $id
     * @return type: edited record
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */



    /*
     * @Function: downloadPermitForm()
     * @Description: use for download permit forms
     * @param type $id
     * @By @Ahsan Ahamad
     * @Date : 8th Dec. 2017
     */

    public function downloadPermitForm($id = null) {
        $id = $this->Encryption->decode($id);
        $this->autoRender = false;
        if (!empty($id)) {
            $this->loadModel('Documents');
            $form = $this->Documents->find()->where(['Documents.form_id =' => $id])->first();
            if (!empty($form)) {
                $path = WWW_ROOT . $form['path'];

                if (is_file($path)) {
                    $this->response->file($path, array(
                        'download' => true,
                        'name' => basename($form['path']),
                    ));
                    return $this->response;
                } else {
                    $this->Flash->error("Image not found");
                    $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error("Image not found");
                $this->redirect($this->referer());
            }
        }
    }

    /* @Function: addPermitDeadline()
     * @Description: add deadline of the permit form permit view popup  
     * @By @Ahsan Ahamad
     * @Date : 8th Dec. 2017
     */

    public function addPermitDeadline() {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitDeadlines');
            $this->request->data['user_id'] = $this->userId;
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            if (!empty($this->request->data['form_deadline_id'])) {
                $permitDeadlines = $this->PermitDeadlines->get($this->request->data['form_deadline_id']);
                $response['msg'] = 'Permit deadline has been updated successfully';
            } else {
                $permitDeadlines = $this->PermitDeadlines->newEntity();
                $response['msg'] = 'Permit deadline has been added successfully';
            }
            $this->PermitDeadlines->patchEntity($permitDeadlines, $this->request->data);
            if (!$permitDeadlines->errors()) {
                if ($succese = $this->PermitDeadlines->save($permitDeadlines)) {
                    /* get all agencies list */
                    $response['flag'] = true;
                    $response['permit_deadline_id'] = $succese->id;
                    $response['form_id'] = $this->request->data['form_id'];
                } else {
                    $response['msg'] = 'Permit deadline could not be added successfully';
                }
            } else {
                $response['flag'] = true;
                $response['msg'] = $this->Custom->multipleFlash($permitDeadlines->errors());
            }
            echo json_encode($response);
            exit;
        }
    }

    /* @Function: getRelatedDeadline()
     * @Description: get permit Deadline  document of the permit form element file  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017
     */

    public function getRelatedDeadline1($formId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitDeadlines');
        $form['permit_deadlines'] = $this->PermitDeadlines->find()->where(['PermitDeadlines.form_id' => $formId, 'PermitDeadlines.is_active' => 1, 'PermitDeadlines.is_deleted' => 0])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit'));
        // Render the json element  
        echo $this->render('/Element/backend/permit/deadline_list');
        exit;
    }

    /* @Function: addPermitAgency()
     * @Description:add agency of the permit form permit  popup  
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017
     */

    public function addPermitAgency() {
        $this->autoRender = false;
        $this->viewBuilder()->layout('');

        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            if (!empty($this->request->data['agency_id'])) {
                $this->loadModel('PermitAgencies');
                $this->loadModel('PermitAgencyContacts');
                $this->loadModel('Categories');
                $this->request->data['user_id'] = $this->userId;
                $agencyId = $this->PermitAgencies->find()->select('id')->where(['PermitAgencies.agency_id' => $this->request->data['agency_id'], 'PermitAgencies.permit_id' => $this->request->data['permit_id'], 'PermitAgencies.id <>' => $this->request->data['permit_agency_id'], 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->first();

                //    if (empty($agencyId->id)) {

                $agency['agency_id'] = $this->request->data['agency_id'];
                $agency['added_by'] = $this->request->data['user_id'];
                $agency['permit_id'] = $this->request->data['permit_id'];

                if (empty($this->request->data['permit_agency_id'])) {
                    $permitAgency = $this->PermitAgencies->newEntity();
                } else {
                    $permitAgency = $this->PermitAgencies->get($this->request->data['permit_agency_id']);
                }
                $this->PermitAgencies->patchEntity($permitAgency, $agency);

                if (!$permitAgency->errors()) {
                    if ($succese = $this->PermitAgencies->save($permitAgency)) {

                        if ($this->request->data['agency_conatct_id']) {
                            $conditionSample = array('PermitAgencyContacts.permit_agency_id' => $this->request->data['permit_agency_id']);
                            $this->PermitAgencyContacts->deleteAll($conditionSample, false);

                            foreach ($this->request->data['agency_conatct_id'] as $contactPerson) {
                                $agencyContact['permit_agency_id'] = $succese->id;
                                $agencyContact['agency_contact_id'] = $contactPerson;
                                $agencyContact['agency_id'] = $this->request->data['agency_id'];
                                $agencyContact['added_by'] = $this->request->data['user_id'];
                                $agencyContact['permit_id'] = $this->request->data['permit_id'];
                                $permitAgencyConatcts = $this->PermitAgencyContacts->newEntity();
                                $this->PermitAgencyContacts->patchEntity($permitAgencyConatcts, $agencyContact);
                                $this->PermitAgencyContacts->save($permitAgencyConatcts);
                            }
                        }
                        $agency['agency_contact_id'] = $this->request->data['agency_conatct_id'];

                        /* get save agencies list */
                        $response['flag'] = true;

                        $response['permitAgencyId'] = $succese->id;
                        $response['permit_id'] = $this->request->data['permit_id'];
                        $response['msg'] = 'Permit agency has been added successfully';
                    } else {
                        $response['msg'] = 'Permit agency could not be added successfully';
                    }
                } else {
                    $response['flag'] = false;
                    $response['msg'] = $this->Custom->multipleFlash($permitAgency->errors());
                }
            } else {
                $response['msg'] = 'Please select Agency';
            }

            echo json_encode($response);
            exit;
        }
    }

    /* @Function: getRelatedAgency()
     * @Description:get agency related to permit  
     * @param type $permitId
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017

     */

    public function getRelatedAgency1($permitId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitAgencies');
        $form['permit_agency'] = $this->PermitAgencies->find()->contain(['Categories', 'PermitAgencyContacts.AgencyContacts'])->where(['PermitAgencies.permit_id' => $permitId, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->first();

        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit'));

        echo $this->render('/Element/backend/permit/agency_list');
        exit;
    }

    /* @Function: getPermitAgencyConatcPerson()
     * @Description:get agency related to permit contact person  
     * @param type $agencyId
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017

     */

    public function getPermitAgencyConatcPerson($permit_agency_id = null) {
        $this->autoRender = false;
        $this->loadModel('PermitAgencyContacts');
        $this->loadModel('AgencyContacts');
        $permitAgencyContacts = $this->PermitAgencyContacts->find('list', ['keyField' => 'id', 'valueField' => 'agency_contact_id']);
        $permitAgencyContacts->hydrate(false)->where(['PermitAgencyContacts.is_deleted' => 0, 'PermitAgencyContacts.is_active' => 1, 'PermitAgencyContacts.permit_agency_id' => $permit_agency_id]);
        $list = $permitAgencyContacts->toArray();
        if (!$list) {
            $list = '';
        }
        echo json_encode($list);

        exit;
    }

    /* @Function: addPermitOperation()
     * @Description:add operation of the permit form permit operation popup   
     * @By @Ahsan Ahamad
     * @Date : 14th Jan. 2018
     */

    public function addPermitOperation() {
        $this->autoRender = false;
        $this->viewBuilder()->layout('');

        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {

            $this->loadModel('PermitOperations');
            $this->request->data['user_id'] = $this->userId;
            foreach ($this->request->data['operation_id'] as $operation) {
                $operationId = $this->PermitOperations->find()->select('id')->where(['PermitOperations.operation_id' => $operation, 'PermitOperations.permit_id' => $this->request->data['permit_id'], 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1])->first();

                if (empty($operationId->id)) {
                    $operations['operation_id'] = $operation;
                    $operations['added_by'] = $this->request->data['user_id'];
                    $operations['permit_id'] = $this->request->data['permit_id'];

                    if (empty($this->request->data['id'])) {
                        $permitOperation = $this->PermitOperations->newEntity();
                        $response['msg'] = 'Permit operation has been updated successfully';
                    } else {
                        $permitAgency = $this->PermitOperations->get($this->request->data['id']);
                        $response['msg'] = 'Permit operation has been added successfully';
                    }
                    $this->PermitOperations->patchEntity($permitOperation, $operations);

                    if (!$permitOperation->errors()) {
                        $succese = $this->PermitOperations->save($permitOperation);
                        if ($succese) {
                            /* get save agencies list */
                            $response['flag'] = true;

                            $response['permitOperationId'] = $succese->id;
                            $response['permit_id'] = $this->request->data['permit_id'];
                        } else {
                            $response['msg'] = 'Permit operation could not be added successfully';
                        }
                    } else {
                        $response['flag'] = false;
                        $response['msg'] = $this->Custom->multipleFlash($permitAgency->errors());
                    }
                } else {
                    $response['msg'] = 'Operation is already exit of the permit';
                }
            }
            echo json_encode($response);
            exit;
        }
    }

    /* @Function: getRelatedAgency()
     * @Description:get agency related to permit  
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017

     */

    public function getRelatedOperation1($permitId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitOperations');
        $form['permit_operations'] = $this->PermitOperations->find()->contain('Operations')->where(['PermitOperations.permit_id' => $permitId, 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit'));
        echo $this->render('/Element/backend/permit/operation_list');
        exit;
    }

    /* @Function:addPermitForms()
     * @Description:add permit form permit  popup  
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017

     */

    public function addPermitForms() {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Documents');
            $this->loadModel('FormDocumentSamples');
            $userId = $this->userId;
            $formId = $this->request->data['form_id'];
            if (!empty($this->request->data['forms'])) {
                foreach ($this->request->data['forms'] as $key => $formDocument) {
                    $pathDocument = 'files/form_documents';
                    $documentdata['name'] = $formDocument['form_name'];
                    if ($formDocument['form_document']) {
                        $Documentfiles = $this->Upload->uploadOtherFile($formDocument['form_document'], $pathDocument);
                    }
                    $documentdata['path'] = $Documentfiles;
                    $documentdata['form_id'] = $formId;
                    $documentdata['created'] = date('Y-m-d h:i:s');
                    if (!empty($this->request->data['form_document_id'])) {
                        $document = $this->Documents->get($this->request->data['form_document_id']);
                    } else {
                        $document = $this->Documents->newEntity();
                    }
                    $asset = $this->Documents->patchEntity($document, $documentdata);
                    $saveDocument = $this->Documents->save($document);
                    /* code for sample document of the form */

                    if ($formDocument['form_sample']) {
                        $pathSampleDocument = 'files/form_documents/sample';
                        $sampledocument['form_id'] = $formId;
                        $sampledocument['form_document_id'] = $saveDocument->id;
                        $sampledocument['created'] = date('Y-m-d h:i:s');
                        if (!empty($formDocument['form_sample'])) {
                            foreach ($formDocument['form_sample'] as $sampleDocumentfile) {

                                $sampleDocumentfiles = $this->Upload->uploadOtherFile($sampleDocumentfile, $pathSampleDocument);
                                $sampledocument['path'] = $sampleDocumentfiles;
                                $formDocumentSamples = TableRegistry::get('FormDocumentSamples');
                                $documentSample = $formDocumentSamples->newEntity($sampledocument);
                                $asset = $this->FormDocumentSamples->patchEntity($documentSample, $sampledocument);
                                $formDocumentSamples->save($documentSample);
                            }
                        }
                    }

                    if ($saveDocument) {
                        $response['flag'] = true;
                        $response['`form_documents'] = $saveDocument->id;
                        $response['form_id'] = $this->request->data['form_id'];
                        $response['msg'] = 'Form has been added successfully';
                    } else {
                        $response['msg'] = 'Form agency could not be added successfully';
                    }
                }
            } else {
                $response['msg'] = 'Please upload forms';
            }
            echo json_encode($response);
            exit;
        }
    }

    /* @Function:getRelatedForms()
     * @Descrition: get forms of the permit form permit operation popup  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getRelatedForms1($formId = null) {
        $this->autoRender = false;
        $this->loadModel('Documents');
        $form['documents'] = $this->Documents->find()->contain(['FormDocumentSamples'])->where(['Documents.form_id' => $formId, 'Documents.is_active' => 1, 'Documents.is_deleted' => 0])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit'));
        echo $this->render('/Element/backend/permit/forms_list');
        exit;
    }

    /* @Function:getRelatedDocuments()
     * @Descrition: get  documents of the permit form permit operation popup
     * @param type $formId     
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getRelatedDocuments1($formId = null) {
        $this->autoRender = false;
        $this->loadModel('Documents');
        $form['documents'] = $this->Documents->find()->contain(['FormDocumentSamples'])->where(['Documents.form_id' => $formId, 'Documents.is_active' => 1, 'Documents.is_deleted' => 0])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit'));
        echo $this->render('/Element/backend/permit/forms_list');
        exit;
    }

    /* @Function:getRelatedDocuments()
     * @Descrition:add form attechment file of the permit  
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017

     */

    public function addPermitFormsAttachment() {

        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('FormAttachments');
            $this->loadModel('FormAttachmentSamples');
            $userId = $this->userId;
            $formId = $this->request->data['form_id'];

            /* Save form attachments date in form_attachments table */

            if (!empty($this->request->data['form_attachment'])) {

                $formAttachmentData['form_id'] = $formId;
                $formAttachmentData['created'] = date('Y-m-d h:i:s');
                foreach ($this->request->data['form_attachment'] as $formAttachment) {
                    $formAttachmentData['name'] = $formAttachment['document_name'];
                    $formAttachmentData['is_mandatory'] = $formAttachment['is_mandatory'];

                    if (!empty($this->request->data['form_attachment_id'])) {
                        $formAttachmentTable = $this->FormAttachments->get($this->request->data['form_attachment_id']);
                    } else {
                        $formAttachmentTable = $this->FormAttachments->newEntity();
                    }
                    $this->FormAttachments->patchEntity($formAttachmentTable, $formAttachmentData);
                    $saveFormAttachment = $this->FormAttachments->save($formAttachmentTable);

                    /* Save form attachments file in form_attachments table */
                    foreach ($formAttachment['document_sample'] as $attachmentFiel) {

                        $pathFormAttachments = 'files/form_documents/attachment';
                        $formAttachmentFile['form_attachment_id'] = $saveFormAttachment->id;
                        $formAttachmentFile['form_id'] = $formId;
                        $formAttachmentFiles = $this->Upload->uploadOtherFile($attachmentFiel, $pathFormAttachments);

                        $formAttachmentFile['path'] = $formAttachmentFiles;
                        $formAttachmentSamplesTable = TableRegistry::get('FormAttachmentSamples');

                        if (!empty($this->request->data['form_attachment_id'])) {
                            $formAttachmentSamplesTable = $formAttachmentSamplesTable->get($this->request->data['form_attachment_id']);
                        } else {
                            $formAttachmentSamplesTable = $formAttachmentSamplesTable->newEntity($formAttachmentFile);
                        }

                        $this->FormAttachmentSamples->patchEntity($formAttachmentSamplesTable, $formAttachmentFile);
                        $saveFormAttachmentSample = $this->FormAttachmentSamples->save($formAttachmentSamplesTable);
                    }
                }
                $response['flag'] = true;
                $response['`form_attachments'] = $saveFormAttachment->id;
                $response['form_id'] = $this->request->data['form_id'];
                $response['msg'] = 'Document has been added successfully';
            } else {
                $response['msg'] = 'Please Upload Document';
            }
        }

        echo json_encode($response);
        exit;
    }

    /* @Function:getRelatedFormAttachment()
     * @Descrition:get forms attachmentmnt  document of the permit  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getRelatedFormAttachment($formId = null) {
        $this->autoRender = false;
        $this->loadModel('FormAttachments');
        $form['form_attachments'] = $this->FormAttachments->find()->contain(['FormAttachmentSamples'])->where(['FormAttachments.form_id' => $formId, 'FormAttachments.is_active' => 1, 'FormAttachments.is_deleted' => 0])->all();

        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit', 'redirectHere'));
        echo $this->render('/Element/backend/permit/documents_list');
        exit;
    }

    /* @Function: addPermitFormsAlert()
     * @Descrition:add agency of the permit form document permit  popup  
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function addPermitFormsAlert() {

        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';

        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $userId = $this->userId;
        $formId = $this->request->data['form_id'];

        if ($this->request->is('post')) {
            $this->loadModel('AlertOperations');
            $this->loadModel('AlertCompanies');
            $this->loadModel('AlertStaffs');
            $this->loadModel('Users');
            $this->loadModel('Alerts');
            $this->loadModel('AlertPermits');
            $this->request->data['flag'] = 4;
            $this->request->data['is_admin'] = 1;
            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $this->request->data['user_id'] = $userId;
            $this->request->data['interval_value'] = $this->request->data['interval'];
            if (!empty($this->request->data['interval'])) {
                $this->request->data['interval_alert'] = (int) $this->request->data['interval'];
            }

            if ($this->request->data['alert_id']) {
                $alerts = $this->Alerts->get($this->request->data['alert_id']);
                $response['msg'] = 'Alerts has been updated successfully.';
            } else {
                $alerts = $this->Alerts->newEntity();
                $response['msg'] = 'Alerts has been added successfully.';
            }

            $this->Alerts->patchEntity($alerts, $this->request->data, ['validate' => 'Add']);
            if (!$alerts->errors()) {
                $success = $this->Alerts->save($alerts);

                if ($success) {
                    $alertPermit['alert_id'] = $success->id;
                    $alertPermit['form_id'] = $this->request->data['form_id'];
                    $alertPermit['user_id'] = $userId;
                    if ($this->request->data['form_permit_id']) {
                        $alertPermits = $this->AlertPermits->get($this->request->data['form_permit_id']);
                    } else {
                        $alertPermits = $this->AlertPermits->newEntity();
                    }
                    $this->AlertPermits->patchEntity($alertPermits, $alertPermit);
                    $successAlertPermit = $this->AlertPermits->save($alertPermits);

                    /* code for save alert company */
                    if (!empty($this->request->data['company_id']) && $this->request->data['alert_type_id'] == 3) {
                        $conditionSample = array('AlertCompanies.alert_id' => $this->request->data['alert_id']);
                        $this->AlertCompanies->deleteAll($conditionSample, false);
                        foreach ($this->request->data['company_id'] as $key => $value) {
                            $company = $this->Users->find()->contain(['Employees'])->select(['Users.email', 'Users.id'])->where(['Users.id' => $value])->first();
                            $emails[] = $company->email;
                            foreach ($company->employees as $employee) {
                                $emails[] = $employee->email;
                            }
                            $companydata['company_id'] = $value;
                            $companydata['created'] = date('Y-m-d');
                            $companydata['alert_id'] = $success->id;
                            $companydata['alert_type_id'] = $this->request->data['alert_type_id'];
                            // prx($companydata);
                            $companies = $this->AlertCompanies->newEntity();
                            $this->AlertCompanies->patchEntity($companies, $companydata);
                            $successAlertCompany = $this->AlertCompanies->save($companies);
                        }
                        if ($success) {
                            /* code for send email to multiple users and companies */
                            $template = 'new_alert';
                            $subject = "New Alerts";
                            $this->Custom->sendMultipleEmail($emails, $template, $subject);
                        }
                    }
                    /* code for save alert Staff */
                    if (!empty($this->request->data['staff_id']) && $this->request->data['alert_type_id'] == 2) {
                        $conditionSample = array('AlertStaffs.alert_id' => $this->request->data['alert_id']);
                        $this->AlertStaffs->deleteAll($conditionSample, false);

                        foreach ($this->request->data['staff_id'] as $key => $value) {
                            $staff['user_id'] = $value;
                            $staff['created'] = date('Y-m-d');
                            $staff['alert_id'] = $success->id;
                            $staff['alert_type_id'] = $this->request->data['alert_type_id'];
                            $staffs = $this->AlertStaffs->newEntity();
                            $this->AlertStaffs->patchEntity($staffs, $staff);
                            $successAlertStaff = $this->AlertStaffs->save($staffs);
                        }
                        if ($successAlertStaff) {
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
                    if (!empty($this->request->data['operation_id']) && $this->request->data['alert_type_id'] == 4) {
                        $conditionSample = array('AlertOperations.alert_id' => $this->request->data['alert_id']);
                        $this->AlertOperations->deleteAll($conditionSample, false);

                        foreach ($this->request->data['operation_id'] as $key => $value) {
                            $industry['operation_id'] = $value;
                            $industry['created'] = date('Y-m-d');
                            $industry['alert_id'] = $success->id;
                            $industry['alert_type_id'] = $this->request->data['alert_type_id'];
                            $industryies = $this->AlertOperations->newEntity();
                            $this->AlertOperations->patchEntity($industryies, $industry);
                            $successAlertIndusty = $this->AlertOperations->save($industryies);
                        }
                    }

                    $response['flag'] = true;
                    $response['`alert_id'] = $success->id;
                    $response['form_id'] = $this->request->data['form_id'];
                } else {
                    $response['flag'] = false;

                    $response['msg'] = 'Alerts could not be added.';
                }
            } else {
                $response['flag'] = false;
                $response['msg'] = $this->Custom->multipleFlash($alerts->errors());
            }
        }
        echo json_encode($response);
        exit;
    }

    /* @Function: addPermitgetRelatedFormAlertFormsAlert()
     * @Descrition:get alert of the permit 
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getRelatedFormAlert($formId = null) {
        $this->autoRender = false;
        $this->loadModel('AlertPermits');
        $form['alert_permits'] = $this->AlertPermits->find()->hydrate(false)
                        ->contain(['Alerts'])
                        ->where(['AlertPermits.form_id =' => $formId, 'AlertPermits.is_active' => 1, 'AlertPermits.is_deleted' => 0])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit', 'redirectHere'));
        echo $this->render('/Element/backend/permit/alerts_list');
        exit;
    }

    /* @Function: getAlertData()
     * @Descrition: use for get alert form related form list comapnies/staff/ after select alert type by ajax .
     * @param type $alertId and $alertType
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getAlertData($alertId = null, $alertType = null) {
        $this->autoRender = false;
        /* get all staff related company list */
        if ($alertType == 2) {
            $this->loadModel('AlertStaffs');
            $alertStaff = $this->AlertStaffs->find('list', ['keyField' => 'user_id', 'valueField' => 'user_id']);
            $alertStaff->hydrate(false)->where(['AlertStaffs.alert_id' => $alertId]);
            $list = $alertStaff->toArray();
        }
        /* get all company  list */

        if ($alertType == 3) {
            $this->loadModel('AlertCompanies');
            $alertStaff = $this->AlertCompanies->find('list', ['keyField' => 'company_id', 'valueField' => 'company_id']);
            $alertStaff->hydrate(false)->where(['AlertCompanies.alert_id' => $alertId]);
            $list = $alertStaff->toArray();
        }
        /* get all operation list */

        if ($alertType == 4) {
            $this->loadModel('AlertOperations');
            $alertStaff = $this->AlertOperations->find('list', ['keyField' => 'operation_id', 'valueField' => 'operation_id']);
            $alertStaff->hydrate(false)->where(['AlertOperations.alert_id' => $alertId]);
            $list = $alertStaff->toArray();
        }

        if (!$list) {
            $list = '';
        }
        echo json_encode(implode(',', $list));

        exit;
    }

    /* @Function: permit()
     * @Descrition: use for get new permit.
     * @param type: $id
     * @By @Ahsan Ahamad
     * @Date : 18 Dec. 2017
     */



    /* @Function: savePermitData()
     * @Descrition: use for save new permit from ajax
     * @By @Ahsan Ahamad
     * @Date : 18 Dec. 2017
     */



    /* @Function:addPermitInstructions()
     * @Descrition:add Instruction of the permit  
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017

     */

    public function addPermitInstructions() {

        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitInstructions');
            $userId = $this->userId;
            $permitId = $this->request->data['permit_id'];

            /* Save form attachments date in form_attachments table */

            if (!empty($this->request->data['file_path'])) {
                $fielPath = 'files/form_documents/instruction';
                $permitInstructionFiles = $this->Upload->uploadOtherFile($this->request->data['file_path'], $fielPath);
                $this->request->data['file_path'] = $permitInstructionFiles;
            } else {
                $response['msg'] = 'Please Upload Document';
            }

            if ($this->request->data['permit_instruction_id']) {
                $permitInsructions = $this->PermitInstructions->get($this->request->data['permit_instruction_id']);
                $response['msg'] = 'Instrction has been updated successfully';
            } else {
                $permitInsructions = $this->PermitInstructions->newEntity();
                $response['msg'] = 'Instrction has been added successfully';
            }
            $permitInsructions = $this->PermitInstructions->patchEntity($permitInsructions, $this->request->data);
            if (!$permitInsructions->errors()) {
                if ($successInstruction = $this->PermitInstructions->save($permitInsructions)) {
                    $response['flag'] = true;
                    $response['`permit_instruction_id'] = $successInstruction->id;
                    $response['permit_id'] = $this->request->data['permit_id'];
                } else {
                    $response['flag'] = false;
                    $response['msg'] = 'Instrction could not be added successfully.';
                }
            } else {
                $response['flag'] = false;
                $response['msg'] = $this->Custom->multipleFlash($permitInsructions->errors());
            }

            echo json_encode($response);
            exit;
        }
    }

    /* @Function:getRelatedFormAttachment()
     * @Descrition:get forms attachmentmnt  document of the permit  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getPermitInstructions($permitId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitInstructions');
        $form['permit_instructions'] = $this->PermitInstructions->find()->where(['PermitInstructions.permit_id' => $permitId, 'PermitInstructions.is_deleted' => 0, 'PermitInstructions.is_active' => 1])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($permitId));
        $this->set(compact('form', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit', 'redirectHere'));
        echo $this->render('/Element/backend/permit/permit_instruction_list');
        exit;
    }

    /* @Function: addPermitFormsAlert()
     * @Descrition:add agency of the permit form document permit  popup  
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */
}
