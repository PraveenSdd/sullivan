<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserLocationsTable extends Table {

    public function initialize(array $config)
    {
        $this->setTable('user_locations');
        
        $this->belongsTo('States', [
            'className' => 'States',
            'foreignKey' => 'state_id'
        ]);
        
        $this->belongsTo('Country', [
            'className' => 'Countries',
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('LocationIndustries', [
            'className' => 'LocationIndustries',
            'foreignKey' => 'user_location_id',
        ]);
        
    }
    
    public function validationAdd(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('title', 'Please enter a title')
                ->notEmpty('address1', 'Please enter a address')
               // ->notEmpty('state_id', 'Please select a state')
                ->notEmpty('email', 'Please enter a email')
                ->notEmpty('phone', 'Please enter a phone');
        return $validator;
    }

    /**
    * return number of location added by company
    */
    public function getCountByUserId($userId){
        return $this->find()->where(['is_deleted' => 0,'user_id' => $userId])->count();        
    }


}

?>
