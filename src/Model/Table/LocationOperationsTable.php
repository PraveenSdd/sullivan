<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class LocationOperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('location_operations');

        $this->belongsTo('UserLocations', [
            'className' => 'UserLocations',
            'foreignKey' => 'user_location_id',
            'conditions' => ['UserLocations.is_active' => 1, 'UserLocations.is_deleted' => 0]
        ]);

        $this->belongsTo('Operations', [
            'className' => 'Operations',
            'foreignKey' => 'operation_id',
            'conditions' => ['Operations.is_active' => 1, 'Operations.is_deleted' => 0]
        ]);

        $this->belongsTo('PermitOperations', [
            'className' => 'PermitOperations',
            'foreignKey' => 'operation_id',
            'conditions' => ['PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0]
        ]);
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
                ]
        );
    }

    /**
     * 
     * @param int $userId
     * @return array
     */
    public function getOperationListByUserId($userId, $user_location_id = null) {
        $operationList = $this->find('list', ['valueField' => 'operation_id']);
        if (empty($user_location_id)) {
            $operationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_id' => $userId]);
        } else {
            $operationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_id' => $userId, 'LocationOperations.user_location_id' => $user_location_id]);
        }
        return $operationList->toArray();
    }

    /**
     * 
     * @param type $userLocationId
     * @return type
     */
    public function countOperationByLocationId($userLocationId) {
        return $this->find('all')->select(['LocationOperations.id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_location_id' => $userLocationId])->count();
    }

    /**
     * 
     * @param type $userLocationId
     * @return type
     */
    public function getOperationListByLocationId($userLocationId) {
        $locationOperationList = $this->find('list', ['valueField' => 'operation_id']);
        $locationOperationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_location_id' => $userLocationId]);
        $locationOperationList = $locationOperationList->toArray();

        # Get Operation-name list by Operation-id
        $operationList = [];
        if (!empty($locationOperationList)) {
            $this->Operations = TableRegistry::get('Operations');
            $operationList = $this->Operations->getListById($locationOperationList);
        }
        return $operationList;
    }

    /**
     * 
     * @param type $userLocationId
     * @return type
     */
    public function getOperationIdByLocationId($userLocationId) {
        $locationOperationList = $this->find('list', ['valueField' => 'operation_id']);
        $locationOperationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_location_id' => $userLocationId]);
        return $locationOperationList->toArray();
    }

    /**
     * 
     * @param type $userLocationId
     * @return type
     */
    public function getAllOperationIdByLocationId($userLocationId) {
        $locationOperationList = $this->find('list', ['valueField' => 'operation_id']);
        $locationOperationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.user_location_id' => $userLocationId]);
        return $locationOperationList->toArray();
    }

    /**
     * 
     * @param int $userId 
     * @param int $locationId
     * @param array $operationIds
     */
    public function updateOperations($userId, $locationId, $operationIds = []) {
        $existedLocationOperationIds = $this->getAllOperationIdByLocationId($locationId);
        $deletedLocationOperationIds = $locationOperationData = [];
        if (!empty($operationIds)) {
            $unsedLocationOperationIds = [];
            foreach ($operationIds as $operation) {
                $locationOperationData['operation_id'] = $operation;
                $locationOperationData['user_id'] = $userId;
                $locationOperationData['user_location_id'] = $locationId;
                $locationOperationData['is_active'] = 1;
                $locationOperationData['is_deleted'] = 0;
                if (in_array($locationOperationData['operation_id'], $existedLocationOperationIds)) {
                    $locationOperationData['id'] = array_search($locationOperationData['operation_id'], $existedLocationOperationIds);
                } else {
                    $locationOperationData['id'] = $this->getIdByLocationAndOperationId($locationId, $operation);
                }
                $locationOperations = null;
                if (!empty($locationOperationData['id'])) {
                    $unsedLocationOperationIds[$locationOperationData['id']] = $locationOperationData['id'];
                    $locationOperations = $this->get($locationOperationData['id']);
                } else {
                    $locationOperations = $this->newEntity();
                }
                $this->patchEntity($locationOperations, $locationOperationData);
                $this->save($locationOperations);
            }
            $deletedLocationOperationIds = array_diff_key($existedLocationOperationIds, $unsedLocationOperationIds);
        } else {
            $deletedLocationOperationIds = $existedLocationOperationIds;
        }

        if ($deletedLocationOperationIds) {
            $deletedLocationOperationIds = array_flip($deletedLocationOperationIds);
            foreach ($deletedLocationOperationIds as $deletedId) {
                $this->updateAll(array('is_deleted' => 1, 'is_active' => 0), array('id' => $deletedId));
            }
        }
    }

    /**
     * 
     * @param int $userId 
     * @param int $locationId
     * @param array $operationIds
     */
    public function saveOperations($userId, $locationId, $operationIds) {
        if (!empty($operationIds)) {
            foreach ($operationIds as $operation) {
                $locationOperationData['operation_id'] = $operation;
                $locationOperationData['user_id'] = $userId;
                $locationOperationData['user_location_id'] = $locationId;
                $locationOperationData['is_active'] = 1;
                $locationOperationData['is_deleted'] = 0;
                $locationOperations = $this->newEntity();
                $this->patchEntity($locationOperations, $locationOperationData);
                $this->save($locationOperations);
            }
        }
    }

    /**
     * 
     * @param type $locationId
     * @param type $operationId
     * @return type
     */
    public function getIdByLocationAndOperationId($locationId, $operationId) {
        $locationOperationId = null;
        $locationOperationData = $this->find()->hydrate(false)->select(['LocationOperations.id'])->where(['LocationOperations.user_location_id' => $locationId, 'LocationOperations.operation_id' => $operationId])->first();
        if ($locationOperationData) {
            $locationOperationId = $locationOperationData['id'];
        }
        return $locationOperationId;
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getUserIdByOperationId($operationId) {
        $userList = $this->find('list', ['valueField' => 'user_id']);
        $userList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.operation_id IN' => $operationId])->group(['LocationOperations.user_id']);
        ;
        return $userList->toArray();
    }

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getUserIdListForEmail($operationId) {
        $userIdList = $this->find('list', ['valueField' => 'user_id']);
        if (is_array($operationId)) {
            $userIdList->hydrate(false)->select(['id', 'user_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.operation_id IN' => $operationId]);
        } else {
            $userIdList->hydrate(false)->select(['id', 'user_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.operation_id' => $operationId]);
        }
        return $userIdList->toArray();
    }

    public function getAllOperationIdByLocationIdAndUserId($userLocationId) {
        $locationOperationList = $this->find('list', ['keyField' => 'operation_id', 'valueField' => 'operation_id']);
        if (!empty($userLocationId)) {
            $locationOperationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_location_id IN' => $userLocationId, 'LocationOperations.user_id' => Configure::read('LoggedCompanyId')]);
        } else {
            $locationOperationList->hydrate(false)->select(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_id' => Configure::read('LoggedCompanyId')]);
        }
        return $locationOperationList->toArray();
    }

    public function getOperationListByCompanyId($userId, $user_location_id = null) {
        $operationList = $this->find('list', ['valueField' => 'operation_id']);
        if (empty($user_location_id)) {
            $operationList->hydrate(false)->select(['LocationOperations.operation_id'])->distinct(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_id' => $userId]);
        } else {
            $operationList->hydrate(false)->select(['DISTINCT LocationOperations.operation_id'])->distinct(['LocationOperations.operation_id'])->where(['LocationOperations.is_deleted' => 0, 'LocationOperations.is_active' => 1, 'LocationOperations.user_id' => $userId, 'LocationOperations.user_location_id' => $user_location_id]);
        }
        return $operationList->toArray();
    }

}

?>
