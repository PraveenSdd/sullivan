<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class HowItWorksController extends AppController {
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
        $pageTitle = 'Manage How It Works';
        $pageHedding = 'Manage How It Works';
        $breadcrumb = array(
            array('label' => 'Manage How It Works'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $conditions = ['HowItWorks.is_deleted' => 0, 'HowItWorks.is_active' => 1];

        if (isset($this->request->data['title']) && $this->request->data['title'] != '') {
            $conditions['HowItWorks.title LIKE'] = '%' . $this->request->data['title'] . '%';
        }

        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }

        $this->paginate = [
            'contain'=>['Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'conditions' => $conditions,
            'order' => ['HowItWorks.id' => 'asc'],
            'limit' => 10,
        ];
        $howItWorks = $this->paginate($this->HowItWorks);
        $this->set(compact('howItWorks'));
    }

    /*
     * Function: edit()
     *  Description:  use for Edit of data Home page "How it work"
     * @param type: $id
     * By @Ahsan Ahamad
     * Date : 29th Jan. 2018
     */

    public function edit($id = null) {
        $this->set(compact('id'));
        $pageTitle = 'Edit How It Works ';
        $pageHedding = 'Edit How It Works';
        $breadcrumb = array(
            array('label' => 'Manage Website', 'link' => 'homePages/'),
            array('label' => 'Edit How It Works '),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $howItWork = $this->HowItWorks->find()->hydrate(false)
                        ->where(['HowItWorks.id =' => $id])->first();
        if (empty($howItWork)) {
            $this->Flash->error(__('Record not found!'));
            return $this->redirect(['controller' => 'HowItWorks', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('howItWork'));

        if ($this->request->is('post')) {
            $homes = $this->HowItWorks->get($id);
            $this->HowItWorks->patchEntity($homes, $this->request->data, ['validate' => 'Default']);
            if (!$homes->errors()) {
                $success = $this->HowItWorks->save($homes);
                if ($success) {
                    $this->_updatedBy('HowItWorks', $success->id);
                    /* === Added by vipin for  add log=== */
                    $message = 'How It Works updated by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'how_it_works';
                    $saveActivityLog['module_name'] = 'How It Works';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */
                    $this->Flash->success(__('How it works page has been updated successfully.'));
                    return $this->redirect(['controller' => 'HowItWorks', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('How it works  page could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($homes->errors())));
            }
        }
    }

    /*
     * Function: view()
     *  Description:  use for view of data How it work on Home ages
     *  @param type: $id
     * By @Ahsan Ahamad
     * Date : 29th Jan. 2017
     */

    public function view($id = null) {
        $pageTitle = 'View How It Work';
        $pageHedding = 'View How It Work';
        $breadcrumb = array(
            array('label' => 'Manage Website', 'link' => 'homePages/'),
            array('label' => 'View How It Work'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $id = $this->Encryption->decode($id);
        $howItWork = $this->HowItWorks->find()->hydrate(false)
                        ->where(['HowItWorks.id =' => $id])->first();
        if (empty($howItWork)) {
            $this->Flash->error(__('Record not found!'));
            return $this->redirect(['controller' => 'HowItWorks', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('howItWork'));
    }

}
