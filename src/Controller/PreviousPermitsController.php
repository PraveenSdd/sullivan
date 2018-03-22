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

class PreviousPermitsController extends AppController {
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

    public function view($permitId = null, $operationId = null, $locationId = null) {
        $redirectHere = 'previousPermits/view/' . $permitId . '/' . $operationId . '/' . $locationId;
        $pageTitle = 'Previous Permit | View';
        $pageHedding = 'View ';
        $this->set(compact('permitId', 'operationId', 'locationId'));
        $breadcrumb = array(
            array('label' => 'Permit', 'link' => 'permits/current'),
            array('label' => 'Previous Permit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $permitId = $this->Encryption->decode($permitId);
        $operationId = $this->Encryption->decode($operationId);
        $locationId = $this->Encryption->decode($locationId);
        $this->loadModel('UserPermits');
        $this->loadModel('Documents');
        $this->loadModel('Permits');
        $this->loadModel('PermitAgencies');

        $accessPermits = $this->UserPermits->find()->where(['UserPermits.user_id' => $this->userId, 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId, 'UserPermits.is_previous' => 1, 'UserPermits.permit_status_id' => 0])->first();
        if (empty($accessPermits)) {
            /* ---save data in UserPermit model-------------- */
            $data['company_id'] = Configure::read('LoggedCompanyId');
            $data['user_id'] = $this->Auth->user('id');
            $data['permit_id'] = $permitId;
            $data['operation_id'] = $operationId;
            $data['user_location_id'] = $locationId;
            $data['status_id'] = 0;
            $data['is_previous'] = 1;
            $this->loadModel('UserPermits');
            $result = $this->UserPermits->saveData($data, 1);
            $accessPermits = $this->UserPermits->find()->where(['UserPermits.user_id' => $this->userId, 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId, 'UserPermits.is_previous' => 1, 'UserPermits.permit_status_id' => 0])->first();
        }
        $permitDetails = $this->Permits->permitDetails($accessPermits->permit_id, $accessPermits->id, 0);
        $this->loadModel('SecurityTypes');
        $securityTypes = $this->SecurityTypes->getList();
        $this->loadModel('UserPreviousPermitDocuments');
        $loggedCompanyId = Configure::read('LoggedCompanyId');
        $data = $this->UserPreviousPermitDocuments->find()->where(['UserPreviousPermitDocuments.user_permit_id' => $accessPermits->id, 'UserPreviousPermitDocuments.user_id' => $loggedCompanyId, 'UserPreviousPermitDocuments.is_active' => 1, 'is_deleted' => 0])->all();

        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getCompanyAlertType();
        $this->set(compact('alertTypeList'));

        $this->loadModel('Users');
        $companyStaffList = $this->Users->getStaffList(Configure::read('LoggedCompanyId'));
        $this->set(compact('companyStaffList'));

        $this->loadModel('Deadlines');
        $userPermitDeadlines = $this->Deadlines->getCompanyDataByPermitId($accessPermits->permit_id, $accessPermits->id);
        $this->set(compact('accessPermits', 'permitDetails', 'securityTypes', 'data', 'redirectHere', 'userPermitDeadlines'));
    }

    public function validateFormName($name) {
        /* this is function is for that user can not inser <script> tag here */
        foreach ($name as $key => $value) {
            if (!preg_match('/^[a-zA-Z]+[a-zA-Z0-9._ ]+$/', $value['name'])) {
                return false;
            }
        }
        return true;
    }

    public function savePreviousPermitDocument($permitId, $operationId, $locationId, $userPermitId) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $receivingName = $this->request->data['UserPreviousPermitDocument'];
            $validateResult = $this->validateFormName($receivingName);
            if ($validateResult) {
                $this->loadModel('UserPreviousPermitDocuments');
                $this->loadModel('UserPermit');
                $errorFile = [];
                if (!empty($this->request->data['UserPreviousPermitDocument'])) {
                    $docPath = 'files/user_permits/previous';
                    $permitDocData = [];
                    if (!empty($userPermitId)) {
                        $userPermit = $this->UserPermits->get($userPermitId);
                        $this->UserPermits->patchEntity($userPermit, $permitDocData);
                        $userPermit = $this->UserPermits->save($userPermit);
                        $message = 'Previous Permit updated by ' . $this->loggedusername;
                        $activity = 'Edit';
                    } else {
                        $permitDocData['user_id'] = Configure::read('LoggedCompanyId');
                        $permitDocData['permit_id'] = $permitId;
                        $permitDocData['operation_id'] = $operationId;
                        $permitDocData['user_location_id'] = $locationId;
                        $permitDocData['permit_status_id'] = 0;
                        $permitDocData['is_previous'] = 1;
                        $permitDocData['created'] = date('y-m-d H:i:s');
                        $permitDocData['added_by'] = Configure::read('LoggedUserId');
                        $userPermit = $this->UserPermits->newEntity();
                        $this->UserPermits->patchEntity($userPermit, $permitDocData);
                        $userPermit = $this->UserPermits->save($userPermit);
                        $message = 'Previous Permit added by ' . $this->loggedusername;
                        $activity = 'Add';
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
                    if (!empty($userPermit->id)) {
                        $this->_updatedBy('UserPermits', $userPermit->id);
                        foreach ($this->request->data['UserPreviousPermitDocument'] as $key => $userPreviousPermitDoc) {
                            if ($userPreviousPermitDoc['name']) {
                                $uploadResponse = false;
                                $previousPermit = [];
                                if (!empty($userPreviousPermitDoc['file']['tmp_name'])) {
                                    $uploadResponse = $this->Upload->uploadOtherFile($userPreviousPermitDoc['file'], $docPath);
                                    if ($uploadResponse) {
                                        $previousPermit['file'] = $uploadResponse;
                                    } else {
                                        $errorFile[] = $userPreviousPermitDoc['name'];
                                    }
                                }
                                if (empty($errorFile)) {
                                    if (!empty($userPreviousPermitDoc['id'])) {
                                        $previousPermit['id'] = $userPreviousPermitDoc['id'];
                                    }
                                    $previousPermit['user_id'] = Configure::read('LoggedCompanyId');
                                    $previousPermit['user_permit_id'] = $userPermit->id;
                                    $previousPermit['permit_id'] = $permitId;
                                    $previousPermit['name'] = $userPreviousPermitDoc['name'];

                                    $previousPermit['expiry_date'] = (!empty($userPreviousPermitDoc['expiry_date'])) ? $userPreviousPermitDoc['expiry_date'] : '';
                                    $previousPermit['security_type_id'] = $userPreviousPermitDoc['security_type_id'];
                                    $previousPermit['created'] = date('y-m-d H:i:s');
                                    $previousPermit['added_by'] = Configure::read('LoggedUserId');
                                    $previousPermits = $this->UserPreviousPermitDocuments->newEntity($previousPermit);
                                    $this->UserPreviousPermitDocuments->patchEntity($previousPermits, $previousPermit);
                                    $this->UserPreviousPermitDocuments->save($previousPermits);
                                }
                            }
                        }
                    }
                    if ($errorFile) {
                        $response['msg'] = $this->Custom->multipleFlash($errorFile);
                    } else {
                        $response['flag'] = true;
                        $response['msg'] = 'Previous permit saved successfully';
                    }
                } else {
                    $response['msg'] = 'Please upload document.';
                }
            } else {
                $response['msg'] = 'Document name can only Alphanumeric.';
            }
        } else {
            $response['msg'] = 'Invalid request.';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $permitId
     */
    public function getUserPreviousPermitList($permitId = null, $operationId = null, $locationId = null, $userPermitId = null) {
        $this->autoRender = false;
        $this->loadModel('UserPreviousPermitDocuments');
        $data = $this->UserPreviousPermitDocuments->find()->where(['UserPreviousPermitDocuments.user_permit_id' => $userPermitId, 'UserPreviousPermitDocuments.is_active' => 1, 'is_deleted' => 0])->all();
        $permitId = $this->Encryption->encode($permitId);
        $operationId = $this->Encryption->encode($operationId);
        $locationId = $this->Encryption->encode($locationId);
        $redirectHere = 'previousPermits/view/' . $permitId . '/' . $operationId . '/' . $locationId;
        $this->set(compact('data', 'redirectHere'));
        echo $this->render('/Element/frontend/previous_permit/previous_perimit_list');
        exit;
    }

    public function index() {
        $pageTitle = 'Previous Permit List | List';
        $pageHedding = 'List ';
        $breadcrumb = array(
            array('label' => 'Previous Permit List'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('UserPermits');
        //$previousPermitData = $this->UserPermits->getUserPreviousPermitList();
        $conditions = ['UserPermits.user_id' => Configure::read('LoggedCompanyId'), 'UserPermits.is_active' => 1, 'UserPermits.is_deleted' => 0, 'UserPermits.is_previous' => 1, 'UserPermits.permit_status_id IN' => [0, 4]];
        $this->paginate = [
            'conditions' => ['AND' => $conditions],
            'contain' => [
                'Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                },
                'Operations' => function($q) {
                    return $q
                                    ->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1])
                                    ->select(['id', 'name']);
                },
                'UserLocations' => function($q) {
                    return $q
                                    ->select(['id', 'title']);
                }
                ,
                'Permits' => function($q) {
                    return $q
                                    ->select(['id', 'name', 'is_admin']);
                }
                ,
                'Renewable' => function($q) {
                    return $q
                                    ->select(['id', 'date']);
                }
            ],
            'order' => ['UserPermits.created' => 'DESC'],
            'limit' => $this->paginationLimit,
        ];
        $previousPermitData = $this->paginate($this->UserPermits);
        $this->set(compact('previousPermitData'));
    }

    public function add() {
        $pageTitle = 'Previous Permit | Add';
        $pageHedding = 'Add Previous Permit';
        $breadcrumb = array(
            array('label' => 'Previous Permit', 'link' => 'previous-permits'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $this->loadModel('Permits');
            $permitData['Permit'] = $this->request->data;
            $permitData['Permit']['is_admin'] = 0;
            $response = $this->Permits->savePermitData($permitData, (!empty($permitData['Permit']['id'])) ? $permitData['Permit']['id'] : null);
            if ($response['flag']) {
                $permitDocData = [];
                $permitDocData['user_id'] = Configure::read('LoggedCompanyId');
                $permitDocData['permit_id'] = $response['permit_id'];
                $permitDocData['operation_id'] = $this->request->data['operation_id'];
                $permitDocData['user_location_id'] = $this->request->data['location_id'];
                $permitDocData['permit_status_id'] = 0;
                $permitDocData['is_previous'] = 1;
                $permitDocData['created'] = date('y-m-d H:i:s');
                $permitDocData['added_by'] = Configure::read('LoggedUserId');
                if (!empty($permitData['Permit']['user_permit_id'])) {
                    $permitDocData['id'] = $this->request->data['user_permit_id'];
                    $userPermit = $this->UserPermits->newEntity($permitDocData);
                } else {
                    $userPermit = $this->UserPermits->newEntity();
                }
                $this->UserPermits->patchEntity($userPermit, $permitDocData);
                $userPermit = $this->UserPermits->save($userPermit);
                $this->_updatedBy('UserPermits', $userPermit->id);
                /* === Added by vipin for  add log=== */
                $message = 'Previous Permit added by ' . $this->loggedusername;
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
                return $this->redirect(['controller' => 'previousPermits', 'action' => 'edit', $this->Encryption->encode($userPermit->id)]);
            } else {
                $this->Flash->error(__((is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg']));
            }
        }
        $loggedCompanyId = Configure::read('LoggedCompanyId');
        $this->loadModel('LocationOperations');
        $operationList = $this->LocationOperations->getOperationListByUserId($loggedCompanyId, null);
        $this->loadModel('UserLocations');
        $userLocationList = $this->UserLocations->getUserLocationListByUserId($loggedCompanyId);
        $this->loadModel('Operations');
        $userOperationList = $this->Operations->getOperationListById($operationList);
        $this->set(compact('userLocationList', 'userOperationList'));
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
        $this->loadModel('Permits');
        $nameStatus = $this->Permits->checkPermitUniqueName($permitName, $permitId);
        echo json_encode($nameStatus);
        exit;
    }

    public function edit($userPermitId = null) {
        $pageTitle = 'Previous Permit | Edit';
        $pageHedding = 'Edit Previous Permit';
        $breadcrumb = array(
            array('label' => 'Previous Permit', 'link' => 'previous-permits'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $userPermitId = $this->Encryption->decode($userPermitId);
        $this->loadModel('UserPermits');
        $previousPermitDetail = $this->UserPermits->find()->hydrate(false)->contain(['Permits'])->where(['UserPermits.id' => $userPermitId])->first();
        $loggedCompanyId = Configure::read('LoggedCompanyId');
        $this->loadModel('LocationOperations');
        $operationList = $this->LocationOperations->getOperationListByUserId($loggedCompanyId, $previousPermitDetail['user_location_id']);
        $this->loadModel('UserLocations');
        $userLocationList = $this->UserLocations->getUserLocationListByUserId($loggedCompanyId);
        $this->loadModel('Operations');
        $userOperationList = $this->Operations->getOperationListById($operationList);
        $this->loadModel('SecurityTypes');
        $securityTypes = $this->SecurityTypes->getList();
        $this->loadModel('UserPreviousPermitDocuments');
        $data = $this->UserPreviousPermitDocuments->find()->where(['UserPreviousPermitDocuments.user_permit_id' => $userPermitId, 'UserPreviousPermitDocuments.user_id' => $loggedCompanyId, 'UserPreviousPermitDocuments.is_active' => 1, 'is_deleted' => 0])->all();
        $permitId = $this->Encryption->encode($previousPermitDetail['permit']['id']);
        $operationId = $this->Encryption->encode($previousPermitDetail['operation_id']);
        $locationId = $this->Encryption->encode($previousPermitDetail['user_location_id']);
        $redirectHere = 'previousPermits/view/' . $permitId . '/' . $operationId . '/' . $locationId;
        $this->loadModel('AlertTypes');
        $alertTypeList = $this->AlertTypes->getCompanyAlertType();
        $this->set(compact('alertTypeList'));

        $this->loadModel('Users');
        $companyStaffList = $this->Users->getStaffList(Configure::read('LoggedCompanyId'));
        $this->set(compact('companyStaffList'));
        $this->set(compact('userLocationList', 'userOperationList', 'previousPermitDetail', 'securityTypes', 'data', 'redirectHere'));
    }

    public function downloadAllFiles($permitId = null, $userPermitID = null) {
        $permitId = $this->Encryption->decode($permitId);
        $userPermitID = $this->Encryption->decode($userPermitID);
        $this->loadModel('Permits');
        $permitDetails = $this->Permits->previousPermitDetail($permitId, $userPermitID, 1);
        $response = [];
        if (isset($permitDetails['name']) && !empty($permitDetails['name'])) {
            $response['Permit'] = str_replace('/', '-', $permitDetails['name']);
        }
        //Documents
        if (isset($permitDetails['user_previous_permit_documents']) && !empty($permitDetails['user_previous_permit_documents'])) {
            foreach ($permitDetails['user_previous_permit_documents'] as $key2 => $value) {
                if (isset($value['file']) && !empty($value['file'])) {
                    if ($this->Custom->checkSecurity($value['security_type_id'])) {
                        $permit_document = [];
                        $path = WWW_ROOT . $value['file'];
                        $ext = pathinfo($path, PATHINFO_EXTENSION);
                        if (isset($ext) && !empty($ext)) {
                            $permit_document['fileExtension'] = $ext;
                            $permit_document['fileName'] = str_replace('/', '-', $value['name']);
                            $permit_document['fileToBeDownload'] = $path;
                            $response['Documents'][$key2] = $permit_document;
                        }
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
                if (isset($response['Documents']) && !empty($response['Documents'])) {
                    $path1d = new Folder($path->path . DS . 'Documents', true, 0777);
                    foreach ($response['Documents'] as $dData) {
                        copy($dData['fileToBeDownload'], $path1d->path . '/' . $dData['fileName'] . '.' . $dData['fileExtension']);
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

}
