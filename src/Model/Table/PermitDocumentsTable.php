<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitDocumentsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_documents');
    }

     public function validationUploadPermit(Validator $validator) {
        $validator
                ->notEmpty('form_documet', 'Please upload permit');
        return $validator;
    }
    
}

?>
