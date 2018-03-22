<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserLocationsTable extends Table {

    public function initialize(array $config) {
        $this->setTable('user_locations');

        $this->belongsTo('States', [
            'className' => 'States',
            'foreignKey' => 'state_id'
        ]);

        $this->belongsTo('Country', [
            'className' => 'Countries',
            'foreignKey' => 'country_id',
        ]);
        $this->hasMany('LocationOperations', [
            'className' => 'LocationOperations',
            'foreignKey' => 'user_location_id',
        ]);

        /*
          $this->hasMany('LocationIndustries', [
          'className' => 'LocationIndustries',
          'foreignKey' => 'user_location_id',
          ]);
         * 
         */
        
        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
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
    public function getCountByUserId($userId) {
        return $this->find()->where(['is_operation' => 1, 'is_deleted' => 0, 'user_id' => $userId])->count();
    }

    /**
     * 
     * @param type $userId
     * @return type
     */
    public function getDataByUserId($userId) {
        return $this->find()->contain('LocationOperations', 'LocationOperations.Operations')->select(['UserLocations.id', 'UserLocations.title', 'UserLocations.user_id'])->where(array('UserLocations.is_deleted' => 0, 'UserLocations.is_active' => 1, 'UserLocations.user_id' => $userId))->all();
    }

    /**
     * 
     * @param int $userId
     * @return array
     */
    public function getUserLocationListByUserId($userId) {
        $operationList = $this->find('list', ['keyField' => 'id', 'valueField' => 'title']);
        $operationList->hydrate(false)->select(['UserLocations.id','UserLocations.title'])->where(['UserLocations.is_deleted' => 0, 'UserLocations.is_active' => 1, 'UserLocations.user_id' => $userId]);
        return $operationList->toArray();
    }

}

?>
