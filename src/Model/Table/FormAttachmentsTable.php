<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FormAttachmentsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('form_attachments');
        
        $this->hasMany('FormAttachmentSamples', [
          'className' => 'FormAttachmentSamples',
          'foreignKey' => 'form_attachment_id'
        ]);
        
    }

    
    

}

?>
