<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Utility\Inflector;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class PermitsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamads
     * Date : 2nd Nov. 2017
     */

    public $companyId;
    public $emaployeeId;
    public $userId;

    public function initialize() {
        parent::initialize();

        if ($this->Auth->user('user_id') != 0) {
            $this->companyId = $this->Auth->user('user_id');
            $this->userId = $this->Auth->user('user_id');
        } else {
            $this->emaployeeId = $this->Auth->user('id');
            $this->userId = $this->Auth->user('id');
        }
        $this->loadComponent('Upload');
    }

    /*
     * Function: current()
     * Description: List of all permits
     * @param type 
     * By @Vipin chauhan
     * Date : 5th Feb. 2018
     */

    public function current() {

        $pageTitle = 'Permits';
        $this->set('pageTitle', $pageTitle);
        $loggedCompanyId = Configure::read('LoggedCompanyId');

        $this->LocationOperations = TableRegistry::get('LocationOperations');
        $userLocationId = null;
        if (!empty($this->request->query['location_id'])) {
            $userLocationId = $this->request->query['location_id'];
        }
        $operationList = $this->LocationOperations->getOperationListByUserId($loggedCompanyId, $userLocationId);
        $this->PermitOperations = TableRegistry::get('PermitOperations');
        $operationList = array_values($this->PermitOperations->getOperationListByOperationId($operationList));
        if (empty($operationList)) {
            $operationList[0] = 0;
        }
        $this->loadModel('UserLocations');
        $this->loadModel('Operations');
        $userLocationList = $this->UserLocations->getUserLocationListByUserId($loggedCompanyId);
        $userOperationList = $this->Operations->getOperationListById($operationList);
        $condition = ['LocationOperations.user_id' => $loggedCompanyId,
            'LocationOperations.operation_id IN' => $operationList,
        ];
        if ($this->request->query) {
            if (!empty($this->request->query['operation_id'])) {
                $condition['LocationOperations.operation_id IN'] = [$this->request->query['operation_id']];
            }
            if (!empty($this->request->query['location_id'])) {
                $condition['LocationOperations.user_location_id'] = $this->request->query['location_id'];
            }
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
            'conditions' => $condition,
            'limit' => $this->paginationLimit,
            'contain' => [
                'Operations', 'UserLocations',
                'Operations.PermitOperations.Permits',
                'Operations.PermitOperations.Permits.PermitAgencies.Agencies',
            ]
        ];
        $data = $this->paginate($this->LocationOperations);
        $permitStatusTable = TableRegistry::get('PermitStatus');
        $permitStatusses = $permitStatusTable->find('list')->toArray();
        $this->set(compact('data', 'permitStatusses', 'userLocationList', 'userOperationList'));
    }

    /*
     * Function:  view()
     * Description: view the detal
     * @param: $id ,
     * By @Vipin chauhan
     * Date : 5th Feb. 2018
     */

    public function view($permitId = null, $operationId = null, $locationId = null) {

        $pageTitle = 'Permit | View';
        $pageHedding = 'View ';
        $this->set(compact('permitId', 'operationId', 'locationId'));
        $breadcrumb = array(
            array('label' => 'Permit', 'link' => 'permits/current'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $permitId = $this->Encryption->decode($permitId);
        $permit = $this->Permits->find()->hydrate(false)->where(['Permits.id =' => $permitId])->first();
        //prx($permit);die; 
        $this->set(compact('permit'));
    }

    /*
     * Function: permitDetails()
     * Description: use for show all details of permit releted to specefic permit
     * @param type $formId
     * By @Ahsan Ahamad
     * Date : 12th DEC. 2017
     */

    public function details($permitId, $operationId, $locationId, $userPermitId = null) {
        $redirectHere = 'permits/details/' . $permitId . '/' . $operationId . '/' . $locationId;
        $this->set(compact('permitId', 'operationId', 'locationId', 'redirectHere'));
        $pageTitle = 'Permit';
        $pageHedding = 'Permit';
        $breadcrumb = array(
            array('label' => 'Permit', 'link' => 'permits/current'),
            array('label' => 'View', 'link' => 'permits/view/' . $permitId . '/' . $operationId . '/' . $locationId),
            array('label' => 'Detail'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $breadcrumbBottam = array(
            array('label' => 'Permit'),
        );

        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $permitId = $this->Encryption->decode($permitId);
        $operationId = $this->Encryption->decode($operationId);
        $locationId = $this->Encryption->decode($locationId);
        $userPermitId = $this->Encryption->decode($userPermitId);
        $this->loadModel('UserPermits');
        $this->loadModel('Documents');
        $this->loadModel('Permits');
        $this->loadModel('PermitAgencies');
        if (empty($userPermitId)) {
            $accessPermits = $this->UserPermits->find()->where(['UserPermits.user_id' => Configure::read('LoggedCompanyId'), 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId, 'UserPermits.is_previous' => 0, 'UserPermits.permit_status_id !=' => 0])->first();
        } else {
            $accessPermits = $this->UserPermits->find()->where(['UserPermits.id' => $userPermitId])->first();
        }

        if (empty($accessPermits)) {
            /* ---save data in UserPermit model-------------- */
            $data['company_id'] = Configure::read('LoggedCompanyId');
            $data['user_id'] = $this->Auth->user('id');
            $data['permit_id'] = $permitId;
            $data['operation_id'] = $operationId;
            $data['user_location_id'] = $locationId;
            $data['status_id'] = 2;
            $data['is_previous'] = 0;
            $this->loadModel('UserPermits');
            $result = $this->UserPermits->saveData($data);
            $accessPermits = $this->UserPermits->find()->where(['UserPermits.user_id' => $this->userId, 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId, 'UserPermits.is_previous' => 0, 'UserPermits.permit_status_id !=' => 0])->first();
            $this->_updatedBy('UserPermits', $accessPermits->id);
        }
        $permitDetails = $this->Permits->permitDetails($accessPermits->permit_id, $accessPermits->id, 1);
        //prx($permitDetails);
        $this->loadModel('Deadlines');
        $userPermitDeadlines = $this->Deadlines->getCompanyDataByPermitId($accessPermits->permit_id, $accessPermits->id);
        //prx($userPermitDeadlines);
        $permitAgencyContact = $this->PermitAgencies->getAgencyDetails($permitId);

        $this->set(compact('accessPermits', 'permitDetails', 'userPermitDeadlines', 'alertTypesList', 'permitAgencyContact'));

        $this->loadModel('SecurityTypes');
        $securityTypes = $this->SecurityTypes->getList();
        $this->set(compact('securityTypes'));

        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getCompanyAlertType();
        $this->set(compact('alertTypeList'));

//        $this->loadModel('DeadlineTypes');
//        $deadlineTypeList = $this->DeadlineTypes->getCompanyDeadlineType();
//        $this->set(compact('deadlineTypeList'));
//
//        $this->getAssignedPermitDocument($accessPermits->permit_id);
//        $this->getAssignedPermitForm($accessPermits->permit_id);

        $this->loadModel('Users');
        $companyStaffList = $this->Users->getStaffList(Configure::read('LoggedCompanyId'));
        $this->set(compact('companyStaffList'));
    }

    private function getAssignedPermitDocument($permit_id) {
        $this->loadModel('PermitDocuments');
        $this->loadModel('Documents');
        $docList = $this->PermitDocuments->getAssignedDocumentListByPermitId($permit_id);
        $permitDocumentList = $this->Documents->getAssignedDocumentList($docList);
        $this->set(compact('permitDocumentList'));
    }

    private function getAssignedPermitForm($permit_id) {
        $this->loadModel('PermitForms');
        $permitFormList = $this->PermitForms->getAssignedPermitFormList($permit_id);
        $this->set(compact('permitFormList'));
    }

    /**
     * 
     */
    public function saveRelatedAlert($permitId, $locationId, $operationId, $userPermitId = null) {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Alerts');
            $this->request->data['PermitAlert']['id'] = $this->request->data['PermitAlert']['alert_id'];
            $response = $this->Alerts->saveCompanyPermitData($this->request->data['PermitAlert'], $permitId);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                $this->_updatedBy('UserPermits', $userPermitId);
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
        echo $this->render('/Element/frontend/permit/alert_list');
        exit;
    }

    /**
     * 
     */
    public function saveRelatedForm($permitId, $userPermitId) {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $permitForm = $this->request->data();
            $fileError = $this->Upload->checkFileUpload($_FILES);
            if ($fileError == 'Success') {
                $formSamplePath = 'files/user_permits/forms';
                $uploadResponse = $this->Upload->uploadOtherFile($permitForm['PermitForm']['file'], $formSamplePath);
                if ($uploadResponse && $permitId && $userPermitId) {
                    $this->loadModel('UserPermitForms');
                    $data = [];
                    $data['permit_form_id'] = $permitForm['PermitForm']['id'];
                    $data['file'] = $uploadResponse;
                    $data['security_type_id'] = $permitForm['PermitForm']['security_type_id'];
                    $result = $this->UserPermitForms->saveData($permitId, $userPermitId, $data);
                    if ($result) {
                        $this->_updatedBy('UserPermits', $userPermitId);
                        /* === Added by vipin for  add log=== */
                        $message = 'Permit Form uploaded by ' . $this->loggedusername;
                        $saveActivityLog = [];
                        $saveActivityLog['table_id'] = $result['id'];
                        $saveActivityLog['table_name'] = 'user_permit_forms';
                        $saveActivityLog['module_name'] = 'Permit Form Upload';
                        $saveActivityLog['url'] = $this->referer();
                        $saveActivityLog['message'] = $message;
                        $saveActivityLog['activity'] = 'Upload';
                        $this->Custom->saveActivityLog($saveActivityLog);
                        /* === Added by vipin for  add log=== */
                        $response['msg'] = 'Form added successfully';
                        $response['flag'] = TRUE;
                    } else {
                        $response['msg'] = 'Something went wrong Please try again';
                    }
                } else {
                    $response['msg'] = 'Something went wrong Please try again';
                }
            } else {
                $response['msg'] = 'Please upload pdf file only';
            }
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $permitId
     */
    public function getRelatedForm($permitId, $userPermitId) {
        $this->autoRender = false;

        $this->loadModel('SecurityTypes');
        $securityTypes = $this->SecurityTypes->getList();
        $this->set(compact('securityTypes'));

        $this->loadModel('PermitForms');

        $permitForms = $this->PermitForms->find('all')->contain(['PermitFormSamples',
                    'UserPermitForms' => function($q) use( $userPermitId ) {
                        return $q
                                        ->where(['UserPermitForms.is_deleted' => 0, 'UserPermitForms.user_permit_id' => $userPermitId])
                                        ->select(['id', 'permit_form_id', 'file', 'security_type_id', 'modified']);
                    },
                ])->where(['PermitForms.permit_id' => $permitId, 'PermitForms.is_deleted' => 0])->toArray();

        $this->set(compact('permitForms', 'permitId', 'userPermitId'));
        echo $this->render('/Element/frontend/permit/form_list');
        exit;
    }

    /**
     * 
     */
    public function saveRelatedDocument($permitId, $userPermitId) {

        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $documentData = $this->request->data();

            $fileError = $this->Upload->checksaveRelatedDocument($_FILES);
            //if($fileError == 'Success')
            if (true) {
                $formSamplePath = 'files/user_permits/documents';
                $uploadResponse = $this->Upload->uploadOtherFile($documentData['PermitDocument']['file'], $formSamplePath);
                if ($uploadResponse && $permitId && $userPermitId) {
                    $this->loadModel('UserPermitDocuments');
                    $data = [];
                    $data['permit_document_id'] = $documentData['PermitDocument']['id'];
                    $data['document_id'] = $documentData['PermitDocument']['document_id'];
                    $data['file'] = $uploadResponse;
                    $data['security_type_id'] = $documentData['PermitDocument']['security_type_id'];
                    $result = $this->UserPermitDocuments->saveData($permitId, $userPermitId, $data);
                    if ($result) {
                        $this->_updatedBy('UserPermits', $userPermitId);
                        /* === Added by vipin for  add log=== */
                        $message = 'Permit Document uploaded by ' . $this->loggedusername;
                        $saveActivityLog = [];
                        $saveActivityLog['table_id'] = $result['id'];
                        $saveActivityLog['table_name'] = 'user_permit_documents';
                        $saveActivityLog['module_name'] = 'Permit Document Upload';
                        $saveActivityLog['url'] = $this->referer();
                        $saveActivityLog['message'] = $message;
                        $saveActivityLog['activity'] = 'Upload';
                        $this->Custom->saveActivityLog($saveActivityLog);
                        /* === Added by vipin for  add log=== */
                        $response['msg'] = 'Docment added successfully';
                        $response['flag'] = TRUE;
                    } else {
                        $response['msg'] = 'Something went wrong Please try again';
                    }
                } else {
                    $response['msg'] = 'Something went wrong Please try again';
                }
            } else {
                $response['msg'] = 'Please upload pdf,xls,doc file only';
            }
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $permitId
     */
    public function getRelatedDocument($permitId, $userPermitId) {
        $this->autoRender = false;

        $this->loadModel('SecurityTypes');
        $securityTypes = $this->SecurityTypes->getList();
        $this->set(compact('securityTypes'));

        $this->loadModel('PermitDocuments');
        $permitDocuments = $this->PermitDocuments->find('all')->contain([
                    'UserPermitDocuments' => function($q) use( $userPermitId ) {
                        return $q
                                        ->where(['UserPermitDocuments.is_deleted' => 0, 'UserPermitDocuments.user_permit_id' => $userPermitId])
                                        ->select(['id', 'permit_document_id', 'file', 'security_type_id', 'modified']);
                    },
                    'Documents' => function($q) {
                        return $q
                                        ->select(['id', 'name', 'slug']);
                    },
                ])->where(['PermitDocuments.permit_id' => $permitId, 'PermitDocuments.is_deleted' => 0])->toArray();
        $this->set(compact('permitDocuments', 'permitId', 'userPermitId'));
        echo $this->render('/Element/frontend/permit/document_list');
        exit;
    }

    public function saveRelatedDeadline($permitId, $userPermitId) {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Deadlines');
            $this->request->data['Deadlines']['user_permit_id'] = $userPermitId;
            $response = $this->Deadlines->saveData($this->request->data['Deadlines'], $permitId);
            if (!empty($response['id']) && !empty($this->request->data['Deadlines']['deadline_type_id'])) {
                $this->_updatedBy('UserPermits', $userPermitId);
                $message = 'Deadline added by ' . $this->loggedusername;
                $activity = 'Add';
                $this->loadModel('UserPermitDeadlines');
                if (!empty($this->request->data['Deadlines']['id'])) {
                    $this->UserPermitDeadlines->updateAll(['is_deleted' => 1], ['deadline_id' => $this->request->data['Deadlines']['id']]);
                    $message = 'Deadline updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                }
                /* === Added by vipin for  add log=== */
                $message = 'Deadline updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'deadlines';
                $saveActivityLog['module_name'] = 'Deadline Front';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = $activity;
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $userPermitDeadline = [];
                $userPermitDeadline['user_id'] = Configure::read('LoggedCompanyId');
                $userPermitDeadline['added_by'] = Configure::read('LoggedUserId');
                $userPermitDeadline['permit_id'] = $permitId;
                $userPermitDeadline['deadline_id'] = $response['id'];
                $userPermitDeadline['user_permit_id'] = $userPermitId;
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
                $responce['msg'] = $responce['msg'];
            }
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    public function getRelatedDeadline($permitId, $userPermitId, $operationId = null, $locationId = null) {
        $this->autoRender = false;
        $this->loadModel('Deadlines');
        $userPermitDeadlines = $this->Deadlines->getCompanyDataByPermitId($permitId, $userPermitId);
        $redirectHere = 'permits/details/' . $permitId . '/' . $operationId . '/' . $locationId;
        $this->set(compact('userPermitDeadlines', 'redirectHere'));
        echo $this->render('/Element/frontend/permit/deadline_list');
        exit;
    }

    /* =======--------New Download Function start from here By Vipin----------================== */




    /*
     * Function: downloadFullDocument()
     * Description: downloadFullDocument related of permit document 
     * By @Vipin chauhan
     * Date : 12th Feb. 2018
     */

    public function downloadFullForm() {
        if ($this->request->query('permit_id') && $this->request->query('userPermitId') && $this->request->query('permitFormId')) {
            $userPermitId = $this->request->query('userPermitId');
            $permitFormId = $this->request->query('permitFormId');
            $permitId = $this->request->query('permit_id');
            $this->loadModel('PermitForms');

            $permitForms = $this->PermitForms->find('all')->contain(['PermitFormSamples',
                        'UserPermitForms' => function($q) use( $userPermitId ) {
                            return $q
                                            ->where(['UserPermitForms.is_deleted' => 0, 'UserPermitForms.user_permit_id' => $userPermitId]);
                            //->select(['id','permit_form_id','file','security_type_id']);
                        },
                    ])->where(['PermitForms.id' => $permitFormId])->first();
            if (count($permitForms) > 0) {
                //prx($permitForms);
                $response = $this->processData($permitForms);
                //prx($response);
                $zip = $this->createFolder($response);
                $download = $this->createZipAndDownload($zip);
            }
        } else {
            echo "Target file not found !";
            die;
        }
    }

    public function createZipAndDownload($path) {
        try {
            ini_set('max_execution_time', 600);
            ini_set('memory_limit', '1024M');
            if (file_exists($path->path)) {
                $zip = new \ZipArchive();
                $destination = $path->path . '.zip';
                $destination = $path->folderName . '.zip';
                $source = $path->path;
                if ($zip->open($destination, \ZIPARCHIVE::CREATE)) {
                    $source = realpath($source);
                    if (is_dir($source)) {
                        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::SELF_FIRST);
                        foreach ($files as $file) {
                            $file = realpath($file);
                            if (is_dir($file)) {
                                $zip->addEmptyDir(str_replace($source . '/', '', $file . '/'));
                            } else if (is_file($file)) {
                                $zip->addFromString(str_replace($source . '/', '', $file), file_get_contents($file));
                            }
                        }
                    } else if (is_file($source)) {
                        $zip->addFromString(basename($source), file_get_contents($source));
                    }
                }
                $zip->close();
            }
            if (file_exists($destination)) {
                header('Content-Type: application/zip');
                header('Content-disposition: attachment; filename=' . $destination);
                header('Content-Length: ' . filesize($destination));
                readfile($destination);
                unlink("$destination");
                unlink("$destination1");
                unlink("$path->time");
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function createFolder($data) {
        if (isset($data['form']) && !empty($data['form'])) {
            $path = new Folder(WWW_ROOT . 'files/Download/' . time() . DS . $data['form']['fileName'], true, 0777);
            $path->time = time();
            $path->folderName = $data['form']['fileName'];
            copy($data['form']['fileToBeDownload'], $path->path . '/' . $data['form']['fileName'] . '.' . $data['form']['fileExtension']);
        }

        if (isset($data['filledDocument']) && !empty($data['filledDocument'])) {
            $path1 = new Folder($path->path . DS . 'filled', true, 0777);
            copy($data['filledDocument']['fileToBeDownload'], $path1->path . '/' . $data['filledDocument']['fileName'] . '.' . $data['filledDocument']['fileExtension']);
        }

        if (isset($data['samples']) && count($data['samples'])) {
            foreach ($data['samples'] as $key => $value) {
                $path11 = new Folder($path->path . DS . 'samples', true, 0777);
                copy($value['fileToBeDownload'], $path11->path . '/' . $value['fileName'] . '.' . $value['fileExtension']);
            }
        }
        return $path;
    }

    public function processData($data) {
        $response = [];
        if (isset($data['path']) && !empty($data['path'])) {
            $form = [];
            $path = WWW_ROOT . $data['path'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            if (isset($ext) && !empty($ext)) {
                $form['fileExtension'] = $ext;
                $form['fileName'] = $data['name'];
                $form['fileToBeDownload'] = $path;
                $response['form'] = $form;
            }
        }


        if (isset($data->user_permit_form->file) && !empty($data->user_permit_form->file)) {
            if ($this->Custom->checkSecurity($data->user_permit_form->security_type_id)) {
                $user_filled_form = [];
                $path = WWW_ROOT . $data->user_permit_form->file;
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (isset($ext) && !empty($ext)) {
                    $user_filled_form['fileExtension'] = $ext;
                    $user_filled_form['fileName'] = 'filled';
                    $user_filled_form['fileToBeDownload'] = $path;
                    $response['filledDocument'] = $user_filled_form;
                }
            }
        }




        $permit_form_samples = [];
        $j = 1;
        foreach ($data->permit_form_samples as $key => $value) {

            if (isset($value['path']) && !empty($value['path'])) {
                $permit_form_sample = [];
                $path = WWW_ROOT . $value['path'];
                $ext = pathinfo($path, PATHINFO_EXTENSION);
                if (isset($ext) && !empty($ext)) {
                    $permit_form_sample['fileExtension'] = $ext;
                    $permit_form_sample['fileName'] = 'samples' . $j;
                    $permit_form_sample['fileToBeDownload'] = $path;
                    $permit_form_samples[] = $permit_form_sample;
                }
            }
            $j++;
        }
        $response['samples'] = $permit_form_samples;

        return $response;
    }

    /* =================================New Download end here================================= */




    /* ============Old Actions============================ */

    /*
     * Function: uloadPermit()
     * Description: use for upload permit permit 
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function uploadPermitDocument() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitDocuments');
            $pathDocument = 'files/permit/documents';
            $permitFiles = $this->Upload->uploadOtherFile($this->request->data['form_documet'], $pathDocument);
            $permitData['path'] = $permitFiles;
            $permitData['is_privacy'] = $this->request->data['is_privacy'];
            $permitData['notes'] = $this->request->data['notes'];
            $permitData['form_id'] = $this->request->data['form_id'];
            $permitData['form_documents_id'] = $this->request->data['form_documents_id'];
            $permitData['is_complated'] = 1;
            $permitData['user_id'] = $this->userId;
            if (!empty($this->request->data['permit_documents_id'])) {
                $permits = $this->PermitDocuments->get($this->request->data['permit_documents_id']);
            } else {
                $permits = $this->PermitDocuments->newEntity();
            }
            $permitss = $this->PermitDocuments->patchEntity($permits, $permitData, ['validate' => 'UploadPermit']);
            if (!$permitss->errors()) {
                if ($success = $this->PermitDocuments->save($permits)) {
                    $path = BASE_URL . '/webroot/' . $success->path;
                    $result['status'] = 'Filled';
                    $result['updated'] = date('d-m-Y', strtotime($success->modified));
                    $responce['flag'] = true;
                    $responce['data'] = $result;
                    $responce['id'] = $success->id;
                    $responce['path'] = $path;
                    $responce['msg'] = 'Permit has been uploaded successfully';
                } else {
                    $responce['msg'] = 'Permit could not uploaded';
                }
            } else {
                $responce['msg'] = $this->Custom->multipleFlash($categories->errors());
            }
        } else {
            $responce['msg'] = 'Permit could not post';
        }
        echo json_encode($responce);
        exit;
    }

    /*
     * Function: uloadPermit()
     * Description: use for upload permit permit 
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function uploadPermitAttachment() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {

            $this->loadModel('PermitAttachments');
            $pathDocument = 'files/permit/attachment';
            if ($this->request->data['form_attechment']) {
                $permitFiles = $this->Upload->uploadOtherFile($this->request->data['form_attechment'], $pathDocument);
                $permitData['path'] = $permitFiles;
            }
            $permitData['notes'] = $this->request->data['notes'];
            $permitData['is_privacy'] = $this->request->data['is_privacy'];
            $permitData['form_id'] = $this->request->data['form_id'];
            $permitData['form_documents_id'] = $this->request->data['form_documents_id'];
            $permitData['form_attachment_id'] = $this->request->data['form_attachment_id'];

            $permitData['is_privacy'] = $this->request->data['is_privacy'];
            $permitData['is_complated'] = 1;
            $permitData['user_id'] = $this->userId;

            if ($this->request->data['permit_attachment_id']) {
                $permits = $this->PermitAttachments->get($this->request->data['permit_attachment_id']);
            } else {
                $permits = $this->PermitAttachments->newEntity();
            }
            $permitss = $this->PermitAttachments->patchEntity($permits, $permitData, ['validate' => 'UploadPermitAttachment']);
            if (!$permitss->errors()) {
                if ($success = $this->PermitAttachments->save($permits)) {
                    $result['status'] = 'Filled';
                    $result['updated'] = date('d-m-Y', strtotime($success->modified));
                    $responce['flag'] = true;
                    $responce['data'] = $result;
                    $responce['id'] = $success->id;

                    $responce['msg'] = 'Permit attach document has been uploaded successfully';
                } else {
                    $responce['msg'] = 'Permit attach document could not uploaded';
                }
            } else {
                $responce['msg'] = $this->Custom->multipleFlash($categories->errors());
            }
        } else {
            $responce['msg'] = 'Permit attach document could not post';
        }
        echo json_encode($responce);
        exit;
    }

    /* public function createZip($id) {

      $zip = new ZipArchive();
      $zip_name = time() . ".zip"; // Zip name
      $zip->open($zip_name, ZipArchive::CREATE);
      foreach ($files as $file) {
      echo $path = "uploadpdf/" . $file;
      if (file_exists($path)) {
      $zip->addFromString(basename($path), file_get_contents($path));
      } else {
      echo"file does not exist";
      }
      }
      $zip->close();
      }
     */
    /*
     * Function: downloadPermitDocuments()
     * Description: use for download all permit document in zip folder.
     * @param type $documentId
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function downloadPermitDocuments($documentId = null) {
        $this->autoRender = false;
        $this->loadModel('Documents');
        $this->loadModel('FormDocumentSamples');
        $formDocument = $this->Documents->find()->where(['Documents.id' => $documentId])->first();
        $formDocumentSamples = $this->FormDocumentSamples->find()->where(['FormDocumentSamples.form_document_id' => $formDocument->id])->all();
        if (!empty($formDocument)) {
            $proInfo = $formDocument->path;
            $formName = Inflector::slug($formDocument->name, '_');
            $zipName = WWW_ROOT . $proInfo . '_permit.zip';
            /* this code for zip file name */
            $downloadname = $formName . '_permit.zip';
            $zipContent = new \ZipArchive;
            $zipContent->open($zipName, \ZipArchive::CREATE);

            /* PATHINFO_EXTENSION this code for file EXTENSION */
            $ext = pathinfo($formDocument->path, PATHINFO_EXTENSION);
            $path = WWW_ROOT . $formDocument->path;
            if (is_file($path)) {
                /* this code for add file in zip folder */
                if (file_exists($path)) {
                    $zipContent->addFromString(basename($formName . '.' . $ext), file_get_contents($path));
                }
            }
            if (!empty($formDocumentSamples)) {
                $number = 1;
                foreach ($formDocumentSamples as $formDocumentSample) {
                    $pathAttachment = WWW_ROOT . $formDocumentSample->path;
                    $ext = pathinfo($formDocumentSample->path, PATHINFO_EXTENSION);
                    if (file_exists($pathAttachment)) {
                        $zipContent->addFromString(basename($formName . '-sample-' . $number . '.' . $ext), file_get_contents($pathAttachment));
                    }
                    $number++;
                }
            }

            $zipContent->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $downloadname);
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);
            unlink($zipName);
        } else {
            $this->Flash->error("Image not found");
            $this->redirect($this->referer());
        }
    }

    /*
     * Function: downloadPermitAttachment
     * Description: use for download all permit attech file in zip folder.
     * @param type $formAttachmentId
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function downloadPermitAttachment($formAttachmentId = null) {
        $this->autoRender = false;
        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $formAttachments = $this->FormAttachments->find()->where(['FormAttachments.id' => $formAttachmentId])->first();

        $formAttachmentSamples = $this->FormAttachmentSamples->find()->where(['FormAttachmentSamples.form_attachment_id' => $formAttachments->id])->all();

        if (!empty($formAttachments)) {
            $proInfo = $formAttachments->name;
            $formName = Inflector::slug($formAttachments->name, '_');
            $zipName = WWW_ROOT . $proInfo . '_permit.zip';
            /* this code for zip file name */
            $downloadname = $formName . '_permit.zip';
            $zipContent = new \ZipArchive;
            $zipContent->open($zipName, \ZipArchive::CREATE);

            if (!empty($formAttachmentSamples)) {

                $number = 1;
                foreach ($formAttachmentSamples as $formAttachmentSample) {
                    $pathAttachment = WWW_ROOT . $formAttachmentSample->path;
                    $ext = pathinfo($formAttachmentSample->path, PATHINFO_EXTENSION);
                    if (file_exists($pathAttachment)) {
                        $zipContent->addFromString(basename($formName . '-attachment-' . $number . '.' . $ext), file_get_contents($pathAttachment));
                    }
                    $number++;
                }
            }

            $zipContent->close();
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $downloadname);
            header('Content-Length: ' . filesize($zipName));
            readfile($zipName);
            unlink($zipName);
        } else {
            $this->Flash->error("Image not found");
            $this->redirect($this->referer());
        }
    }

    /*
     * Function: addAlerts()
     * Description: use for add alerts of the permit 
     * By @Ahsan Ahamads
     * Date : 13th Dec. 2017
     */

    public function addAlerts() {
        if ($this->request->is('post')) {
            $this->loadModel('AlertPermitAttachments');
            $this->loadModel('AlertPermitDocuments');
            $this->loadModel('AlertPermits');
            $this->loadModel('Alerts');
            $formId = $this->request->data['form_id'];
            $alertTypleId = $this->request->data['alert_type_id'];
            $alerts['title'] = ucfirst($this->request->data['title']);
            $alerts['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $alerts['user_id'] = $this->userId;
            $alerts['alert_type_id'] = $this->request->data['alert_type_id'];
            $alerts['notes'] = $this->request->data['notes'];
            $alerts['time'] = $this->request->data['time'];
            if (isset($this->request->data['is_repeated'])) {
                $alerts['is_repeated'] = $this->request->data['is_repeated'];
                $alerts['interval_type'] = $this->request->data['interval_type'];
                if (!empty($this->request->data['interval'])) {
                    $alerts['interval'] = (int) $this->request->data['interval'];
                }
            }
            $alerts['form_id'] = $this->request->data['form_id'];

            $alert = $this->Alerts->newEntity();
            $this->Alerts->patchEntity($alert, $alerts, ['validate' => 'Add']);
            if (!$alert->errors()) {
                if ($success = $this->Alerts->save($alert)) {
                    $permit['user_id'] = $this->userId;
                    $permit['alert_id'] = $success->id;
                    $permit['form_id'] = $formId;
                    $permit['alert_type_id'] = $this->request->data['alert_type_id'];
                    $permit['created'] = date('Y-m-d');

                    if ($this->request->data['alert_for'] == 'document') {
                        $permit['form_document_id'] = $this->request->data['form_document_id'];
                        $alertPermitDocuments = $this->AlertPermitDocuments->newEntity();
                        $this->AlertPermitDocuments->patchEntity($alertPermitDocuments, $permit);
                        $this->AlertPermitDocuments->save($alertPermitDocuments);
                    }
                    if ($this->request->data['alert_for'] == 'permit') {
                        $permits = $this->AlertPermits->newEntity();
                        $this->AlertPermits->patchEntity($permits, $permit);
                        $successAlert = $this->AlertPermits->save($permits);
                    }
                    if ($this->request->data['alert_for'] == 'attachment') {
                        $permit['form_attachment_id'] = $this->request->data['form_attachment_id'];
                        $alertPermitAttachments = $this->AlertPermitAttachments->newEntity();
                        $this->AlertPermitAttachments->patchEntity($alertPermitAttachments, $permit);
                        $this->AlertPermitAttachments->save($alertPermitAttachments);
                    }
                    $this->Flash->success(__('Alerts has been updated successfully.'));
                } else {
                    $this->Flash->error(__('Alerts could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($alert->errors())));
            }
            return $this->redirect($this->referer());
        }
    }

    public function downloadAllFiles($permitId = null, $userPermitID = null) {
        $permitId = $this->Encryption->decode($permitId);
        $userPermitID = $this->Encryption->decode($userPermitID);
        $permitDetails = $this->Permits->permitDetails($permitId, $userPermitID, 1);
        //prx($permitDetails);
        $response = [];
        if (isset($permitDetails['name']) && !empty($permitDetails['name'])) {
            $response['Permit'] = str_replace('/', '-', $permitDetails['name']);
        }
        //FORM
        if (isset($permitDetails['permit_forms']) && !empty($permitDetails['permit_forms'])) {
            $forms = [];
            foreach ($permitDetails['permit_forms'] as $key => $pForm) {
                $form = [];
                if (!empty($pForm['path'])) {
                    $path = WWW_ROOT . $pForm['path'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if (isset($ext) && !empty($ext)) {
                        $form['fileExtension'] = $ext;
                        $form['fileName'] = str_replace('/', '-', $pForm['name']);
                        $form['fileToBeDownload'] = $path;
                        $forms[$key] = $form;
                    }
                }
                if (isset($pForm['user_permit_form']['file']) && !empty($pForm['user_permit_form']['file'])) {
                    if ($this->Custom->checkSecurity($pForm['user_permit_form']['security_type_id'])) {
                        $user_filled_form = [];
                        $path = WWW_ROOT . $pForm['user_permit_form']['file'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (isset($ext) && !empty($ext)) {
                            $user_filled_form['fileExtension'] = $ext;
                            $user_filled_form['fileName'] = 'filled';
                            $user_filled_form['fileToBeDownload'] = $path;
                            $forms[$key]['filledDocument'] = $user_filled_form;
                        }
                    }
                }
                $j = 1;
                foreach ($pForm['permit_form_samples'] as $key1 => $value) {
                    if (isset($value['path']) && !empty($value['path'])) {
                        $permit_form_sample = [];
                        $path = WWW_ROOT . $value['path'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (isset($ext) && !empty($ext)) {
                            $permit_form_sample['fileExtension'] = $ext;
                            $permit_form_sample['fileName'] = 'samples' . $j;
                            $permit_form_sample['fileToBeDownload'] = $path;
                            $forms[$key]['sample'][$key1] = $permit_form_sample;
                        }
                    }
                    $j++;
                }
            }
            $response['form'] = $forms;
        }
        //Documents
        if (isset($permitDetails['permit_documents']) && !empty($permitDetails['permit_documents'])) {
            foreach ($permitDetails['permit_documents'] as $key2 => $value) {
                if (isset($value['user_permit_document']['file']) && !empty($value['user_permit_document']['file'])) {
                    if ($this->Custom->checkSecurity($value['user_permit_document']['security_type_id'])) {
                        $permit_document = [];
                        $path = WWW_ROOT . $value['user_permit_document']['file'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (isset($ext) && !empty($ext)) {
                            $permit_document['fileExtension'] = $ext;
                            $permit_document['fileName'] = str_replace('/', '-', $value['document']['name']);
                            $permit_document['fileToBeDownload'] = $path;
                            $response['Documents'][$key2] = $permit_document;
                        }
                    }
                }
            }
        }
        //Instructions
        if (isset($permitDetails['permit_instructions']) && !empty($permitDetails['permit_instructions'])) {
            foreach ($permitDetails['permit_instructions'] as $key3 => $value) {
                if (isset($value['path']) && !empty($value['path'])) {
                    $permit_instructions = [];
                    $path = WWW_ROOT . $value['path'];
                    $ext = pathinfo($path, PATHINFO_EXTENSION);
                    if (isset($ext) && !empty($ext)) {
                        $permit_instructions['fileExtension'] = $ext;
                        $permit_instructions['fileName'] = str_replace('/', '-', $value['name']);
                        $permit_instructions['fileToBeDownload'] = $path;
                        $response['Instructions'][$key3] = $permit_instructions;
                    }
                }
            }
        }
        //prx($response);
        try {
            if (!empty($response)) {
                $path = new Folder(WWW_ROOT . 'files/Download/' . time() . DS . $response['Permit'], true, 0777);
                $path->time = time();
                $path->folderName = $response['Permit'];
                if (isset($response['form']) && !empty($response['form'])) {
                    $path1 = new Folder($path->path . DS . 'Forms', true, 0777);
                    foreach ($response['form'] as $fData) {
                        $path1fo = new Folder($path1->path . DS . $fData['fileName'], true, 0777);
                        copy($fData['fileToBeDownload'], $path1fo->path . '/' . $fData['fileName'] . '.' . $fData['fileExtension']);
                        if (isset($fData['filledDocument']) && !empty($fData['filledDocument'])) {
                            $path1f = new Folder($path1fo->path . DS . 'filled', true, 0777);
                            copy($fData['filledDocument']['fileToBeDownload'], $path1f->path . '/' . $fData['filledDocument']['fileName'] . '.' . $fData['filledDocument']['fileExtension']);
                        }
                        if (isset($fData['sample']) && count($fData['sample'])) {
                            $path1s = new Folder($path1fo->path . DS . 'sample', true, 0777);
                            foreach ($fData['sample'] as $key => $value) {
                                copy($fData['fileToBeDownload'], $path1s->path . '/' . $value['fileName'] . '.' . $value['fileExtension']);
                            }
                        }
                    }
                }

                if (isset($response['Documents']) && !empty($response['Documents'])) {
                    $path1d = new Folder($path->path . DS . 'Documents', true, 0777);
                    foreach ($response['Documents'] as $dData) {
                        copy($dData['fileToBeDownload'], $path1d->path . '/' . $dData['fileName'] . '.' . $dData['fileExtension']);
                    }
                }

                if (isset($response['Instructions']) && !empty($response['Instructions'])) {
                    $path1i = new Folder($path->path . DS . 'Instructions', true, 0777);
                    foreach ($response['Instructions'] as $iData) {
                        copy($iData['fileToBeDownload'], $path1i->path . '/' . $iData['fileName'] . '.' . $iData['fileExtension']);
                    }
                }
                if (!empty($path)) {
                    $this->createZipAndDownload($path);
                }
            }
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getOperationList() {
        if ($this->request->is('post')) {
            $location_id = null;
            if (!empty($location_id)) {
                $location_id = $this->request->data['location_id'];
            }
            $this->loadModel('LocationOperations');
            $userLocationList = $this->LocationOperations->getAllOperationIdByLocationIdAndUserId($this->request->data['location_id']);
            $this->loadModel('Operations');
            $userOperationList = $this->Operations->getOperationListById($userLocationList);
            $listHtml = '<option value="">Select Operation</option>';
            if (!empty($userOperationList)) {

                foreach ($userOperationList as $key => $value) {
                    $listHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
                }
            }
            echo $listHtml;
            exit;
        }
    }

    /* Function:changeUserPermitStatus()
     * Description: function use for change the status of permit 
     * @param type $id   
     * By @Vipin chauhan
     * Date : 5 Feb. 2018   
     */

    public function changeUserPermitStatus() {
        $response = [];
        if ($this->request->is('post') && !empty($this->request->data)) {
            $data = $this->request->data();
            $data['UserPermitLogs']['user_id'] = Configure::read('LoggedUserId');
            $data['UserPermitLogs']['company_id'] = Configure::read('LoggedCompanyId');
            $this->loadModel('UserPermits');
            $res = $this->UserPermits->saveData($data['UserPermitLogs']);
            if ($res->id) {
                $this->_updatedBy('UserPermits', $res->id);
                $this->loadModel('UserPermitLogs');
                $userPermitLog = $this->UserPermitLogs->newEntity();
                $userPermitLog['user_id'] = $data['UserPermitLogs']['company_id'];
                $userPermitLog['added_by'] = Configure::read('LoggedUserId');
                $userPermitLog['user_permit_id'] = $res->id;
                $userPermitLog['permit_status_id'] = $data['UserPermitLogs']['status_id'];
                $userPermitLog['notes'] = $data['UserPermitLogs']['notes'];
                $userPermitLog['created'] = date('Y-m-d H:i:s');
                $this->UserPermitLogs->save($userPermitLog);
                if (!empty($data['UserPermitLogs']['permit_id'])) {
                    $deadline = [];
                    $deadline['deadline_type_id'] = 0;
                    $deadline['user_permit_id'] = $res->id;
                    $deadline['date'] = $data['UserPermitLogs']['renewable_date'];
                    $deadline['time'] = "00:00";
                    $deadline['is_renewable'] = 1;
                    $this->loadModel('Deadlines');
                    $this->Deadlines->saveData($deadline, $data['UserPermitLogs']['permit_id']);
                }
                /* === Added by vipin for  add log=== */
                $message = 'Permit updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $res->id;
                $saveActivityLog['table_name'] = 'user_permits';
                $saveActivityLog['module_name'] = 'Current Permit Front';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $response['statusCode'] = 200;
            } else {
                $response['statucCode'] = 202;
                $response['messageText'] = "Something went wrong! PLease try again";
            }
        } else {
            $response['statusCode'] = 202;
            $response['messageText'] = "Something went wrong! PLease try again";
        }
        echo json_encode($response);
        die;
    }

    public function taskHistory($permitId = null, $operationId = null, $locationId = null) {
        $pageTitle = 'Permit | Task History';
        $pageHedding = 'View ';
        $this->set(compact('permitId', 'operationId', 'locationId'));
        $breadcrumb = array(
            array('label' => 'Permit', 'link' => 'permits/current'),
            array('label' => 'Task History'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $permitId = $this->Encryption->decode($permitId);
        $operationId = $this->Encryption->decode($operationId);
        $locationId = $this->Encryption->decode($locationId);
        $this->loadModel('UserPermits');
        $this->loadModel('Documents');
        $this->loadModel('Permits');
        $this->loadModel('PermitAgencies');

        $accessPermits = $this->UserPermits->find()->where(['UserPermits.user_id' => $this->userId, 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId])->first();

        if (empty($accessPermits)) {
            /* ---save data in UserPermit model-------------- */
            $data['company_id'] = Configure::read('LoggedCompanyId');
            $data['user_id'] = $this->Auth->user('id');
            $data['permit_id'] = $permitId;
            $data['operation_id'] = $operationId;
            $data['user_location_id'] = $locationId;
            $data['status_id'] = 2;
            $this->loadModel('UserPermits');
            $result = $this->UserPermits->saveData($data);
            $accessPermits = $this->UserPermits->find()->where(['UserPermits.user_id' => $this->userId, 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId])->first();
        }
        $permitDetails = $this->Permits->permitDetails($accessPermits->permit_id, $accessPermits->id, 1);
        $this->loadModel('UsersPermitLogs');
        $userPermitStatusLogList = $this->UsersPermitLogs->getUserPermitLog($accessPermits->id);
        $this->loadModel('Deadlines');
        $userPermitDeadlines = $this->Deadlines->getCompanyDataByPermitId($accessPermits->permit_id, $accessPermits->id);
        $this->set(compact('accessPermits', 'permitDetails', 'userPermitStatusLogList', 'userPermitDeadlines'));
    }

}
