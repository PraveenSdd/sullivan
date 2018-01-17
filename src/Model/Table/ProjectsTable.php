<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProjectsTable extends Table {
     function initialize(array $config) {
        parent::initialize($config);
          $this->belongsTo(
            'ProjectDocuments', [
            'className' => 'ProjectDocuments',
            'foreignKey' => 'porject_id'
            ]
        
        );
        
          
    }

     public function validationCreate(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('title', 'Please enter title');
        $validator->notEmpty('description', 'Please enter description');
        return $validator;
    }
    
    
}

?>
