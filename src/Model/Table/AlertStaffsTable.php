<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertStaffsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_staffs');
         $this->belongsTo(
            'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
            ]
        );
    }
}

?>
