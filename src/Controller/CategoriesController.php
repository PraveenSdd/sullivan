<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class CategoriesController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamad
     * Date : 1st Nov. 2017
     */

    public $paginate = [
        'limit' => 15,
        'order' => [
            'Assets.name' => 'asc'
        ]
    ];

    public function initialize() {
        parent::initialize();
        if (!$this->request->getParam('admin') && $this->Auth->user('role_id') != 1) {
            return $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     *  @Function:index()
     * @Description: use for agency listing
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function agencies() {
        $pageTitle = 'Agencies';
        $pageHedding = 'Agencies';
        $breadcrumb = array(
            array('label' => 'Agencies'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->paginate = [
            'contain' => ['AgenyIndustries'],
            'conditions' => ['Categories.parent_id' => 0, 'Categories.is_deleted' => 0],
            'limit' => 10,
        ];
        $agencies = $this->paginate($this->Categories);
        $this->set(compact('agencies'));
    }

    /*
     * Function: Add()
     * Description: use for create new records for multile form
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function add() {

        $pageTitle = 'Category | Add';
        $pageHedding = 'Add Category';
        $breadcrumb = array(
            array('label' => 'Category', 'link' => 'categories/index'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));


        if ($this->request->is('post')) {
            $categories = $this->Categories->newEntity();
            $this->request->data['slug'] = strtolower(
                    preg_replace(
                            "![^a-z0-9]+!i", "-", $this->request->data['name']
                    )
            );
            $this->Categories->patchEntity($categories, $this->request->data, ['validate' => 'Add']);
            if (!$categories->errors()) {
                if ($this->Categories->save($categories)) {
                    $this->Flash->success(__('Category has been saved successfully.'));
                    return $this->redirect(['controller' => 'Categories', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Category could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($categories->errors())));
            }
        }
    }

    /* @Function: edit() 
     * @Description: Function use for edit on recorde
     * @param type $id
     * @return type  
     * By @Ahsan Ahamad
     * Date : 22 setp. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Category | Edit';
        $pageHedding = 'Edit Category';
        $breadcrumb = array(
            array('label' => 'Category', 'link' => 'categories/index'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $ecdId = $id;
        $id = $this->Encryption->decode($id);
        $category = $this->Categories->find()->select(['name', 'id', 'short_description'])->where(['Categories.id =' => $id])->first();

        if ($this->request->is(['post', 'put'])) {
            $id = $this->request->data['id'];
            $categories = $this->Categories->get($id);
            $categories = $this->Categories->patchEntity($categories, $this->request->data);
            if (!$categories->errors()) {
                if ($this->Categories->save($categories)) {
                    $this->Flash->success(__('category has been updated successfully.'));
                    return $this->redirect(['controller' => 'Categories', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Category could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($categories->errors())));
            }
        }
        $this->set(compact('category'));
    }

    /* @Function: view() 
     * @Description: Function use for view of the recorde
     * @param type $id
     * @return type  
     * By @Ahsan Ahamad
     * Date : 22 setp. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Category | View';
        $pageHedding = 'View Category';
        $breadcrumb = array(
            array('label' => 'Category', 'link' => 'categories/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $category = $this->Categories->find()->select(['name', 'id', 'short_description'])->where(['Categories.id =' => $id])->first();

        $this->set(compact('category'));
    }

}
