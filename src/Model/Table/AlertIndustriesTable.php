<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertIndustriesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_industries');
        
        $this->belongsTo(
            'Industries', [
            'className' => 'Industries',
            'foreignKey' => 'industry_id'
            ]
        );
        $this->belongsTo('Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id'
        ]);
    }

  

}

?>
