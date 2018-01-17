<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class AgenciesController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamad
     * Date : 1st Nov. 2017
     */

    public function initialize() {

        parent::initialize();

        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * Function:index()
     * Description: use for listing of data agencies
     * By @Ahsan Ahamad
     * Date : 13th Dec. 2017
     */

    public function index() {

        $pageTitle = 'Agencies';
        $pageHedding = 'Agencies';
        $breadcrumb = array(
            array('label' => 'Agencies'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Categories');
        $agencies = $this->Categories->find()->where(['Categories.is_active' => 1, 'Categories.is_deleted' => 0])->all();


        $this->set(compact('agencies'));
    }

    /*
     * Function:details
     * Description: Use for get agency details of the agency
     * @param type $id
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function details($id = null) {
        $pageTitle = 'Agencies | Details';
        $pageHedding = 'Agencies | Details';
        $breadcrumb = array(
            array('label' => 'Agencies | Details'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $id = $this->Encryption->decode($id);
        $this->loadModel('Categories');
        $agency = $this->Categories->find()->where(['Categories.is_active' => 1, 'Categories.is_deleted' => 0, 'Categories.id' => $id])->first();

        $this->set(compact('agency'));
    }

}
