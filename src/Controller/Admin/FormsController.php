<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class FormsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamad
     * Date : 2nd Nov. 2017
     */

    public $paginate = [
        'limit' => PAGINATION_LIMIT,
        'order' => [
            'Forms.tile' => 'asc'
        ]
    ];

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
     * @Function: index()
     * @Description: use for listing of data table
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'Permits';
        $pageHedding = 'Permits';
        $breadcrumb = array(
            array('label' => 'Permits'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $conditions = ['Forms.is_deleted' => 0];
        if (@$this->request->query['title'] != '' && @$this->request->query['status'] != '') {
            $conditions = ['Forms.is_deleted' => 0, 'Forms.title LIKE' => '%' . $this->request->query['title'] . '%', 'Forms.is_active' => $this->request->query['status']];
        } else if (@$this->request->query['title'] != '') {
            $conditions = ['Forms.is_deleted' => 0, 'Forms.title LIKE' => '%' . $this->request->query['title'] . '%'];
        } else if (@$this->request->query['status'] != '') {
            $conditions = ['Forms.is_deleted' => 0, 'Forms.is_active' => $this->request->query['status']];
        }
        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
            'contain' => ['FormAttributes'],
            'conditions' => $conditions,
            'order' => ['Forms.title' => 'asc'],
            'limit' => PAGINATION_LIMIT,
        ];
        $forms = $this->paginate($this->Forms);

        $this->set(compact('forms'));
    }

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

            $listHtml = '<option value="">-- Select Sub-Agency -- </option>';
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

    public function edit($id) {

        $pageTitle = 'Permits | Edit Form';
        $pageHedding = 'Edit Pertmit';
        $breadcrumb = array(
            array('label' => 'Permits', 'link' => 'forms/index'),
            array('label' => 'Edit Pertmit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Documents');
        $this->loadModel('FormDocumentSamples');
        $this->loadModel('FormAttributes');
        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $this->loadModel('AlertPermits');
        $this->loadModel('PermitOperations');
        $this->loadModel('PermitAgencies');

        if ($this->request->is('post')) {
            $formss['title'] = $this->request->data['title'];
            $formss['description'] = $this->request->data['description'];
            $formss = $this->Forms->newEntity();
            $this->Forms->patchEntity($formss, $this->request->data, ['validate' => 'Upload']);
            if (!$formss->errors()) {
                $successForm = $this->Forms->save($formss);
                if ($successForm) {
                    $this->Flash->success(__('Form has been saved successfully.'));
                    return $this->redirect(['controller' => 'forms', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Form could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($formss > errors())));
            }
        }
        $id = $this->Encryption->decode($id);

        $form = $this->Forms->find()->hydrate(false)
                        ->contain(['Documents', 'Documents.FormDocumentSamples', 'FormAttachments', 'FormAttachments.FormAttachmentSamples', 'FormAttributes', 'Faqs', 'PermitInstructions','PermitDeadlines', 'AlertPermits.Alerts', 'AlertPermits.Alerts.AlertIndustries', 'AlertPermits.Alerts.AlertCompanies', 'AlertPermits.Alerts.AlertStaffs'])->where(['Forms.id =' => $id])->first();

        /* get all  alert list */

        $form['alerts'] = $this->AlertPermits->find()->hydrate(false)
                        ->contain(['Alerts'])
                        ->where(['AlertPermits.form_id =' => $id])->all();

        /* get all operation list related to permit */
        $form['operations'] = $this->PermitOperations->find()->contain(['Operations'])->hydrate(false)->where(['PermitOperations.permit_id =' => $id, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1])->all();

        /* get all operation list related to permit */
        $form['agencies'] = $this->PermitAgencies->find()->contain(['Categories', 'AgencyContacts'])->where(['PermitAgencies.permit_id' => $id, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->all();
        /* get all  agencies list */
        $this->loadModel('Categories');
        $categories = $this->Categories->find('treeList', ['limit' => 200]);
        $categories->hydrate(false)->where(['Categories.is_deleted' => 0, 'Categories.parent_id' => 0]);
        $categotylist = $categories->toArray();

        /* get all alert type */
        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();

        /* get all company list */
        $this->loadModel('Users');
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);
        /* get all operation list */

        $this->loadModel('Operations');
        $operations = $this->Operations->find('list');
        $operations->hydrate(false)->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1]);
        $operationsList = $operations->toArray();

        $this->set('_serialize', ['operationsList']);
        /* get all US states list */
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();
        $this->set(compact('alertTypesList', 'operationsList', 'statesList', 'categotylist', 'companiesLists', 'staffLists', 'form'));
    }

    /*
     * @Function: view()
     * @Description: use for view permit
     * @param type $id
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Permits | View';
        $pageHedding = 'View Pertmit';
        $breadcrumb = array(
            array('label' => 'Permits', 'link' => 'forms/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $this->loadModel('Documents');
        $this->loadModel('FormDocumentSamples');
        $this->loadModel('FormAttributes');
        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $this->loadModel('AlertPermits');
        $this->loadModel('PermitOperations');
        $this->loadModel('PermitAgencies');
        $form = $this->Forms->find()->hydrate(false)
                        ->contain(['Documents', 'Documents.FormDocumentSamples', 'FormAttachments', 'FormAttachments.FormAttachmentSamples', 'FormAttributes', 'Faqs', 'PermitDeadlines','PermitInstructions', 'AlertPermits.Alerts', 'AlertPermits.Alerts.AlertIndustries', 'AlertPermits.Alerts.AlertCompanies', 'AlertPermits.Alerts.AlertStaffs'])->where(['Forms.id =' => $id])->first();

        /* get all  alert list */

        $form['alerts'] = $this->AlertPermits->find()->hydrate(false)
                        ->contain(['Alerts'])
                        ->where(['AlertPermits.form_id =' => $id])->all();

        /* get all operation list related to permit */
        $form['operations'] = $this->PermitOperations->find()->contain(['Operations'])->hydrate(false)->where(['PermitOperations.permit_id =' => $id, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1])->all();

        /* get all operation list related to permit */
        $form['agencies'] = $this->PermitAgencies->find()->contain(['Categories', 'AgencyContacts'])->where(['PermitAgencies.permit_id' => $id, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->all();

        /* get all agencies list */
        $this->loadModel('Categories');
        $categories = $this->Categories->find('treeList', ['limit' => 200]);
        $categories->hydrate(false)->where(['Categories.is_deleted' => 0, 'Categories.parent_id' => 0]);
        $categotylist = $categories->toArray();
        /* get all Alert type list */
        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        /* get all companies list */
        $this->loadModel('Users');
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);
        /* get all operations list */
        $this->loadModel('Operations');
        $operations = $this->Operations->find('list');
        $operations->hydrate(false)->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1]);
        $operationsLists = $operations->toArray();
        $this->set(compact('alertTypesList', 'operationsLists', 'categotylist', 'form', 'companiesLists', 'staffLists'));
    }

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
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitDeadlines');
            $this->request->data['user_id'] = $this->userId;
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            if (!empty($this->request->data['form_deadline_id'])) {
                $permitDeadlines = $this->PermitDeadlines->get($this->request->data['form_deadline_id']);
            } else {
                $permitDeadlines = $this->PermitDeadlines->newEntity();
            }
            $this->PermitDeadlines->patchEntity($permitDeadlines, $this->request->data);
            if (!$permitDeadlines->errors()) {
                if ($succese = $this->PermitDeadlines->save($permitDeadlines)) {
                    /* get all agencies list */
                    $responce['flag'] = true;
                    $responce['permit_deadline_id'] = $succese->id;
                    $responce['form_id'] = $this->request->data['form_id'];
                    $responce['msg'] = 'Permit deadline has been added successfully';
                } else {
                    $responce['msg'] = 'Permit deadline could not be added successfully';
                }
            } else {
                $responce['flag'] = true;
                $responce['msg'] = $this->Custom->multipleFlash($permitDeadlines->errors());
            }
            echo json_encode($responce);
            exit;
        }
    }

    /* @Function: getReleatedDeadline()
     * @Description: get permit Deadline  document of the permit form element file  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017
     */

    public function getReleatedDeadline($formId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitDeadlines');
        $form['permit_deadlines'] = $this->PermitDeadlines->find()->where(['PermitDeadlines.form_id' => $formId])->all();
        $this->set('form', $form);
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

        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {

            $this->loadModel('PermitAgencies');
            $this->loadModel('Categories');
            $this->request->data['user_id'] = $this->userId;

            $agencyId = $this->PermitAgencies->find()->select('id')->where(['PermitAgencies.agency_id' => $this->request->data['agency_id'], 'PermitAgencies.permit_id' => $this->request->data['permit_id'], 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->first();
            if (empty($agencyId->id)) {

                $agency['agency_contact_id'] = $this->request->data['agency_conatct_id'];
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
                    $succese = $this->PermitAgencies->save($permitAgency);

                    if ($succese) {
                        /* get save agencies list */
                        $responce['flag'] = true;

                        $responce['permitAgencyId'] = $succese->id;
                        $responce['permit_id'] = $this->request->data['permit_id'];
                        $responce['msg'] = 'Permit agency has been added successfully';
                    } else {
                        $responce['msg'] = 'Permit agency could not be added successfully';
                    }
                } else {
                    $responce['flag'] = false;
                    $responce['msg'] = $this->Custom->multipleFlash($permitAgency->errors());
                }
            } else {
                $responce['msg'] = 'Agency is already exit of the permit';
            }

            echo json_encode($responce);
            exit;
        }
    }

    /* @Function: getReleatedAgency()
     * @Description:get agency related to permit  
     * @param type $permitId
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017

     */

    public function getReleatedAgency($permitId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitAgencies');
        $form['agencies'] = $this->PermitAgencies->find()->contain(['Categories', 'AgencyContacts'])->where(['PermitAgencies.permit_id' => $permitId, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->all();
        $this->set('form', $form);
        echo $this->render('/Element/backend/permit/agency_list');
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

        $responce['flag'] = false;
        $responce['msg'] = '';
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
                        $responce['msg'] = 'Permit operation has been updated successfully';
                    } else {
                        $permitAgency = $this->PermitOperations->get($this->request->data['id']);
                        $responce['msg'] = 'Permit operation has been added successfully';
                    }
                    $this->PermitOperations->patchEntity($permitOperation, $operations);

                    if (!$permitOperation->errors()) {
                        $succese = $this->PermitOperations->save($permitOperation);
                        if ($succese) {
                            /* get save agencies list */
                            $responce['flag'] = true;

                            $responce['permitOperationId'] = $succese->id;
                            $responce['permit_id'] = $this->request->data['permit_id'];
                        } else {
                            $responce['msg'] = 'Permit operation could not be added successfully';
                        }
                    } else {
                        $responce['flag'] = false;
                        $responce['msg'] = $this->Custom->multipleFlash($permitAgency->errors());
                    }
                } else {
                    $responce['msg'] = 'Operation is already exit of the permit';
                }
            }
            echo json_encode($responce);
            exit;
        }
    }

    /* @Function: getReleatedAgency()
     * @Description:get agency related to permit  
     * @By @Ahsan Ahamad
     * @Date : 9th Dec. 2017

     */

    public function getReleatedOperation($permitId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitOperations');
        $form['operations'] = $this->PermitOperations->find()->contain('Operations')->where(['PermitOperations.permit_id' => $permitId])->all();
        $this->set('form', $form);
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
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('Documents');
            $userId = $this->userId;
            $formId = $this->request->data['form_id'];
            if (!empty($this->request->data['forms'])) {
                foreach ($this->request->data['forms'] as $key => $formDocument) {
                    $pathDocument = 'files/form_documents';
                    $documentdata['name'] = $formDocument['form_name'];
                    $Documentfiles = $this->Upload->uploadOtherFile($formDocument['form_document'], $pathDocument);
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
                    if ($saveDocument) {
                        $responce['flag'] = true;
                        $responce['`form_documents'] = $saveDocument->id;
                        $responce['form_id'] = $this->request->data['form_id'];
                        $responce['msg'] = 'Form has been added successfully';
                    } else {
                        $responce['msg'] = 'Form agency could not be added successfully';
                    }
                }
            } else {
                $responce['msg'] = 'Please upload forms';
            }
            echo json_encode($responce);
            exit;
        }
    }

    /* @Function:getReleatedForms()
     * @Descrition: get forms of the permit form permit operation popup  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getReleatedForms($formId = null) {
        $this->autoRender = false;
        $this->loadModel('Documents');
        $form['documents'] = $this->Documents->find()->contain(['FormDocumentSamples'])->where(['Documents.form_id' => $formId])->all();
        $this->set('form', $form);
        echo $this->render('/Element/backend/permit/forms_list');
        exit;
    }

    /* @Function:getReleatedDocuments()
     * @Descrition: get  documents of the permit form permit operation popup
     * @param type $formId     
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getReleatedDocuments($formId = null) {
        $this->autoRender = false;
        $this->loadModel('Documents');
        $form['documents'] = $this->Documents->find()->contain(['FormDocumentSamples'])->where(['Documents.form_id' => $formId])->all();
        $this->set('form', $form);
        echo $this->render('/Element/backend/permit/forms_list');
        exit;
    }

    /* @Function:getReleatedDocuments()
     * @Descrition:add form attechment file of the permit  
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017

     */

    public function addPermitFormsAttachment() {

        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
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
                        $formAttachmentSamplesTable = $formAttachmentSamplesTable->newEntity($formAttachmentFile);
                        $this->FormAttachmentSamples->patchEntity($formAttachmentSamplesTable, $formAttachmentFile);
                        $saveFormAttachmentSample = $this->FormAttachmentSamples->save($formAttachmentSamplesTable);
                    }
                }
                $responce['flag'] = true;
                $responce['`form_attachments'] = $saveFormAttachment->id;
                $responce['form_id'] = $this->request->data['form_id'];
                $responce['msg'] = 'Document has been added successfully';
            } else {
                $responce['msg'] = 'Please Upload Document';
            }
        }

        echo json_encode($responce);
        exit;
    }

    /* @Function:getReleatedFormAttachment()
     * @Descrition:get forms attachmentmnt  document of the permit  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getReleatedFormAttachment($formId = null) {
        $this->autoRender = false;
        $this->loadModel('FormAttachments');
        $form['form_attachments'] = $this->FormAttachments->find()->contain(['FormAttachmentSamples'])->where(['FormAttachments.form_id' => $formId])->all();
        $this->set('form', $form);
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
        $responce['flag'] = false;
        $responce['msg'] = '';

        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $userId = $this->userId;
        $formId = $this->request->data['form_id'];

        if ($this->request->is('post')) {
            $this->loadModel('AlertIndustries');
            $this->loadModel('AlertCompanies');
            $this->loadModel('AlertStaffs');
            $this->loadModel('Users');
            $this->loadModel('Alerts');
            $this->loadModel('AlertPermits');
            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d', strtotime($this->request->data['date']));
            $this->request->data['user_id'] = $userId;
            if (!empty($this->request->data['interval'])) {
                $this->request->data['interval_alert'] = (int) $this->request->data['interval'];
            }

            if ($this->request->data['alert_id']) {
                $alerts = $this->Alerts->get($this->request->data['alert_id']);
            } else {
                $alerts = $this->Alerts->newEntity();
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
                    if (!empty($this->request->data['industry_id']) && $this->request->data['alert_type_id'] == 4) {
                        $conditionSample = array('AlertIndustries.alert_id' => $this->request->data['alert_id']);
                        $this->AlertIndustries->deleteAll($conditionSample, false);

                        foreach ($this->request->data['industry_id'] as $key => $value) {
                            $industry['industry_id'] = $value;
                            $industry['created'] = date('Y-m-d');
                            $industry['alert_id'] = $success->id;
                            $industry['alert_type_id'] = $this->request->data['alert_type_id'];
                            $industryies = $this->AlertIndustries->newEntity();
                            $this->AlertIndustries->patchEntity($industryies, $industry);
                            $successAlertIndusty = $this->AlertIndustries->save($industryies);
                        }
                    }

                    $responce['flag'] = true;
                    $responce['`alert_id'] = $success->id;
                    $responce['form_id'] = $this->request->data['form_id'];
                    $responce['msg'] = 'Alerts has been saved successfully.';
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

    /* @Function: addPermitgetReleatedFormAlertFormsAlert()
     * @Descrition:get alert of the permit 
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getReleatedFormAlert($formId = null) {
        $this->autoRender = false;
        $this->loadModel('AlertPermits');
        $form['alerts'] = $this->AlertPermits->find()->hydrate(false)
                        ->contain(['Alerts'])
                        ->where(['AlertPermits.form_id =' => $formId])->all();

        $this->set('form', $form);
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
            $this->loadModel('AlertStaff');
            $alertStaff = $this->AlertStaff->find('list', ['keyField' => 'user_id', 'valueField' => 'user_id']);
            $alertStaff->hydrate(false)->where(['AlertStaff.alert_id' => $alertId]);
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

    public function permit($id = null) {
        $pageTitle = 'Permits | Add ';
        $pageHedding = 'Add Pertmit';
        $breadcrumb = array(
            array('label' => 'Permits', 'link' => 'forms/index'),
            array('label' => 'Add '),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Documents');
        $this->loadModel('FormDocumentSamples');
        $this->loadModel('FormAttributes');
        $this->loadModel('FormAttachments');
        $this->loadModel('FormAttachmentSamples');
        $this->loadModel('Faqs');
        if ($this->request->is('post')) {
            $this->request->data['created'] = date('Y-m-d');
            /* Form data */
            $formss['title'] = $this->request->data['title'];
            $formss['description'] = $this->request->data['description'];
            $formss['created'] = date('Y-m-d');
            if (!empty($id)) {
                $formss = $this->Forms->get($id);
            } else {
                $formss = $this->Forms->newEntity();
            }
            $this->Forms->patchEntity($formss, $this->request->data, ['validate' => 'Upload']);
            if (!$formss->errors()) {
                if ($this->Forms->save($formss)) {
                    $this->Flash->success(__('Permit has been saved successfully.'));
                    return $this->redirect(['controller' => 'forms', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Permit could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($formss->errors())));
            }
        }

        $this->loadModel('Categories');
        $categories = $this->Categories->find('treeList', ['limit' => 200]);
        $categories->hydrate(false)->where(['Categories.is_deleted' => 0, 'Categories.parent_id' => 0]);
        $categotylist = $categories->toArray();
        /* get all alert type list */
        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        $this->loadModel('Users');
        /* get all operation list */
        $this->loadModel('Operations');
        $operations = $this->Operations->find('list');
        $operations->hydrate(false)->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1]);
        $operationsLists = $operations->toArray();

        /* get all company list */

        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'), 4);
        $this->set(compact('categotylist', 'alertTypesList', 'operationsLists', 'companiesLists', 'staffLists'));
        $this->set('_serialize', ['categotylist', 'industrylist']);
    }

    /* @Function: savePermitData()
     * @Descrition: use for save new permit from ajax
     * @By @Ahsan Ahamad
     * @Date : 18 Dec. 2017
     */

    public function savePermitData() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $formss['title'] = $this->request->data['title'];
            $formss['description'] = $this->request->data['description'];
            $formss['created'] = date('Y-m-d');

            $formss = $this->Forms->newEntity();
            $this->Forms->patchEntity($formss, $this->request->data, ['validate' => 'Upload']);
            if (!$formss->errors()) {
                $successForm = $this->Forms->save($formss);
                if ($successForm) {
                    $responce['flag'] = true;
                    $responce['form_id'] = $successForm->id;
                    $responce['msg'] = 'Permit has been saved successfully.';
                } else {
                    $responce['flag'] = false;
                    $responce['msg'] = 'Permit could not be saved successfully.';
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = $this->Custom->multipleFlash($formss->errors());
            }
            echo json_encode($responce);
            exit;
        }
    }

    /* @Function:addPermitInstructions()
     * @Descrition:add Instruction of the permit  
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017

     */

    public function addPermitInstructions() {

        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {
            $this->loadModel('PermitInstructions');
            $userId = $this->userId;
            $permitId = $this->request->data['permit_id'];

            /* Save form attachments date in form_attachments table */

            if (!empty($this->request->data['file_path'])) {
                $fielPath = 'files/permt/instruction';
                $permitInstructionFiles = $this->Upload->uploadOtherFile($this->request->data['file_path'], $fielPath);
                $this->request->data['file_path'] = $permitInstructionFiles;
            } else {
                $responce['msg'] = 'Please Upload Document';
            }
            if ($this->request->data['permit_instruction_id']) {
                $permitInsructions = $this->PermitInstructions->get($this->request->data['permit_instruction_id']);
            } else {
                $permitInsructions = $this->PermitInstructions->newEntity();
            }
            $permitInsructions = $this->PermitInstructions->patchEntity($permitInsructions, $this->request->data);
            if (!$permitInsructions->errors()) {
                if ($successInstruction = $this->PermitInstructions->save($permitInsructions)) {
                    $responce['flag'] = true;
                    $responce['`permit_instruction_id'] = $successInstruction->id;
                    $responce['permit_id'] = $this->request->data['permit_id'];
                    $responce['msg'] = 'Instrction has been added successfully';
                } else {
                    $responce['flag'] = false;
                    $responce['msg'] = 'Instrction could not be saved successfully.';
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = $this->Custom->multipleFlash($permitInsructions->errors());
            }

            echo json_encode($responce);
            exit;
        }
    }

        /* @Function:getReleatedFormAttachment()
         * @Descrition:get forms attachmentmnt  document of the permit  
         * @param type $formId
         * @By @Ahsan Ahamad
         * @Date : 10 Dec. 2017
         */

        public function getPermitInstructions($permitId = null) {
            $this->autoRender = false;
            $this->loadModel('PermitInstructions');
            $form['permit_instructions'] = $this->PermitInstructions->find()->where(['PermitInstructions.permit_id' => $permitId])->all();
            $this->set('form', $form);
            echo $this->render('/Element/backend/permit/permit_instruction_list');
            exit;
        }

        /* @Function: addPermitFormsAlert()
         * @Descrition:add agency of the permit form document permit  popup  
         * @By @Ahsan Ahamad
         * @Date : 10 Dec. 2017
         */
    }
    