<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alerts');
        
         $this->belongsTo(
            'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
            ]
        );
        $this->belongsTo( 
            'AlertTypes', [
            'className' => 'AlertTypes',
            'foreignKey' => 'alert_type_id'
            ]
        );
       
        $this->hasMany('AlertIndustries', [
          'className' => 'AlertIndustries',
          'foreignKey' => 'alert_id'
        ]);
        $this->hasMany('AlertCompanies', [
          'className' => 'AlertCompanies',
          'foreignKey' => 'alert_id'
        ]);
        
         $this->hasMany('AlertStaffs', [
          'className' => 'AlertStaffs',
          'foreignKey' => 'alert_id'
        ]);
         $this->hasOne('AlertPermits', [
          'className' => 'AlertPermits',
          'foreignKey' => 'alert_id'
        ]);
        
    }

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('title', 'Title cannot be empty')
                ->notEmpty('notes', 'Notes cannot be empty');
        return $validator;
    }

}

?>
