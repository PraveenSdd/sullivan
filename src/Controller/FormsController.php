<?php

namespace App\Controller;

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
        'limit' => 5,
        'order' => [
            'Forms.tile' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Upload');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * Function: index()
     * Description: use for listing of data table
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function index() {
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Permit';
        $pageHedding = 'Permit';
        $breadcrumb = array(
            array('label' => 'Permit List'),
        );
        $user_id = $this->Auth->user('id');
        $breadcrumbBottam = array(
            array('label' => 'Permit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->loadModel('Permits');
        $accessPermits = $this->Permits->find()->contain(['UserLocations', 'Categories', 'Industries', 'Forms'])->where(['Permits.user_id' => $this->Auth->user('id'), 'Permits.permit_status_id' => 2])->all();
        $this->loadModel('LocationIndustries');
        $locationIndustries = $this->LocationIndustries->find()->where(['LocationIndustries.user_id' => $this->userId])->all();
        $this->set(compact('locationIndustries', 'accessPermits'));
    }

    /*
     * Function:  view()
     * Description: use for form details of data table
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 8th Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Permit | View';
        $pageHedding = 'View ';
        $breadcrumb = array(
            array('label' => 'Permit', 'link' => 'forms/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $form = $this->Forms->find()->hydrate(false)
                        ->contain(['Documents'])->where(['Forms.id =' => $id])->first();

        $this->set(compact('form'));
    }

    /*
     *  Function:index()
     * Description: use for form  dropdown listing of data table
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function getForms($id = null) {
        $this->autoRender = FALSE;
        $id = $this->request->data['id'];
        $forms = $this->Forms->find('list');
        $forms->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.category_id' => $id]);
        $$formsList = $forms->toArray();

        $listHtml = '<option value="">-- Select Forms -- </option>';
        $listArray = array();

        foreach ($$formsList as $key => $value) {
            $listHtml .= '<option value="' . $key . '">' . $value . '</option>';
            $listArray[$key] = $value;
        }
        echo $listHtml;
        exit;
    }

    /*
     * Function: upload() 
     * Description:use for  filled form upload .
     * By @Ahsan Ahamad
     * Date : 25rd Nov. 2017
     */

    public function upload() {

        $pageTitle = 'Forms | Upload';
        $pageHedding = 'Upload';
        $breadcrumb = array(
            array('label' => 'Forms', 'link' => 'forms/index'),
            array('label' => 'Upload'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('ProjectDocuments');
        if ($this->request->is('post')) {

            $this->request->data['created'] = date('Y-m-d');
            $formss = $this->ProjectDocuments->newEntity();
            $this->ProjectDocuments->patchEntity($formss, $this->request->data, ['validate' => 'Upload']);
            $userName = $this->Auth->user('id') . trim($this->Auth->user('first_name'));
            $fineData = $this->Upload->uploadUserForm($this->request->data['file'], $userName);
            $formss['path'] = $fineData;
            $formss['user_id'] = $this->Auth->user('id');
            if (!$formss->errors()) {
                $success = $this->ProjectDocuments->save($formss);
                if ($success) {
                    $this->Flash->success(__('Form has been saved successfully.'));
                    return $this->redirect(['controller' => 'forms', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Form could not be saved'));
                    return $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($categories->errors())));
                return $this->redirect($this->referer());
            }
        }

        $this->loadModel('Categories');
        $this->loadModel('UserLocations');
        $this->loadModel('Projects');
        $categories = $this->Categories->find('treeList', ['limit' => 200])->contain('ParentCategories');
        $categories->hydrate(false)->where(['Categories.is_deleted' => 0, 'Categories.parent_id' => 0]);
        $categotylist = $categories->toArray();

        $projects = $this->Projects->find('list');
        $projects->hydrate(false)->select(['id', 'name'])->where(['Projects.is_deleted' => 0, 'Projects.is_active' => 1]);
        $projectslist = $projects->toArray();
        $locations = $this->UserLocations->find('list');
        $locations->hydrate(false)->select(['id', 'title'])->where(['UserLocations.is_deleted' => 0, 'UserLocations.is_active' => 1]);
        $locationlist = $locations->toArray();
        $this->set(compact('categotylist', 'projectslist', 'locationlist'));
        $this->set('_serialize', ['projectslist', 'categotylist', 'locationlist']);
    }

    /*
     * Function:  uploadFormsList()
     * Description: use for filled form list form .
     * By @Ahsan Ahamad
     * Date : 30th Nov. 2017
     */

    public function uploadFormsList() {
        $this->viewBuilder()->setLayout('dashboard');

        $pageTitle = 'Upload Forms List';
        $pageHedding = 'Upload Forms List';
        $breadcrumb = array(
            array('label' => 'Forms'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->loadModel('ProjectDocuments');
        $this->paginate = [
            'contain' => ['Categories', 'SubCategories', 'Projects', 'Forms'],
            'select' => ['ProjectDocuments.id', 'Project.name', 'Project.id', 'Categories.name', 'SubCategories.name', 'ProjectDocuments.creates', 'ProjectDocuments.is_active', 'ProjectDocuments.project_id', 'ProjectDocuments.sub_category_id', 'ProjectDocuments.category_id'],
            'conditions' => ['ProjectDocuments.is_deleted' => 0],
            'order' => ['ProjectDocuments.id' => 'DESC'],
            'limit' => 10,
        ];
        $forms = $this->paginate($this->ProjectDocuments);
        $this->set(compact('forms'));
    }

    /*
     * Function:  uploadFormView()
     * Description: use for view uploaded form
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 30th Nov. 2017
     */

    public function uploadFormView($id = null) {
        $pageTitle = 'Upload Forms | View';
        $pageHedding = 'View Forms';
        $breadcrumb = array(
            array('label' => 'Upload Forms', 'link' => 'forms/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('ProjectDocuments');
        $id = $this->Encryption->decode($id);
        $form = $this->ProjectDocuments->find()->hydrate(false)
                        ->contain(['Categories', 'SubCategories', 'Projects', 'Forms'])->where(['ProjectDocuments.id =' => $id])->first();

        $this->set(compact('form'));
    }

    /*
     * Function: editForms()
     *  Description: use for edit uploaded form.
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 30th Nov. 2017
     */

    public function editForms($id) {

        $pageTitle = 'Forms | Edit Form';
        $pageHedding = 'Edit Form';
        $breadcrumb = array(
            array('label' => 'Forms', 'link' => 'forms/index'),
            array('label' => 'Edit Form'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->loadModel('Documents');
        $this->loadModel('Faqs');

        if ($this->request->is('post')) {

            $formss = $this->Forms->newEntity();
            $this->Forms->patchEntity($formss, $this->request->data, ['validate' => 'Upload']);
            $formss['path'] = '/uploads';
            $formss['sub_category_id'] = $this->request->data['sub_category_id'];


            if (!$formss->errors()) {
                $success = $this->Forms->save($formss);
                if ($success) {
                    /*  code for save faq */
                    if ($this->request->data['question_id']) {
                        $deleteId = explode(',', $this->request->data['question_id']);
                        $condition = array('Faqs.id in' => $deleteId);
                        $this->Faqs->deleteAll($condition, false);
                    }
                    $coun = count(@$this->request->data['question']);
                    for ($i = 0; $i <= $coun - 1; $i++) {

                        if (!empty($this->request->data['faq_id'][$i])) {
                            $faqId = $this->request->data['faq_id'][$i];

                            $faqs = TableRegistry::get('Faqs');
                            $query = $faqs->query();
                            $query->update()
                                    ->set(['question' => $this->request->data['question'][$i],
                                        'answer' => $this->request->data['answer'][$i],
                                        'form_id' => $success->id,
                                    ])
                                    ->where(['id' => $faqId])
                                    ->execute();
                        } else {
                            $dataFaq = [
                                'question' => $this->request->data['question'][$i],
                                'answer' => $this->request->data['answer'][$i],
                                'created' => date('Y-m-d H:i:s'),
                                'form_id' => $success->id,
                            ];

                            /* these are line check serversite validation and save data  */

                            $faqs = TableRegistry::get('Faqs');
                            $faq = $faqs->newEntity($dataFaq);
                            $asset = $this->Faqs->patchEntity($faq, $dataFaq);
                            $succ = $faqs->save($faq);
                        }
                    }
                    $fineData = $this->Upload->uploadFile($this->request->data['file']);
                    $document['path'] = $fineData;
                    $Documents = TableRegistry::get('Documents');
                    $documentId = $this->request->data['document_id'];
                    $query = $Documents->query();
                    $query->update()
                            ->set(['path' => $document['path']])
                            ->where(['id' => $documentId])
                            ->execute();


                    $this->Flash->success(__('Form has been saved successfully.'));
                    return $this->redirect(['controller' => 'forms', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Form could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($categories->errors())));
            }
        }

        $id = $this->Encryption->decode($id);
        $form = $this->Forms->find()->hydrate(false)
                        ->contain(['Categories', 'Documents', 'Faqs'])->where(['Forms.id =' => $id])->first();
        $this->loadModel('Categories');

        $categories = $this->Categories->find('treeList', ['limit' => 200])->contain('ParentCategories');
        $categories->hydrate(false)->where(['Categories.is_deleted' => 0, 'Categories.parent_id' => 0]);
        $categotylist = $categories->toArray();

        $SubCategories = $this->Categories->find('treeList', ['limit' => 200])->contain('ParentCategories');

        $SubCategories->hydrate(false)->where(['Categories.is_deleted' => 0, 'Categories.parent_id' => $form['category']['id']]);
        $SubCategotylist = $SubCategories->toArray();

        $this->set(compact('categotylist', 'SubCategotylist', 'form'));
        $this->set('_serialize', ['categotylist']);
    }

    /*
     *  Function: downloadForm()
     *  Description: use for save project document data and download form/Permit
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 27th Nov. 2017
     */

    public function downloadForm($id = null) {
        if (!empty($this->request->data)) {
            $id = $this->request->data['id'];
        }
        $id = $this->Encryption->decode($id);
        $this->autoRender = false;
        $this->loadModel('Documents');
        $formDocument = $this->Documents->find()->where(['Documents.form_id =' => $id])->first();
        if (!empty($id)) {
            if (!empty($formDocument)) {
                $path = WWW_ROOT . $formDocument['path'];

                if (is_file($path)) {
                    $this->response->file($path, array(
                        'download' => true,
                        'name' => basename($formDocument['path']),
                    ));
                    return $this->response;
                } else {
                    $this->Flash->error("file not found");
                    $this->redirect($this->referer());
                }
            } else {
                $this->Flash->error("file not found");
                $this->redirect($this->referer());
            }
        }
    }

}
