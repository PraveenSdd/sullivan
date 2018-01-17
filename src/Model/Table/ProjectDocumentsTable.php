<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProjectDocumentsTable extends Table {
    
public function initialize(array $config)
    {
    
        $this->setTable('project_documents');
        
        $this->belongsTo(
            'Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id'
            ]        
        );
        
        $this->belongsTo(
            'SubCategories', [
            'className' => 'Categories',
            'foreignKey' => 'sub_category_id'
            ]
        );
        $this->belongsTo(
            'Projects', [
            'className' => 'Projects',
            'foreignKey' => 'porject_id'
            ]
        );
        $this->belongsTo(
            'Forms', [
            'className' => 'Forms',
            'foreignKey' => 'form_id'
            ]
        );
        
        $this->belongsTo(
            'PermitStatus', [
            'className' => 'PermitStatus',
            'foreignKey' => 'permit_status_id'
            ]
        );
        
         
        
    }
    
    public function validationUpload(Validator $validator) {
        $validator = new Validator();
            $validator->notEmpty('file', 'Please upload form');
        return $validator;
    }
    
    

}

?>
