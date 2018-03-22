<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class PageLabelsController extends AppController {
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
        $pageTitle = 'Manage Page Labels';
        $pageHedding = 'Manage Page Labels';
        $breadcrumb = array(
            array('label' => 'Manage Page Labels'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->paginate = [
            'contain' => ['Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'order' => ['PageLabels.id' => 'asc'],
            'limit' => $this->paginationLimit,
        ];
        $pageLabelList = $this->paginate($this->PageLabels);
        $this->set(compact('pageLabelList'));
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
        $pageTitle = 'Edit Page Label';
        $pageHedding = 'Edit Page Label';
        $breadcrumb = array(
            array('label' => 'Manage Page Labels', 'link' => 'pageLabels/'),
            array('label' => 'Edit Page Label'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $pageLabel = $this->PageLabels->find()->hydrate(false)
                        ->where(['PageLabels.id =' => $id])->first();
        if (empty($pageLabel)) {
            $this->Flash->error(__('Record not found!'));
            return $this->redirect(['controller' => 'pageLabels', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('pageLabel'));

        if ($this->request->is('post')) {
            $homes = $this->PageLabels->get($id);
            $this->PageLabels->patchEntity($homes, $this->request->data, ['validate' => 'Default']);
            if (!$homes->errors()) {
                $success = $this->PageLabels->save($homes);
                if ($success) {
                    $this->_updatedBy('PageLabels', $success->id);
                    /* === Added by vipin for  add log=== */
                    $message = 'Page Labels updated by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'page_labels';
                    $saveActivityLog['module_name'] = 'Page Labels';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */
                    $this->Flash->success(__('Page label has been updated successfully.'));
                    return $this->redirect(['controller' => 'pageLabels', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Page label could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($homes->errors())));
            }
        }
    }

}
