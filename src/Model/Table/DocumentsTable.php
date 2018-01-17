<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DocumentsTable extends Table {
    
  
public function initialize(array $config)
    {
        $this->setTable('form_documents');
        
        $this->hasMany('FormDocumentSamples', [
          'className' => 'FormDocumentSamples',
          'foreignKey' => 'form_document_id'
        ]);
    }
    
    public function validationAdd(Validator $validator) {
        $validator = new Validator();
            $validator->notEmpty('category_id', 'Please enter category id');
        return $validator;
    }

}

?>
