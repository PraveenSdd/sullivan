<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertPermitsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_permits');
         $this->belongsTo(
            'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
            ]
        );
        $this->hasOne(
            'Forms', [
            'className' => 'Forms',
            'foreignKey' => 'form_id'
            ]
        );
        $this->belongsTo(
            'Permits', [
            'className' => 'Forms',
            'foreignKey' => 'form_id'
            ]
        );
        $this->belongsTo(
            'Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id'
            ]
        );
    }
}

?>
