<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class DeadlineTypesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('deadline_types');
    }
    
    /**
     * 
     * @return type
     */
    public function getDeadlineType(){
        $deadlineTypes = $this->find('list');
        $deadlineTypes->hydrate(false)->where(['DeadlineTypes.is_admin' => 1,'DeadlineTypes.is_deleted' => 0, 'DeadlineTypes.is_active' => 1]);
        $deadlineTypesList = $deadlineTypes->toArray();
        return $deadlineTypesList;
    }
    
    public function getCompanyDeadlineType(){
        $deadlineTypes = $this->find('list');
        $deadlineTypes->hydrate(false)->where(['DeadlineTypes.is_company' => 1,'DeadlineTypes.is_deleted' => 0, 'DeadlineTypes.is_active' => 1]);
        $deadlineTypesList = $deadlineTypes->toArray();
        return $deadlineTypesList;
    }

}

?>
