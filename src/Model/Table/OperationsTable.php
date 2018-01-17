<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

    class OperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('operations');
        
        
    }

/*
 * Function: validationAdd()
 * DEscription: use for check validation operation
 * By @Ahsan Ahamad
 * Date : 13th Jan. 2018
 */
    
    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('name', 'Name cannot be empty')
                ->notEmpty('category_id[]', 'Please select agency');
        return $validator;
    }
    
    
/*
 * Function: checkOperationUniqueName()
* Description: use for check Unique operation
 * By @Ahsan Ahamad
 * Date : 11th Jan. 2018
 */
    
    public function checkOperationUniqueName($operationName = null, $operationId = null) {
        $responseFlag = false;
        $conditions = array('LOWER(Operations.name)' => strtolower($operationName), 'Operations.is_deleted' => 0);
        if ($operationId) {
            $conditions['Operations.id !='] = $operationId;
        }
        $operation = $this->find()->select(['name', 'id'])->where($conditions)->first();

        if ($operation) {
            $responseFlag = false;
        } else {
            $responseFlag = true;
        }
        return $responseFlag;
    }

  

}

?>
