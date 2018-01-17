<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FormAgenciesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('form_agencies');
        
        $this->belongsTo('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id'
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
