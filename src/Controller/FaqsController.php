<?php

namespace App\Controller;

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

}
