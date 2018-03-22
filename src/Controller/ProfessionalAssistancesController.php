<?php

namespace App\Controller;

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
        $this->loadComponent('Custom');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * Fuction: index()
     * Description: use for listing of data table
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */

    public function index() {
        $pageTitle = 'Professional Assistances';
        $pageHedding = 'Professional Assistances';
        $breadcrumb = array(
            array('label' => 'ProfessionalAssistances'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->loadModel('ProfessionalAssistances');
        if ($this->request->is('post')) {
            
            $this->request->data['name'] = ucfirst($this->request->data['name']);
            $this->request->data['company_id'] =$this->companyId;
            $this->request->data['user_id'] = $this->Auth->user('id');
            $professionalAssistances = $this->ProfessionalAssistances->newEntity();
            $this->ProfessionalAssistances->patchEntity($professionalAssistances, $this->request->data);
            if (!$professionalAssistances->errors()) {
                if ($this->ProfessionalAssistances->save($professionalAssistances)) {

                    /* code for send email verfication */

                    $data = array('name' => $this->request->data['name'], 'url' => BASE_URL);
                    $to = $this->request->data['email'];
                    $template = 'profession_assistance_confirmation';
                    $subject = 'Profession Assistance confirmation';
                    $send = $this->Custom->sendEmail($data, $to, $template, $subject);
                    /* send email for payment */
                    $superAmin = $this->Custom->superAdminInfo();
                    $data = array('userName' => $this->request->data['name'], 'admin' => $superAmin['first_name'], 'url' => BASE_URL, 'message' => $this->request->data['query']);
                    $to = $superAmin['email'];
                    $template = 'profession_assistance';
                    $subject = $this->request->data['subject'];

                    $send = $this->Custom->sendEmail($data, $to, $template, $subject);


                    $this->Flash->success(__('help has been saved successfully, we are contact as soon as.'));
                    return $this->redirect(['controller' => 'professionalAssistances', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('help could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($professionalAssistances->errors())));
            }
        }
    }

}
