<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertCompaniesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_companies');
        $this->belongsTo(
            'Users', [
            'className' => 'Users',
            'foreignKey' => 'company_id'
            ]
        );
    }

   
}

?>
