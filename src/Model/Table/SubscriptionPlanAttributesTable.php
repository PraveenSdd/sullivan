<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubscriptionPlanAttributesTable extends Table {
    
public function initialize(array $config)
    {
        $this->setTable('subscription_plan_attributes');
        
          $this->belongsTo(
            'Plans', [
            'className' => 'SubscriptionPlans',
            'foreignKey' => 'subscription_plan_id'
            ]);
    }
    
    public function validationEdit(Validator $validator) {
        $validator = new Validator();
            $validator->notEmpty('attribute', 'Please upload form');
        return $validator;
    }
    
    

}

?>
