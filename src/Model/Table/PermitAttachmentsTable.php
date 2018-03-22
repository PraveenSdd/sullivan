<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitAttachmentsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_attachments');
    }
 public function validationUploadPermitAttachment(Validator $validator) {
        $validator
                ->notEmpty('form_attachment', 'Please upload permit');
        return $validator;
    }
    
}

?>
