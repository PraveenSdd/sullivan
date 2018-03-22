<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class AlertOperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_operations');

        $this->belongsTo(
                'Operations', [
            'className' => 'Operations',
            'foreignKey' => 'operation_id',
                ]
        );

        $this->belongsTo('Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id',
        ]);
    }

    /**
     *      
     * @param type $alertId
     * @param array $data
     * 
     */
    public function saveData($alertId, $data) {
        foreach ($data as $key => $value) {
            $alertOperation = [];
            $alertOperation['alert_id'] = $alertId;
            $alertOperation['operation_id'] = $value;
            $alertOperation['is_active'] = 1;
            $alertOperation['is_deleted'] = 0;
            $alertOperation['id'] = $this->getIdByAlertAndOperationId($alertOperation['alert_id'], $alertOperation['operation_id']);

            $alertOperations = [];
            if (!empty($alertOperation['id'])) {

                $alertOperations = $this->get($alertOperation['id']);
            } else {
                $alertOperation['added_by'] = Configure::read('LoggedUserId');
                $alertOperations = $this->newEntity();
            }
            $alertOperations = $this->patchEntity($alertOperations, $alertOperation);
            $this->save($alertOperations);
        }
    }

    /**
     * 
     * @param int $alertId
     * @param int $operationId
     * @return null/int
     */
    public function getIdByAlertAndOperationId($alertId, $operationId) {
        $alertOperationId = null;
        $alertOperationData = $this->find()->hydrate(false)->select(['AlertOperations.id'])->where(['AlertOperations.alert_id' => $alertId, 'AlertOperations.operation_id' => $operationId])->first();
        if ($alertOperationData) {
            $alertOperationId = $alertOperationData['id'];
        }
        return $alertOperationId;
    }

    /**
     * 
     * @param type $alertId
     * @return type
     */
    public function getOperationIdByAlertId($alertId) {
        $operationList = $this->find('list', ['valueField' => 'operation_id']);
        $operationList->hydrate(false)->select(['AlertOperations.operation_id'])->where(['AlertOperations.is_deleted' => 0, 'AlertOperations.is_active' => 1, 'AlertOperations.alert_id' => $alertId]);
        return $operationList->toArray();
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getUserIdListForEmail($alertId, $userId) {
        $userIdList = [];
        $operationIdList = $this->find('list', ['valueField' => 'operation_id']);
        $operationIdList->hydrate(false)->select(['AlertOperations.alert_id'])->where(['AlertOperations.is_deleted' => 0, 'AlertOperations.is_active' => 1, 'AlertOperations.alert_id' => $alertId]);
        $operationIdList = $operationIdList->toArray();
        if (!empty($operationIdList)) {
            $this->LocationOperations = TableRegistry::get('LocationOperations');
            $userIdList = $this->LocationOperations->getUserIdListForEmail($operationIdList);
            if ($userIdList) {
                $this->Users = TableRegistry::get('Users');
                $staffIdList = $this->Users->getStaffIdList($userIdList);
                $userIdList = array_merge($staffIdList, $userIdList);
            }
        }
        return $userIdList;
    }

    public function saveAlertOperations($operations = null) {
        if (!empty($operations['alert_id'])) {
            $conditionSample = array('AlertOperations.alert_id' => $operations['alert_id']);
            $this->deleteAll($conditionSample, false);
        }
        foreach ($operations['operation_id'] as $key => $value) {
            $operation['operation_id'] = $value;
            $operation['created'] = date('Y-m-d');
            $operation['alert_id'] = $operations['alert_id'];
            $operation['alert_type_id'] = $operations['alert_type_id'];
            $operations = $this->newEntity();
            $this->patchEntity($operations, $operation);
            $savedStaff = $this->save($operations);
            if ($savedStaff) {
                $responce['flag'] = true;
            } else {
                $responce['flag'] = true;
            }
        }
        return $responce;
    }

    /**
     * 
     * @param int $operationId
     * @return type
     */
    public function getDataByOperationId($operationId) {
        return $this->find()->contain(['Alerts', 'Alerts.AlertStaffs', 'Alerts.AlertCompanies'])->where(['AlertOperations.operation_id' => $operationId, 'AlertOperations.is_active' => 1, 'AlertOperations.is_deleted' => 0])->all();
    }

}

?>
