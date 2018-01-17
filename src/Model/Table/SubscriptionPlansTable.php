<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubscriptionPlansTable extends Table {
    
public function initialize(array $config)
    {
        $this->setTable('subscription_plans');
        
          $this->hasMany(
            'Attributes', [
            'className' => 'SubscriptionPlanAttributes',
            'foreignKey' => 'subscription_plan_id'
            ]);
    }
    
    public function validationEdit(Validator $validator) {
        $validator = new Validator();
            $validator->notEmpty('name', 'Please upload form');
            $validator->notEmpty('description', 'Please upload form');
        return $validator;
    }
    
    

}

?>
