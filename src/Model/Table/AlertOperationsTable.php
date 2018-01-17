<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertOperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_operations');
        
        $this->belongsTo(
            'Operations', [
            'className' => 'Operations',
            'foreignKey' => 'operation_id'
            ]
        );
        $this->belongsTo('Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id'
        ]);
    }

  

}

?>
