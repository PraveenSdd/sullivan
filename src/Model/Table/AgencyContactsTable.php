<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AgencyContactsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('agency_contacts');
        
         $this->hasMany('Addresses', [
            'className' => 'Addresses',
            'foreignKey' => 'agency_contact_id'
        ]);
    }
    
    
    
}

?>
