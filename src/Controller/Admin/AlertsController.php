<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Model\Table\Users;

class AlertsController extends AppController {
    /*
     * $paginate is use for ordering and limit data from data base
     * By @Ahsan Ahamads
     * Date : 2nd Nov. 2017
     */

    public $paginate = [
        'limit' => 5,
        'order' => [
            'Alerts.tile' => 'asc'
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
     * @Description: use for listing of alerts
     * By @Ahsan Ahamad
     * Date : 2rd Nov. 2017
     */


    public function index() {
        $pageTitle = 'Alerts';
        $pageHedding = 'Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Alerts');
        $conditions = ['Alerts.is_deleted' => 0];
      // prx($_GET);
        if (@$this->request->query['title'] != '' && @$this->request->query['status'] != '') {
            $conditions = ['Alerts.is_deleted' => 0, 'Alerts.title LIKE' => '%' . $this->request->query['title'] . '%', 'Alerts.is_active' => $this->request->query['status']];
            
        } else if (@$this->request->query['title'] != '') {
            $conditions = ['Alerts.is_deleted' => 0, 'Alerts.title LIKE' => '%'. $this->request->query['title'].'%'];
           
        } else if (@$this->request->query['status'] != '') {
               $conditions = ['Alerts.is_deleted' => 0, 'Alerts.is_active' => $this->request->query['status']];
        } 
        if($this->request->query){
            $this->request->data = $this->request->query;
        }
        $this->paginate = [
                'conditions' =>$conditions,
                'order' => ['Alerts.title' => 'asc'],
                 'limit' => 10,
            ];
        $alerts = $this->paginate($this->Alerts);

        $this->set(compact('alerts'));
    }
    
    
/*
 * @Function: Add()
 * @Description: use for create new alerts 
 * @By @Ahsan Ahamad
 * @Date : 23rd Nov. 2017
*/

    
    public function add() {
        $pageTitle = 'Alerts | Add';
        $pageHedding = 'Add Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'faqs/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb','pageTitle','pageHedding'));
        if ($this->request->is('post')) {
                $this->loadModel('AlertIndustries');
                $this->loadModel('AlertCompanies');
                $this->loadModel('AlertStaffs');
                $this->loadModel('Users');

                $this->request->data['title'] = ucfirst($this->request->data['title']);
                $this->request->data['date'] = date('Y-m-d',strtotime( $this->request->data['date']));
            $this->request->data['user_id'] = $this->Auth->user('id');
            if(!empty($this->request->data['interval'])){
                $this->request->data['interval_alert'] = (int)$this->request->data['interval'];
            }
            $alerts = $this->Alerts->newEntity();
            $this->Alerts->patchEntity($alerts, $this->request->data,['validate' => 'Add']); 
            if (!$alerts->errors()) {
                $success = $this->Alerts->save($alerts);
               
                if($success){
/* code for save alert company */    
                    if(!empty($this->request->data['company_id']) && $this->request->data['alert_type_id']==3){
                       
                     foreach($this->request->data['company_id'] as $key=>$value){
                         $company = $this->Users->find()->contain(['Employees'])->select(['Users.email','Users.id'])->where(['Users.id'=>$value])->first();
                         $emails[] = $company->email;
                         foreach($company->employees as $employee){
                              $emails[] = $employee->email;
                         }
                         
                       
                         $company['company_id'] = $value;
                         $company['created'] = date('Y-m-d');
                         $company['alert_id'] = $success->id;
                         $company['alert_type_id'] =$this->request->data['alert_type_id'];
                         $companies = $this->AlertCompanies->newEntity();
                         $this->AlertCompanies->patchEntity($companies, $company); 
                         $successAlert = $this->AlertCompanies->save($companies);
                     }
                     if($successAlert){
/* code for send email to multiple users and companies */
                     //   $data = array('token' => $token, 'name' => $user['first_name']);
                        $template = 'new_alert';
                        $subject ="New Alerts";
                        $this->Custom->sendMultipleEmail($emails, $template,$subject);
                     }
                
                }
/* code for save alert Staff */    
                    if(!empty($this->request->data['staff_id']) && $this->request->data['alert_type_id']==2){
                        
                        foreach($this->request->data['staff_id'] as $key=>$value){
                         $staff['user_id'] = $value;
                         $staff['created'] = date('Y-m-d');
                         $staff['alert_id'] = $success->id;
                         $staff['alert_type_id'] =$this->request->data['alert_type_id'];
                         $staffs = $this->AlertStaffs->newEntity();
                         $this->AlertStaffs->patchEntity($staffs, $staff); 
                         $successAlert = $this->AlertStaffs->save($staffs);
                     }
                       if($successAlert){
                           $staffs = $this->Users->find('list',['valueField' => 'email']); 
                        $staffs->hydrate(false)->select(['Users.email'])->where(['Users.id in'=>$this->request->data['staff_id'],'Users.is_deleted'=>0,'Users.is_active'=>1]);
                        $emails = $staffs->toArray();
/* code for send email to multiple users and companies */
                     // $data = array('token' => $token, 'name' => $user['first_name']);
                        $template = 'new_alert';
                        $subject ="New Alerts";
                        $this->Custom->sendMultipleEmail($emails, $template,$subject);
                     }
                }
/* code for save alert industry */
                if(!empty($this->request->data['industry_id']) && $this->request->data['alert_type_id']== 4){
                    foreach($this->request->data['industry_id'] as $key=>$value){
                        $industry['industry_id'] = $value;
                         $industry['created'] = date('Y-m-d');
                         $industry['alert_id'] = $success->id;
                         $industry['alert_type_id'] = $this->request->data['alert_type_id'];
                         $industryies = $this->AlertIndustries->newEntity();
                         $this->AlertIndustries->patchEntity($industryies, $industry); 
                        $successAlert = $this->AlertIndustries->save($industryies);
                    }

                }
            
                    $this->Flash->success(__('Alerts has been saved successfully.'));
                    return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
                } else{
                    $this->Flash->error(__('Alerts could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($alerts->errors())));
            }
        }
        $this->loadModel('AlertTypes');
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0,'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        $this->loadModel('Users');
        $this->loadModel('Operations');
        $companiesLists = $this->Users->getCompanyList();
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'),4); 
        $industries = $this->Operations->find('list');
        $industries->hydrate(false)->where(['Operations.is_deleted'=>0,'Operations.is_active'=>1]);
        $industriesLists = $industries->toArray();
           
        
        $this->set(compact('alertTypesList','industriesLists','companiesLists','staffLists'));
        
    }
    
/*
 * @Function: edit()
 * @Description: Function use for edit of the alerts 
 * @param: $id of alert
  *@return: edited value 
 * @By @Ahsan Ahamad
 * @Date : 23rd Nov. 2017
*/
    
    
    public function edit($id=null) {
        $pageTitle = 'Alerts | Edit';
        $pageHedding = 'Edit';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'faqs/'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb','pageTitle','pageHedding'));
         $this->loadModel('AlertIndustries');
            $this->loadModel('AlertCompanies');
               $this->loadModel('AlertStaffs');
        if ($this->request->is('post')) {
          
            $this->request->data['title'] = ucfirst($this->request->data['title']);
            $this->request->data['date'] = date('Y-m-d',strtotime( $this->request->data['date']));
            $this->request->data['user_id'] = $this->Auth->user('id');
            $alerts = $this->Alerts->newEntity();
            $this->Alerts->patchEntity($alerts, $this->request->data,['validate' => 'Add']); 
            if (!$alerts->errors()) {
                if($success = $this->Alerts->save($alerts)){
/* code for save alert company */                    
                if(!empty($this->request->data['company_id']) && $this->request->data['alert_type_id']==3){
/* if change company to industry then delete all alert company data*/
                if(!empty($this->request->data['alert_industries_id'])){
                    $conditionSample = array('AlertIndustries.id in' => $this->request->data['alert_industries_id']);
                    $this->AlertIndustries->deleteAll($conditionSample, false);
                }
                     foreach($this->request->data['company_id'] as $key=>$value){
                         $company['company_id'] = $value;
                         $company['created'] = date('Y-m-d');
                         $company['alert_id'] = $success->id;
                         $company['alert_type_id'] =$this->request->data['alert_type_id'];
                        
                        $companies = $this->AlertCompanies->newEntity();
                         $this->AlertCompanies->patchEntity($companies, $company); 
                         $this->AlertCompanies->save($companies);
                     }
                
                }
/* code for save alert $staff */                    
                if(!empty($this->request->data['staff_id']) && $this->request->data['alert_type_id']==2){
                    if(!empty($this->request->data['alert_staff_id'])){
                     $conditionstaff = array('AlertStaffs.id in' => $this->request->data['alert_staff_id']);
                    $delStaff = $this->AlertStaffs->deleteAll($conditionstaff, false);
                    }
                   
                     foreach($this->request->data['staff_id'] as $key=>$value){
                         $staff['user_id'] = $value;
                         $staff['created'] = date('Y-m-d');
                         $staff['alert_id'] = $success->id;
                         $staff['alert_type_id'] =$this->request->data['alert_type_id'];
                         
/* if change $staff to industry then delete all alert $staff data*/
                        $staffs = $this->AlertStaffs->newEntity();
                         $this->AlertStaffs->patchEntity($staffs, $staff); 
                         $this->AlertStaffs->save($staffs);
                     }
                
                }
/* code for save alert industry */  
                if(!empty($this->request->data['industry_id']) && $this->request->data['alert_type_id']== 4){
/* if change company to industry then delete all alert company data*/
                    if(!empty($this->request->data['alert_companies_id'])){
                    $conditionSample = array('AlertCompanies.id in' => $this->request->data['alert_companies_id']);
                    $this->AlertCompanies->deleteAll($conditionSample, false);
                    }
                    foreach($this->request->data['industry_id'] as $key=>$value){
                        $industry['industry_id'] = $value;
                         $industry['created'] = date('Y-m-d');
                         $industry['alert_id'] = $success->id;
                         $industry['alert_type_id'] = $this->request->data['alert_type_id'];
                                                    
                        
                            $industryies = $this->AlertIndustries->newEntity();
                         $this->AlertIndustries->patchEntity($industryies, $industry); 
                         $this->AlertIndustries->save($industryies);
                    }
                }
            
                    
                    $this->Flash->success(__('Alerts has been updated successfully.'));
                    return $this->redirect(['controller' => 'alerts', 'action' => 'index', 'prefix' => 'admin']);
                } else{
                    $this->Flash->error(__('Alerts could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($alerts->errors())));
            }
        }
        
        $this->loadModel('AlertTypes');
        $this->loadModel('Operations');
        $this->loadModel('Users');
        
        $alertTypes = $this->AlertTypes->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_deleted' => 0,'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        
        $staffLists = $this->Users->getStaffList($this->Auth->user('id'),4); 
        $this->set(compact('alertTypesList','staffLists'));
        $id = $this->Encryption->decode($id);
          
           $alert = $this->Alerts->find()->contain(['AlertTypes','AlertStaffs','AlertIndustries','AlertIndustries','AlertCompanies'])->where(['Alerts.id ='=> $id,'Alerts.is_active ='=> 1,'Alerts.is_deleted ='=> 0])->first();
                $this->loadModel('Users');
                $companiesLists = $this->Users->getCompanyList();
                $operations= $this->Operations->find('list');
                $operations->hydrate(false)->where(['Operations.is_deleted'=>0,'Operations.is_active'=>1]);
                $operationsLists = $operations->toArray();
           
           
            $this->set(compact('alert','companiesLists','operationsLists'));
    }

/*@Function: view()
* @Description: function use for view particular alert
* @param: $id if the alert
* @By @Ahsan Ahamad
* @Date : 23rd Nov. 2017
*/ 
    
    public function view($id = null) {
       $pageTitle = 'Alerts | View';
        $pageHedding = 'View Alerts';
        $breadcrumb = array(
            array('label' => 'Alerts', 'link' => 'faqs/'),
            array('label' => 'View'),
            );
         $this->set(compact('breadcrumb','pageTitle','pageHedding'));    
        $id = $this->Encryption->decode($id);
        $alert = $this->Alerts->find()->contain(['AlertTypes','AlertStaffs','AlertStaffs.Users','AlertIndustries','AlertIndustries.Industries','AlertCompanies','AlertCompanies.Users'])->where(['Alerts.id ='=> $id,'Alerts.is_active ='=> 1,'Alerts.is_deleted ='=> 0])->first();

        $this->set(compact('alert'));
    }
    
/*@Function: getAlertList()
* @Description: function use for all alerts lising 
* @param: $id if the alert
* @By @Ahsan Ahamad
* @Date : 23rd Nov. 2017
*/ 
    
    public function getAlertList(){
        $this->loadModel('Categories');
        $this->loadModel('Industries');
        $this->autoRender = FALSE;
        $id = $this->request->data['id'];
            if($id == 3){
                $this->loadModel('Users');
                $lists = $this->Users->getCompanyList();
                 $listHtml = '<option value="">-- Select Companies -- </option>';
            }
            if($id == 4){
                $industries = $this->Industries->find('list');
                $industries->hydrate(false)->where(['Industries.is_deleted'=>0,'Industries.is_active'=>1]);
                $lists = $industries->toArray();
                $listHtml = '<option value="">-- Select Industries -- </option>';
            }
        
            $listArray = array();

            foreach ($lists as $key => $value) {
                $listHtml .='<option value="' . $key . '">' . $value . '</option>';
                $listArray[$key] = $value;
            }
            echo $listHtml;
           exit;
    }
    


}
