<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;

class LocationHelper extends Helper {

    /**
     * 
     * @param type $locationId
     * @return boolean
     */
    public function countOperationByLocationId($locationId) {
        $this->LocationOperations = TableRegistry::get('LocationOperations');
        return $this->LocationOperations->countOperationByLocationId($locationId);
    }
    
    /**
     * 
     * @param type $locationId
     * @return boolean
     */
    public function getOperationListByLocationId($locationId) {
        $this->LocationOperations = TableRegistry::get('LocationOperations');
        return $this->LocationOperations->getOperationListByLocationId($locationId);
    }    

}

?>