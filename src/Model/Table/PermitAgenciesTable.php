<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitAgenciesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_agencies');
        
        $this->belongsTo('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'agency_id'
        ]);
        $this->belongsTo('AgencyContacts', [
            'className' => 'AgencyContacts',
            'foreignKey' => 'agency_contact_id'
        ]);
        $this->belongsTo('Forms', [
            'className' => 'Forms',
            'foreignKey' => 'form_id'
        ]);
    }

    
    
    

}

?>
