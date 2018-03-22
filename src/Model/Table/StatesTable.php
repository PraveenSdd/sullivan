<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatesTable extends Table {    
    function initialize(array $config) {
        parent::initialize($config);        
        $this->setTable('states');
        
         $this->hasOne('Addresses', [
            'className' => 'Addresses',
            'foreignKey' => 'state_id'
        ]);
    }
    
    /**
     * 
     * @return array list
     */
    public function getList() {
        $stateList = $this->find('list', ['valueField' => 'name']);
        $stateList->hydrate(false)->select(['States.name'])->where(['States.is_deleted' => 0, 'States.is_active' => 1]);
        return $stateList->toArray();
    }
    
    /**
     * 
     * @param int $countryId
     * @return array list
     */
    public function getListByCountryId($countryId) {
        $stateList = $this->find('list', ['valueField' => 'name']);
        $stateList->hydrate(false)->select(['States.name'])->where(['States.country_id' => $countryId,'States.is_deleted' => 0, 'States.is_active' => 1]);
        return $stateList->toArray();
    }

}

?>
