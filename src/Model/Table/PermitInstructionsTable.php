<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitInstructionsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_instructions');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->notEmpty('name', 'Please enter name');
        return $validator;
    }
    
    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getDataByPermitId($permitId){
        return $this->find()->where(['PermitInstructions.permit_id' => $permitId, 'PermitInstructions.is_active' => 1, 'PermitInstructions.is_deleted' => 0])->all();
    }

}

?>
