<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class CustomsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->Auth->allow(['login']);
    }
    
/*@Function: changeStatus()
* @Description: function use for common change status all the module
* @param: $id module id,
* @param: $status id,
* @param: $module name,
* @By @Ahsan Ahamad
* @Date : 23rd Nov. 2017
*/ 
    public function changeStatus() {
        $this->autoRender = FALSE;
        $userId = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $model = $this->request->data['model'];
            $title = $this->request->data['title'];
           $this->loadModel($model);
           $articles = TableRegistry::get(''.$model.'');
           $id= $this->request->data['id'];
           $status = $this->request->data['newStatus'];
           $categories = $this->$model->get($id);
           $query = $articles->query();
           $update = $query->update()
               ->set(['is_active' => $status])
               ->where(['id' => $id])
               ->execute();
           if($update == true){
               $this->Flash->success(__($title.' status has been change successfully.'));
             $data =['success'=>'success','status'=>$status];
           }else{
               $this->Flash->error(__($title.' status could not been changed.'));
                 $data =['success'=>'error','status'=>$status];
           }
        }
        
        echo json_encode($data);
    }
    
/*@Function: deleteStatus()
* @Description: function use for common delete data all the module
* @param: $id module id,
* @param: $module name,
* @By @Ahsan Ahamad
* @Date : 23rd Nov. 2017
*/ 
    
    public function deleteStatus() {
        $this->autoRender = FALSE;
        $userId = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $model = $this->request->data['model'];
            $title = $this->request->data['title'];
            if(!empty($title)){
                $msg = $title;
            }else{
                $msg = $model;
            }
           $this->loadModel($model);
           $articles = TableRegistry::get(''.$model.'');
           $id= $this->request->data['id'];
           $categories = $this->$model->get($id);
           $query = $articles->query();
           $update = $query->update()
               ->set(['is_deleted' => 1])
               ->where(['id' => $id])
               ->execute();
           if($update == true){
              $this->Flash->success(__("'" .$msg."' has been deleted successfully."));

             $data =['success'=>'success','status'=>$status];
           }else{
                  $this->Flash->success(__("'" .$msg."' has been deleted successfully."));
                 $data =['success'=>'error','status'=>$status];
           }
        }
        
        echo json_encode($data);
    }

}
