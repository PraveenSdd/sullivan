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
        if (!$this->request->getParam('admin') && $this->Auth->user('role_id') != 1) {
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

        $pageTitle = 'Operation';
        $pageHedding = 'Operation';
        $breadcrumb = array(
            array('label' => 'Operation'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Operations');
        $conditions = ['Operations.is_deleted' => 0, 'Operations.is_active' => 1];

        if (isset($this->request->query['name']) && $this->request->query['name'] != '') {
            $conditions['Operations.name LIKE'] = '%' . $this->request->query['name'] . '%';
        }

        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
            'conditions' => $conditions,
            'order' => ['Operations.title' => 'asc'],
            'limit' => 10,
        ];
        $operations = $this->paginate($this->Operations);

        $this->set(compact('operations'));
    }

    /*
     * Function: Add()
     * Description: use for create new records operation
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function add() {
        $pageTitle = 'Operation | Add';
        $pageHedding = 'Add Operation';
        $breadcrumb = array(
            array('label' => 'Operation', 'link' => 'industries/'),
            array('label' => 'Add Operation'));
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
        $this->loadModel('Forms');
        $permits = $this->Forms->find('list');
        $permits->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.is_active' => 1]);
        $permitsList = $permits->toArray();
        $this->set(compact('permitsList'));

        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1, 'AlertTypes.id !=' => 2]);
        $alertTypesList = $alertTypes->toArray();
        $this->loadModel('Users');
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);

        $this->set(compact('alertTypesList', 'companiesLists', 'staffLists'));

        $this->set('_serialize', ['permitsList']);
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

    /*
     *  Function: getOperationPermit()
     * Description: use for operation related permit listing 
     * By @Ahsan Ahamad
     * Date : 4th Jan. 2018
     */

    public function getOperationPermit() {
        $this->autoRender = false;
        $this->loadModel('PermitOperations');
        $permits = $this->PermitOperations->find('list');
        $permits->hydrate(false)->where(['PermitOperations.operation_id' => $this->request->data['operationId']]);
        $permitsList = $permits->toArray();
        if ($permitsList) {
            $responce['flag'] = true;
            $responce['formId'] = $permitsList;
        }
        echo json_encode($responce);
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
                $permit['permit_id'] = $formId;
                $permit['added_by'] = $this->Auth->user('id');
                $permit['operation_id'] = $this->request->data['operation_id'];

                $permitOperation = $this->PermitOperations->newEntity($permit);
                $this->PermitOperations->patchEntity($permitOperation, $permit);

                $contactSuccess = $this->PermitOperations->save($permitOperation);
                if ($contactSuccess) {

                    $responce['flag'] = true;
                    $responce['operation_id'] = $this->request->data['operation_id'];
                    $responce['msg'] = 'Permit has been added successfully';
                } else {
                    $responce['msg'] = 'Permit could not be added successfully';
                }
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
        $operation['permit'] = $this->PermitOperations->find()->contain(['Forms'])->where(['PermitOperations.operation_id' => $operationId, 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->all();

        $this->set('operation', $operation);
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
            $operation['name'] = $this->request->data['name'];
            $operation['description'] = $this->request->data['description'];
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

            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $this->request->data['user_id'] = $this->userId;

            if (!empty($this->request->data['alert_id'])) {
                $id = $this->request->data['alert_id'];
                $alerts = $this->Alerts->get($id);
                $responce['msg'] = 'Alerts has been updated successfully.';
            } else {
                $alerts = $this->Alerts->newEntity($this->request->data);
                $responce['msg'] = 'Alerts has been added successfully.';
            }
            $this->Alerts->patchEntity($alerts, $this->request->data, ['validate' => 'Add']);
            if (!$alerts->errors()) {
                $success = $this->Alerts->save($alerts);

                if ($success) {
                    $alertOperation['alert_id'] = $success->id;
                    $alertOperation['operation_id'] = $this->request->data['operation_id'];
                    $alertOperation['user_id'] = $this->userId;
                    $alertOperation['added_by'] = $this->Auth->user('id');

                    if (!empty($this->request->data['operation_alert_id'])) {
                        $alerts = $this->AlertOperations->get($this->request->data['operation_alert_id']);
                    } else {
                        $alerts = $this->AlertOperations->newEntity($alertOperation);
                    }
                    $this->AlertOperations->patchEntity($alerts, $alertOperation);
                    $successAlertOperation = $this->AlertOperations->save($alerts);

                    /** code for save alert company * */
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
                            $companies = $this->AlertCompanies->newEntity();
                            $this->AlertCompanies->patchEntity($companies, $companydata);
                            $successAlertCompany = $this->AlertCompanies->save($companies);
                        }
                        if ($success) {
                            /** code for send email to multiple users and companies * */
                            $template = 'new_alert';
                            $subject = "New Alerts";
                            $this->Custom->sendMultipleEmail($emails, $template, $subject);
                        }
                    }
                    /** code for save alert Staff * */
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
                        if ($successAlert) {
                            $staffs = $this->Users->find('list', ['valueField' => 'email']);
                            $staffs->hydrate(false)->select(['Users.email'])->where(['Users.id in' => $this->request->data['staff_id'], 'Users.is_deleted' => 0, 'Users.is_active' => 1]);
                            $emails = $staffs->toArray();
                            /** code for send email to multiple users and companies * */
                            $template = 'new_alert';
                            $subject = "New Alerts";
                            $this->Custom->sendMultipleEmail($emails, $template, $subject);
                        }
                    }

                    $responce['flag'] = true;
                    $responce['alert_id'] = $success->id;
                    $responce['operation_id'] = $this->request->data['operation_id'];
                } else {
                    $responce['flag'] = false;
                    $responce['msg'] = 'Alerts could not be added.';
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = $this->Custom->multipleFlash($alerts->errors());
            }
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
        $operation['alert'] = $this->AlertOperations->find()->contain(['Alerts', 'Alerts.AlertCompanies', 'Alerts.AlertStaffs'])->where(['AlertOperations.operation_id' => $operationId, 'AlertOperations.is_deleted' => 0, 'AlertOperations.is_active' => 1])->all();

        $this->set('operation', $operation);
        echo $this->render('/Element/backend/operation/alert_list');
        exit;
    }

    /*
     * Function: edit()
     * Description: use for edit operation records
     * @param type: $id 
     * By @Ahsan Ahamad
     * Date : 12th Dec. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Operation | Edit';
        $pageHedding = 'Edit Operation';
        $breadcrumb = array(
            array('label' => 'Operation', 'link' => 'industries/'),
            array('label' => 'Edit Operation'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Operations');
        $this->loadModel('AgenyOperation');

        $id = $this->Encryption->decode($id);
        if ($this->request->is('post')) {
            $id = $this->request->data['id'];
            $this->request->data['name'] = ucfirst($this->request->data['name']);
            $this->request->data['description'] = ucfirst($this->request->data['description']);
            $operations = $this->Operations->newEntity();
            $this->Operations->patchEntity($operations, $this->request->data, ['validate' => 'Add']);
            if (!$operations->errors()) {
                if ($success = $this->Operations->save($operations)) {

                    $this->Flash->success(__('Operation has been update successfully.'));
                    return $this->redirect(['controller' => 'operations', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Operation could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($industries->errors())));
            }
        }
        $this->loadModel('Forms');
        $this->loadModel('AlertTypes');
        $this->loadModel('AlertOperations');
        $this->loadModel('PermitOperations');
        $this->loadModel('Users');

//*** get all permit for show in list ** 
        $permits = $this->Forms->find('list');
        $permits->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.is_active' => 1]);
        $permitsList = $permits->toArray();

// get operation/industry for show in list 

        $operation = $this->Operations->find()->select(['name', 'description', "id"])->where(['Operations.id =' => $id])->first();

//** get all alert related to operation for show in list **

        $operation['alert'] = $this->AlertOperations->find()->contain(['Alerts', 'Alerts.AlertCompanies', 'Alerts.AlertStaffs'])->where(['AlertOperations.operation_id' => $id, 'AlertOperations.is_deleted' => 0, 'AlertOperations.is_active' => 1])->all();
//prx($operation['alert']);
        $operation['permit'] = $this->PermitOperations->find()->contain(['Forms'])->where(['PermitOperations.operation_id' => $id, 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->all();

//** get all alert type show in list **

        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1, 'AlertTypes.id !=' => 4]);
        $alertTypesList = $alertTypes->toArray();

//** get all staff type show in list ** 
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);

        $this->set(compact('alertTypesList', 'companiesLists', 'staffLists', 'permitsList', 'operation'));
    }

    /* Function: view()
     * Description: function use for view particular get data by select id
     * @param type: $id
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Operation | View';
        $pageHedding = 'Operation | View ';
        $breadcrumb = array(
            array('label' => 'Operation', 'link' => 'industries/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $this->loadModel('Forms');
        $this->loadModel('AlertTypes');
        $this->loadModel('AlertOperations');
        $this->loadModel('FormOperations');
        $this->loadModel('Users');
        $this->loadModel('Operations');

//* get all permit for show in list ** 
        $permits = $this->Forms->find('list');
        $permits->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.is_active' => 1]);
        $permitsList = $permits->toArray();
//* get operatio/ for show in list **  

        $operation = $this->Operations->find()->select(['name', 'description', "id"])->where(['Operations.id =' => $id])->first();

//*get all alert related to operation for show in list ** 

        $operation['alert'] = $this->AlertOperations->find()->contain(['Alerts', 'Alerts.AlertCompanies', 'Alerts.AlertStaffs'])->where(['AlertOperations.operation_id' => $id, 'AlertOperations.is_deleted' => 0, 'AlertOperations.is_active' => 1])->all();

        $operation['permit'] = $this->PermitOperations->find()->contain(['Forms'])->where(['PermitOperations.industry_id' => $id, 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->all();

//** get all alert type show in list ***  

        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();

//** get all staff type show in list ***   
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);

        $this->set(compact('alertTypesList', 'companiesLists', 'staffLists', 'permitsList', 'operation'));
    }

}
