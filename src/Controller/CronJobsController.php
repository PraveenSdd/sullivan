<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class CronJobsController extends AppController {
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['alerts']);
    }

/* alerts function use for cron job by date
 *  Develop By @Ahsan Ahamad
 * Date : 2rd jan. 2018
*/    
    
    public function alerts(){
        $this->autoRender = false;
        $this->loadModel('Alerts');
        $this->loadModel('Users');
        $this->loadModel('Users');
        $this->loadModel('Users');
        $this->loadModel('Users');
        $todayDate = date('Y-m-d');
        $alerts = $this->Alerts->find()->select(['user_id','alert_type_id','notes'])->where(['Alerts.date'=>$todayDate,'is_completed'=>0])->all();
         $toEmial = array();
         $templateId = 10;
        foreach($alerts as $alert){
            $alertYprId = $alert->alert_type_id;
            $userId = $alert->user_id;
      
        switch ($alertYprId) {
            
/*Persnal alert*/  
          case 1:
                $poersnal = $this->Users->find()->select(['email','first_name'])->where(['Users.id'=>$userId])->first();              $to =  $poersnal->email;
                $data = array('name'=>$poersnal->first_name, 'notes'=>$alert->notes);
                $this->sendEmail($data, $to, $templateId);
            break;
        
/*Sullivan PC alert*/  
        
            case 2:
                $admin =  $this->Users->find()->select(['email','first_name'])->where(['Users.user_id'=>$userId])->first();
                $to =  $admin->email;
                $data = array('name'=>$admin->first_name, 'notes'=>$alert->notes);
                $this->sendEmail($data, $to, $templateId);
                break;
            
/*Company alert*/   
            
            case 3:
                
                $admin =  $this->Users->find()->select(['email','first_name','role_id'])->where(['Users.id'=>$userId])->first();
                if($admin->role_id == 1){
                  $companies =  $this->Users->find('list')->where(['Users.role_id'=>2])->first();
                    prx($companies);

                }
                $to =  $admin->email;
                $data = array('name'=>$admin->first_name, 'notes'=>$alert->notes);
                $this->sendEmail($data, $to, $templateId);
                break;
            case 4:
                
                break;
            default:
        }
       
       
        }    
       
       
       
       
        prx($toEmial);
      exit;
        
        
    }
}
