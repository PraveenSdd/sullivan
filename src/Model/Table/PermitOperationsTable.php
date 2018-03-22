<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitOperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_operations');


        $this->belongsTo('Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id',
            'conditions' => ['Permits.is_active' => 1, 'Permits.is_deleted' => 0]
        ]);

        $this->belongsTo('Operations', [
            'className' => 'Operations',
            'foreignKey' => 'operation_id',
            'conditions' => ['Operations.is_active' => 1, 'Operations.is_deleted' => 0]
        ]);
    }

    /**
     * 
     * @param type $operationId
     */
    public function getOperationPermit($operationId = null) {
        $OperationPermitist = $this->find('list', ['keyField' => 'permit_id', 'valueField' => 'permit_id']);
        $OperationPermitist->hydrate(false)->where(['PermitOperations.operation_id' => $operationId]);
        return $OperationPermitist->toArray();
    }

    /**
     * 
     * @return type
     */
    public function getAssignedPermitList() {
        $permitList = $this->find('list', ['keyField' => 'permit_id', 'valueField' => 'permit_id']);
        $permitList->hydrate(false)->where(['PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1]);
        return $permitList->toArray();
    }

    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getAssignedOperationListByPermitId($permitId) {
        $operationList = $this->find('list', ['keyField' => 'operation_id', 'valueField' => 'operation_id']);
        $operationList->hydrate(false)->where(['PermitOperations.permit_id' => $permitId, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1]);
        return $operationList->toArray();
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getAssignedPermitListByOperationId($operationId) {
        if (empty($operationId)) {
            $operationId[] = 0;
        }
        $permitList = $this->find('list', ['keyField' => 'permit_id', 'valueField' => 'permit_id']);
        $permitList->hydrate(false)->where(['PermitOperations.operation_id IN' => $operationId, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1]);
        return $permitList->toArray();
    }

    /**
     * 
     * @param type $permitId
     * @param type $operationId
     * @return type
     */
    public function getIdByPermitAndOperationId($permitId, $operationId) {
        $permitOperationId = null;
        $permitOperationData = $this->find()->hydrate(false)->select(['PermitOperations.id'])->where(['PermitOperations.permit_id' => $permitId, 'PermitOperations.operation_id' => $operationId, 'PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0])->first();
        if ($permitOperationData) {
            $permitOperationId = $permitOperationData['id'];
        }
        return $permitOperationId;
    }

    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getDataByPermitId($permitId) {
        return $this->find()->contain(['Operations'])->where(['PermitOperations.permit_id' => $permitId, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1])->all();
    }

    /**
     * 
     * @param type $operationIds
     * @return type
     */
    public function getDataByOperationId($operationIds) {
        if (count($operationIds) > 1) {
            return $this->find()->contain(['Permits', 'Permits.PermitAgencies.Agencies'])->where(['PermitOperations.operation_id IN' => $operationIds, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1])->all();
        } else {
            return $this->find()->contain(['Permits', 'Permits.PermitAgencies.Agencies'])->where(['PermitOperations.operation_id' => $operationIds, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1])->all();
        }
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getOperationListByOperationId($operationId) {
        $operationList = $this->find('list', ['keyField' => 'operation_id', 'valueField' => 'operation_id']);
        if (empty($operationId)) {
            $operationId[] = 0;
        }
        $operationList->hydrate(false)->where(['PermitOperations.operation_id IN' => $operationId, 'PermitOperations.is_deleted' => 0, 'PermitOperations.is_active' => 1]);
        return $operationList->toArray();
    }

}

?>
