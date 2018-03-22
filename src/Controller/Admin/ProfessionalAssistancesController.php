<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class ProfessionalAssistancesController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamads
     * Date : 2nd Nov. 2017
     */

    public $paginate = [
        'limit' => 5,
        'order' => [
            'ProfessionalAssistances.tile' => 'asc'
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
     * Description: get all professional list
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'Helps';
        $pageHedding = 'Helps';
        $breadcrumb = array(
            array('label' => 'Helps'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $conditions = ['ProfessionalAssistances.is_deleted' => 0];
        if (@$this->request->query['name'] != '' && @$this->request->query['status'] != '') {
            $conditions = ['ProfessionalAssistances.is_deleted' => 0, 'ProfessionalAssistances.name LIKE' => '%' . $this->request->query['name'] . '%', 'ProfessionalAssistances.is_active' => $this->request->query['status']];
        } else if (@$this->request->query['name'] != '') {
            $conditions = ['ProfessionalAssistances.is_deleted' => 0, 'ProfessionalAssistances.name LIKE' => '%' . $this->request->query['name'] . '%'];
        } else if (@$this->request->query['status'] != '') {
            $conditions = ['ProfessionalAssistances.is_deleted' => 0, 'ProfessionalAssistances.is_active' => $this->request->query['status']];
        }
        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
            'conditions' => $conditions,
            'limit' => 10,
        ];
        $professionalAssistances = $this->paginate($this->ProfessionalAssistances);
        $this->set(compact('professionalAssistances'));
    }

    /* Function: view()
     * Description: function use for view particular get data 
     * @param type: $id
     * By @Ahsan Ahamad
     * Date : 23rd Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'View Help';
        $pageHedding = 'View Help';
        $breadcrumb = array(
            array('label' => 'Helps', 'link' => 'ProfessionalAssistances/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $id = $this->Encryption->decode($id);
        $professionalAssistance = $this->ProfessionalAssistances->find()->where(['ProfessionalAssistances.id =' => $id])->first();

        $this->set(compact('professionalAssistance'));
    }

}
