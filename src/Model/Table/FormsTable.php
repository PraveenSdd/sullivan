<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class FormsTable extends Table {

     function initialize(array $config) {
        parent::initialize($config);
        
        $this->belongsTo(
            'Projects', [
            'className' => 'Projects',
            'foreignKey' => 'project_id'
            ]
        
        );
       
        $this->belongsTo(
            'UserLocations', [
            'className' => 'UserLocations',
            'foreignKey' => 'user_location_id'
            ]
        
        );
        
        $this->belongsTo(
            'PermitStatus', [
            'className' => 'PermitStatus',
            'foreignKey' => 'permit_status_id'
            ]
        );
        
        $this->hasOne('FormAttributes', [
        'className' => 'FormAttributes',
        'foreignKey' => 'form_id',
        'joinType' => 'LEFT'
        ]);
        
        $this->hasMany('Documents', [
          'className' => 'Documents',
          'foreignKey' => 'form_id'
        ]);
        
        $this->hasMany('FormAttachmentSamples', [
          'className' => 'FormAttachmentSamples',
          'foreignKey' => 'form_id'
        ]);
        
        $this->hasMany('PermitDeadlines', [
          'className' => 'PermitDeadlines',
          'foreignKey' => 'form_id'
        ]);
        
        $this->hasMany('FormDocumentSamples', [
          'className' => 'FormDocumentSamples',
          'foreignKey' => 'form_id'
        ]);
        
       
        
        $this->hasMany('FormAttachments', [
          'className' => 'FormAttachments',
          'foreignKey' => 'form_id'
        ]);
        
      $this->hasMany('Faqs', [
        'foreignKey' => 'form_id',
        'joinType' => 'LEFT'
    ]);
      
    $this->hasMany('PermitAgencies', [
          'className' => 'PermitAgencies',
        'foreignKey' => 'permit_id',
        'joinType' => 'LEFT'
    ]);
    $this->hasMany('PermitOperations', [
          'className' => 'PermitOperations',
        'foreignKey' => 'permit_id',
        'joinType' => 'LEFT'
    ]);
    $this->hasMany('AlertPermits', [
        'foreignKey' => 'form_id',
        'joinType' => 'LEFT'
    ]);
    $this->hasMany('PermitInstructions', [
        'foreignKey' => 'permit_id',
        'joinType' => 'LEFT'
    ]);
      
      
        
      
        
          
    }
    
    public function validationUpload(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('title', 'Please enter title');
        return $validator;
    }
    
/*
 *  saveDownloadForm() use for save project document on click download form/Permit
 * By @Ahsan Ahamad
 * Date : 27th Nov. 2017
 */
    
    public function saveDownloadForm($id = null,$user_id =null){
        $projectDocuments = TableRegistry::get('ProjectDocuments');
        $formsDetails = $this->find()->select(['id','project_id','category_id','sub_category_id'])->where(['Forms.id =' => $id])->first();
        $projectDocumnet['user_id'] = $user_id;
        if($formsDetails['porject_id']){
             $projectDocumnet['porject_id'] = $formsDetails['porject_id'];
        }
        $projectDocumnet['form_id'] = $formsDetails['id'];
        $projectDocumnet['permit_status_id'] = 2;
        $projectDocumnet['category_id'] = $formsDetails['category_id'];
        $projectDocumnet['sub_category_id'] = $formsDetails['sub_category_id'];
        $projectDocumnetNew = $projectDocuments->newEntity($projectDocumnet);
        $project = $projectDocuments->patchEntity($projectDocumnetNew, $projectDocumnet);
        $success = $projectDocuments->save($projectDocumnetNew);
        if($success){
            return true;
        }else{
            return false;
        }
        
    }
    
    
/*
* getSubCategory() use for get sub category by ajax 
* parameters => $mssageId(hostory action message id),$userId(updated user id), $formId(action id ) 
* By @Ahsan Ahamad
* Date : 27th Nov. 2017
*/
    
    public function addHistory( $mssageId= null, $userId= null, $formId= null){
        
        $projectDocuments = TableRegistry::get('ProjectDocuments');
        $formsDetails = $this->find()->where(['Forms.id =' => $formId])->first();
        
        $FormLogs = TableRegistry::get('FormLogs');
        $log['user_id'] =  $userId;
        $log['form_id'] =  $formId;
        $log['user_id'] =  $userId;
        $log['form_data'] = $data;
        
        $HistoryAdd = $FormLogs->newEntity($log);
        $project = $FormLogs->patchEntity($HistoryAdd, $log);
        $success = $HistoryAdd->save($HistoryAdd);
        
    }
    
    
    public function formDetails($formId = null){
        $formDetails = $this->find()->contain(['Documents','FormDocumentSamples','FormAttachments','FormAttachmentSamples'])->where(['Forms.id'=>$formId])->first();  
           return $formDetails;
        
    }
    
      
    
}

?>
