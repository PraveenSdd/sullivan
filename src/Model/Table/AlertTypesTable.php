<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertTypesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_types');
    }
    
    /**
     * 
     * @return type
     */
    public function getAlertType(){
        $alertTypes = $this->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_admin' => 1,'AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        return $alertTypesList;
    }
    
    public function getCompanyAlertType(){
        $alertTypes = $this->find('list');
        $alertTypes->hydrate(false)->where(['AlertTypes.is_company' => 1,'AlertTypes.is_deleted' => 0, 'AlertTypes.is_active' => 1]);
        $alertTypesList = $alertTypes->toArray();
        return $alertTypesList;
    }

}

?>
