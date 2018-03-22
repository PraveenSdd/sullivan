<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class OperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('operations');

        $this->hasMany('PermitOperations', [
            'className' => 'PermitOperations',
            'foreignKey' => 'operation_id',
            'conditions' => ['PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0]
        ]);
        $this->hasMany('AlertOperations', [
            'className' => 'AlertOperations',
            'foreignKey' => 'operation_id',
            'conditions' => ['AlertOperations.is_active' => 1, 'AlertOperations.is_deleted' => 0]
        ]);
        $this->hasMany('LocationOperations', [
            'className' => 'LocationOperations',
            'foreignKey' => 'operation_id',
            'conditions' => ['LocationOperations.is_active' => 1, 'LocationOperations.is_deleted' => 0]
        ]);
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );
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
     * buildRules() use for check Unique agency/category
     * By @Ahsan Ahamad
     * Date : 13th Jan. 2018
     */

// public function buildRules(RulesChecker $rules){
//        
//        $rules->add($rules->isUnique(['name'], 'Operation name already exits'));
//         
//        return $rules;
//    }
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

    /**
     * 
     * @param type $operationId
     */
    public function getOperation($operationId = null) {
        $operation = $this->Operations->find()->contain(['PermitOperations', 'PermitOperations.Forms', 'AlertOperations', 'AlertOperations.Alerts'])->where(['Operations.id =' => $operationId])->first();
    }

    /**
     * 
     * @return type
     */
    public function getList() {
        $operations = $this->find('list', ['valueField' => 'name']);
        $operations->hydrate(false)->select(['Operations.name'])->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1]);
        return $operations->toArray();
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getListById($operationId) {
        $operations = $this->find('list', ['valueField' => 'name']);
        if (is_array($operationId)) {
            $operations->hydrate(false)->select(['Operations.name'])->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1, 'Operations.id IN' => $operationId]);
        } else {
            $operations->hydrate(false)->select(['Operations.name'])->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1, 'Operations.id' => $operationId]);
        }
        return $operations->toArray();
    }

    /**
     * 
     * @param int $permitId
     * @param int $operationId
     * @return array list
     */
    public function getUnAssignedOperationList($permitId, $operationId = null) {
        $this->PermitOperations = TableRegistry::get('PermitOperations');
        $assignOperationList = $this->PermitOperations->getAssignedOperationListByPermitId($permitId);
        $operationList = $this->find('list');
        if ($operationId) {
            unset($assignOperationList[$operationId]);
        }
        if (!empty($assignOperationList)) {
            $operationList->hydrate(false)->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1, 'NOT' => ['Operations.id IN' => $assignOperationList]]);
        } else {
            $operationList->hydrate(false)->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1]);
        }
        return $operationList->toArray();
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getOperationListById($operationId = null) {
        $operations = $this->find('list', ['keyField' => 'id', 'valueField' => 'name']);
        $operations->hydrate(false)->select(['Operations.id', 'Operations.name'])->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1, 'Operations.id IN' => $operationId]);
        return $operations->toArray();
    }

}

?>
