<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class FaqsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamads
     * Date : 2nd Nov. 2017
     */

    public $paginate = [
        'limit' => 5,
        'order' => [
            'Faqs.tile' => 'asc'
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
     * @Description: use for listing of faq
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'FAQ';
        $pageHedding = 'FAQ';
        $breadcrumb = array(
            array('label' => 'FAQ'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Faqs');
        $conditions = ['Faqs.is_deleted' => 0, 'Faqs.form_id' => 0];
        if (@$this->request->query['title'] != '' && @$this->request->query['status'] != '') {
            $conditions = ['Faqs.is_deleted' => 0, 'Faqs.question LIKE' => '%' . $this->request->query['title'] . '%', 'Faqs.is_active' => $this->request->query['status']];
        } else if (@$this->request->query['title'] != '') {
            $conditions = ['Faqs.is_deleted' => 0, 'Faqs.question LIKE' => '%' . $this->request->query['title'] . '%'];
        } else if (@$this->request->query['status'] != '') {
            $conditions = ['Faqs.is_deleted' => 0, 'Faqs.is_active' => $this->request->query['status']];
        }
        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
            'conditions' => $conditions,
            'order' => ['Faqs.title' => 'asc'],
            'limit' => 10,
        ];
        $faqs = $this->paginate($this->Faqs);

        $this->set(compact('faqs'));
    }

    /*
     * @Function: add()
     * @Description: use for create new faq
     * @By @Ahsan Ahamad
     * @Date : 23rd Nov. 2017
     */

    public function add() {
        $pageTitle = 'Faqs | Add';
        $pageHedding = 'Add Faqs';
        $breadcrumb = array(
            array('label' => 'Faqs', 'link' => 'faqs/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $this->request->data['question'] = ucfirst($this->request->data['question']);
            $this->request->data['answer'] = ucfirst($this->request->data['answer']);
            $faqs = $this->Faqs->newEntity();
            $this->Faqs->patchEntity($faqs, $this->request->data, ['validate' => 'Faq']);
            if (!$faqs->errors()) {
                if ($this->Faqs->save($faqs)) {
                    $this->Flash->success(__('Faqs has been saved successfully.'));
                    return $this->redirect(['controller' => 'faqs', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Faqs could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($faqs->errors())));
            }
        }
    }

    /*
     * @Function: edit()
     * @Description: use for edit the faq 
     *  @param: type $id
     * @By @Ahsan Ahamad
     * @Date : 23rd Nov. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Faqs | Edit';
        $pageHedding = 'Add Faqs';
        $breadcrumb = array(
            array('label' => 'Faqs', 'link' => 'faqs/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        if ($this->request->is('post')) {
            $this->request->data['question'] = ucfirst($this->request->data['question']);
            $this->request->data['answer'] = ucfirst($this->request->data['answer']);
            $faqs = $this->Faqs->newEntity();
            $this->Faqs->patchEntity($faqs, $this->request->data, ['validate' => 'Faq']);
            if (!$faqs->errors()) {
                if ($this->Faqs->save($faqs)) {
                    $this->Flash->success(__('Faqs has been saved successfully.'));
                    return $this->redirect(['controller' => 'faqs', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Faqs could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($faqs->errors())));
            }
        }
        $id = $this->Encryption->decode($id);
        $faq = $this->Faqs->find()->select(['question', 'answer', "id"])->where(['Faqs.id =' => $id])->first();
        $this->set(compact('faq'));
    }

    /* @Function: view()
     * @Description: function use for view particular get data by select id
     *  @param: type $id
     * @By @Ahsan Ahamad
     * @Date : 23rd Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Faqs | View';
        $pageHedding = 'View Faqs';
        $breadcrumb = array(
            array('label' => 'Faqs', 'link' => 'faqs/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $id = $this->Encryption->decode($id);
        $faq = $this->Faqs->find()->where(['Faqs.id =' => $id])->first();
        $this->set(compact('faq'));
    }

}
