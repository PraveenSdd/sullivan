<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AddressesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('addresses');
        
         $this->belongsTo('States', [
            'className' => 'States',
            'foreignKey' => 'state_id'
        ]);
    }
/*
 * Function: validationAdd()
 * desription: Validation for add agency address
 * By:Ahsan Ahamad
 * Date: 12th Jan 2018
 */    

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('address1', 'Title cannot be empty')
                ->notEmpty('city', 'City cannot be empty')
                ->notEmpty('state_id', 'State cannot be empty')
                ->notEmpty('zipcode', 'Zip code cannot be empty');
                //->notEmpty('phone', 'Phone number cannot be empty');
        return $validator;
    }

    
}

?>
