<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class OperationsController extends AppController {

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
     *  Function: index()
     * Description: use for listing of operation
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function index() {

        $pageTitle = 'Manage Operations';
        $pageHedding = 'Manage Operations';
        $breadcrumb = array(
            array('label' => 'Manage Operations'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Operations');
        $conditions = ['Operations.is_deleted' => 0, 'Operations.is_active' => 1];

        if (isset($this->request->data['name']) && $this->request->data['name'] != '') {
            $conditions['Operations.name LIKE'] = '%' . $this->request->data['name'] . '%';
        }

        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }

        $this->paginate = [
            'contain' => ['Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'conditions' => $conditions,
            'order' => ['Operations.id' => 'DESC'],
            'limit' => $this->paginationLimit,
        ];
        $operations = $this->paginate($this->Operations);
        $this->set(compact('operations'));
    }

    /* Function: view()
     * Description: function use for view particular get data by select id
     * @param type: $id
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function view($operationId = null) {
        $this->set(compact('operationId'));
        $pageTitle = 'View Operation';
        $pageHedding = 'View Operation';
        $breadcrumb = array(
            array('label' => 'Manage Operations', 'link' => 'operations/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $operationId = $this->Encryption->decode($operationId);
        $this->loadModel('Permits');
        $this->loadModel('AlertTypes');
        $this->loadModel('AlertOperations');
        $this->loadModel('Users');
        $this->loadModel('Operations');
        $this->loadModel('PermitOperations');


//* get all permit for show in list ** 
        $permitOperationList = $this->PermitOperations->getOperationPermit($operationId);
//*** get all permit for show in list ** 
        $permitsList = $this->Permits->getPermitList($permitOperationList);
//* get operatio/ for show in list **  

        $operation = $this->Operations->find()->contain(['PermitOperations', 'PermitOperations.Permits', 'AlertOperations', 'AlertOperations.Alerts'])->where(['Operations.id =' => $operationId])->first();


//** get all alert type show in list ***  
        $alertTypesList = $this->AlertTypes->getAlertType();

//** get all staff type show in list ***   
//        $companiesLists = $this->Users->getCompanyList();
//        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);

        $this->set(compact('alertTypesList', 'permitsList', 'operation'));

        $this->loadModel('AlertOperations');
        $alertOperations = $this->AlertOperations->getDataByOperationId($operationId);
        $this->set(compact('alertOperations'));

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
        $redirectHere = '/admin/operations/view/' . $this->Encryption->encode($operationId);
        $this->set(compact('redirectHere'));
    }

    /*
     * Function: Add()
     * Description: use for create new records operation
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function add() {
        $pageTitle = 'Add Operation';
        $pageHedding = 'Add Operation';
        $breadcrumb = array(
            array('label' => 'Manage Operations', 'link' => 'operations/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Operations');
        if ($this->request->is('post')) {

            $this->request->data['name'] = ucfirst($this->request->data['name']);
            $this->request->data['description'] = ucfirst($this->request->data['description']);
            $this->request->data['slug'] = strtolower(
                    preg_replace(
                            "![^a-z0-9]+!i", "-", $this->request->data['name']
                    )
            );

            $industries = $this->Operations->newEntity();
            $this->Operations->patchEntity($industries, $this->request->data, ['validate' => 'Add']);
            if (!$industries->errors()) {
                if ($success = $this->Operations->save($industries)) {
                    $this->_updatedBy('Operations', $success->id);
                    /* === Added by vipin for  add log=== */
                    $message = 'Operation:' . $this->request->data('name') . ' Added by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'operations';
                    $saveActivityLog['module_name'] = 'Operation';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Add';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */
                    $this->Flash->success(__('Operation has been saved successfully.'));
                    return $this->redirect(['controller' => 'operations', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Operation could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($industries->errors())));
            }
        }
        /** get all category / agencies list * */
        $this->loadModel('Categories');
        /* get all permit list */



        $this->loadModel('AlertTypes');
        $alertTypesList = $this->AlertTypes->getAlertType();

        $this->loadModel('Users');
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);
        $this->set(compact('alertTypesList', 'companiesLists', 'staffLists'));

        $this->set('_serialize', ['permitsList']);

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

    /*
     * Function: edit()
     * Description: use for edit operation records
     * @param type: $id 
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */

    public function edit($operationId = null) {
        $this->set(compact('operationId'));
        $pageTitle = 'Edit Operation';
        $pageHedding = 'Edit Operation';
        $breadcrumb = array(
            array('label' => 'Manage Operations', 'link' => 'operations/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Operations');
        $this->loadModel('AgenyOperation');
        $operationId = $this->Encryption->decode($operationId);
        if ($this->request->is('post')) {
            $this->request->data['id'] = $operationId;
            $this->request->data['name'] = ucfirst($this->request->data['name']);
            $this->request->data['description'] = ucfirst($this->request->data['description']);
            $operations = $this->Operations->get($operationId);
            $this->Operations->patchEntity($operations, $this->request->data, ['validate' => 'Add']);
            if (!$operations->errors()) {
                if ($success = $this->Operations->save($operations)) {
                    $this->_updatedBy('Operations', $this->request->data['id']);
                    /* === Added by vipin for  add log=== */
                    $message = 'Operation:' . $this->request->data('name') . ' updated by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $this->request->data['id'];
                    $saveActivityLog['table_name'] = 'operations';
                    $saveActivityLog['module_name'] = 'Operation';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */

                    $this->Flash->success(__('Operation has been update successfully.'));
                    return $this->redirect(['controller' => 'operations', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Operation could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($industries->errors())));
            }
        }
        $this->loadModel('Permits');
        $this->loadModel('AlertTypes');
        $this->loadModel('AlertOperations');
        $this->loadModel('PermitOperations');
        $this->loadModel('Users');

        $this->loadModel('PermitOperations');

        $permitOperationList = $this->PermitOperations->getOperationPermit($operationId);
//*** get all permit for show in list ** 
        $permitsList = $this->Permits->getPermitList($permitOperationList);
// get operation/industry for show in list 
        $operation = $this->Operations->find()->contain(['PermitOperations', 'PermitOperations.Permits', 'AlertOperations'])->where(['Operations.id =' => $operationId])->first();


//** get all alert type show in list **
        $alertTypesList = $this->AlertTypes->getAlertType();

//** get all staff type show in list ** 
//        $companiesLists = $this->Users->getCompanyList();
//        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);

        $this->set(compact('alertTypesList', 'operation', 'permitsList'));


        $this->loadModel('AlertOperations');
        $alertOperations = $this->AlertOperations->getDataByOperationId($operationId);
        $this->set(compact('alertOperations'));

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
        $redirectHere = '/admin/operations/edit/' . $this->Encryption->encode($operationId);
        $this->set(compact('redirectHere'));
    }

    /*
     * Function: checkOperationUniqueName()
     * Description: use for check Unique operation name
     * @param type: $operationName and  $operationId
     * By @Ahsan Ahamad
     * Date : 11th Jan. 2018
     */

    public function checkOperationUniqueName($operationName = null, $operationId = null) {
        $this->autorander = FALSE;
        if (isset($this->request->data['name'])) {
            $operationName = $this->request->data['name'];
        }
        if (isset($this->request->data['id'])) {
            $operationId = $this->request->data['id'];
        }
        $nameStatus = $this->Operations->checkOperationUniqueName($operationName, $operationId);
        echo json_encode($nameStatus);

        exit;
    }

    /**
     * 
     */
    public function saveRelatedAlert($operationId) {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Alerts');
            $this->request->data['OperationAlert']['id'] = $this->request->data['OperationAlert']['alert_id'];
            $this->request->data['OperationAlert']['alert_type_id'] = 4;
            $this->request->data['OperationAlert']['operation_id'][] = $operationId;
            $response = $this->Alerts->saveAdminOperationData($this->request->data['OperationAlert'], $operationId);
            if (!$response['flag']) {
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            } else {
                $this->_updatedBy('Operations', $operationId);
                /* === Added by vipin for  add log=== */
                if (!empty($this->request->data['OperationAlert']['alert_id'])) {
                    $message = 'Operation Alert updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                } else {
                    $message = 'Operation Alert added by ' . $this->loggedusername;
                    $activity = 'Add';
                }
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['id'];
                $saveActivityLog['table_name'] = 'alerts';
                $saveActivityLog['module_name'] = 'Operation Alert';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
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
    public function getRelatedAlert($operationId) {
        $this->autoRender = false;
        $this->loadModel('AlertOperations');
        $alertOperations = $this->AlertOperations->getDataByOperationId($operationId);
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($operationId));
        $this->set(compact('alertOperations', 'redirectHere'));
        echo $this->render('/Element/backend/operation/alert_list');
        exit;
    }

    /*
     *  Function: getOperationPermit()
     * Description: use for operation related permit listing 
     * By @Ahsan Ahamad
     * Date : 4th Jan. 2018
     */

    public function getOperationPermit() {
        $this->autoRender = false;
        $this->loadModel('Permits');
        $unAssignPermitList = $this->Permits->getUnAssignedPermitListByOpertionId($this->request->data['operationId']);
        $listHtml = '<option value="">-- Select Permit -- </option>';
        foreach ($unAssignPermitList as $key => $value) {
            $listHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
        }
        echo $listHtml;
        exit;
    }

    /*
     *  Function: addOperationPermit()
     * Description: use for add new operation related permit 
     * By @Ahsan Ahamad
     * Date : 4th Jan. 2018
     */

    public function addOperationPermit() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitOperations');

            foreach ($this->request->data['permit_id'] as $formId) {
                $permitExit = $this->PermitOperations->find()->where(['PermitOperations.permit_id' => $formId, 'PermitOperations.operation_id' => $this->request->data['operation_id'], 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->first();

                if (!$permitExit) {
                    $permit['permit_id'] = $formId;
                    $permit['added_by'] = $this->Auth->user('id');
                    $permit['operation_id'] = $this->request->data['operation_id'];

                    $permitOperation = $this->PermitOperations->newEntity($permit);
                    $this->PermitOperations->patchEntity($permitOperation, $permit);

                    $contactSuccess = $this->PermitOperations->save($permitOperation);
                    if ($contactSuccess) {
                        /* === Added by vipin for  add log=== */
                        $message = 'Operation Permit added by ' . $this->loggedusername;
                        $saveActivityLog = [];
                        $saveActivityLog['table_id'] = $contactSuccess->id;
                        $saveActivityLog['table_name'] = 'permit_operations';
                        $saveActivityLog['module_name'] = 'Operation Permit';
                        $saveActivityLog['url'] = $this->referer();
                        $saveActivityLog['message'] = $message;
                        $saveActivityLog['activity'] = 'Add';
                        $this->Custom->saveActivityLog($saveActivityLog);
                        /* === Added by vipin for  add log=== */
                        $responce['flag'] = true;
                        $responce['operation_id'] = $this->request->data['operation_id'];
                        $responce['msg'] = 'Permit has been added successfully';
                    } else {
                        $responce['msg'] = 'Permit could not be added successfully';
                        $responce['flag'] = false;
                    }
                } else {
                    $responce['msg'] = 'Permit already exit.';
                    $responce['flag'] = false;
                }
            }
            if (!empty($this->request->data['operation_id'])) {
                $this->_updatedBy('Operations', $this->request->data['operation_id']);
            }
        }
        echo json_encode($responce);
        exit;
    }

    /*
     *  Function: getReleatedOperationPermit()
     * Description: use for get operation related permit 
     * @param type: $operationId
     * By @Ahsan Ahamad
     * Date : 4th Jan. 2018
     */

    public function getReleatedOperationPermit($operationId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitOperations');
        $operation['permit_operations'] = $this->PermitOperations->find()->contain(['Permits'])->where(['PermitOperations.operation_id' => $operationId, 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->all();
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($operationId));
        $this->set(compact('operation', 'redirectHere'));
        echo $this->render('/Element/backend/operation/permit_list');
        exit;
    }

    /*
     * Function: saveOperationData();
     * Description: use for add new records by ajax
     * By @Ahsan Ahamad
     * Date : 5th Jan. 2018
     */

    public function saveOperationData() {
        $this->autoRender = false;
        //       $this->loadModel('Operations');
        if ($this->request->is('ajax')) {
            $operation['name'] = ucfirst($this->request->data['name']);
            $operation['description'] = ucfirst($this->request->data['description']);
            $operation['created'] = date('Y-m-d');
            $operation['added_by'] = $this->Auth->user('id');
            $operation['slug'] = strtolower(
                    preg_replace(
                            "![^a-z0-9]+!i", "-", $this->request->data['name']
                    )
            );
            $operations = $this->Operations->newEntity($operation);
            $this->Operations->patchEntity($operations, $operation, ['validate' => 'Add']);
            if (!$operations->errors()) {
                if ($success = $this->Operations->save($operations)) {
                    $this->_updatedBy('Operations', $success->id);
                    $responce['flag'] = true;
                    $responce['operation_id'] = $success->id;
                    $responce['msg'] = 'Operation has been saved successfully.';
                } else {
                    $responce['flag'] = false;
                    $responce['msg'] = 'Operation could not be saved successfully.';
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = $this->Custom->multipleFlash($industries->errors());
            }
            echo json_encode($responce);
            exit;
        }
    }

    /*
     * Function: addOperationAlert();
     * Description:  use for add alert related to operation/ industry new records by ajax
     * By @Ahsan Ahamad
     * Date : 6th Jan. 2018
     */

    public function addOperationAlert() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('AlertOperations');
            $this->loadModel('AlertCompanies');
            $this->loadModel('AlertStaffs');
            $this->loadModel('Users');
            $this->loadModel('Alerts');

            $this->request->data['flag'] = 4;
            $this->request->data['is_admin'] = 1;
            $this->request->data['user_id'] = $this->userId;

            $responce = $this->Alerts->addAlert($this->request->data);
        }
        echo json_encode($responce);
        exit;
    }

    /*
     * Function: addOperatiogetReleatedOperationAlert()
     * Description: use for get alert related to operation new records by ajax
     * @param type: $operationId
     * By @Ahsan Ahamad
     * Date : 6th Jan. 2018
     */

    public function getReleatedOperationAlert($operationId = null) {
        $this->autoRender = false;
        $this->loadModel('AlertOperations');
        $operation['alert_operations'] = $this->AlertOperations->find()->contain(['Alerts', 'Alerts.AlertCompanies', 'Alerts.AlertStaffs'])->where(['AlertOperations.operation_id' => $operationId, 'AlertOperations.is_deleted' => 0, 'AlertOperations.is_active' => 1])->all();
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($operationId));
        $this->set(compact('operation', 'redirectHere'));
        echo $this->render('/Element/backend/operation/alert_list');
        exit;
    }

    /*
     * Function: checkOperationPermit()
     * Description: use for check Unique permit name of the operation
     * By @Ahsan Ahamad
     * Date : 18th Jan. 2018
     */

    public function checkOperationPermit() {
        $this->autorander = FALSE;

        if ($this->request->is('post')) {
            $this->loadModel('PermitOperations');
            $operation = $this->PermitOperations->find()->where(['PermitOperations.permit_id in' => $this->request->data['prmitId'], 'PermitOperations.operation_id' => $this->request->data['operationId'], 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->first();
            if ($operation) {
                $responce['flag'] = true;
                $responce['msg'] = 'Permit already exist for the operation.';
            } else {
                $responce['flag'] = false;
            }
            echo json_encode($responce);
            exit;
        }
    }

}
