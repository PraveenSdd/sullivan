<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class UserPermitsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('user_permits');

        $this->belongsTo('UserLocations', [
            'className' => 'UserLocations',
            'foreignKey' => 'user_location_id',
        ]);
        $this->belongsTo('Operations', [
            'className' => 'Operations',
            'foreignKey' => 'operation_id',
        ]);
        $this->belongsTo('Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id',
        ]);
        $this->hasMany('UserPreviousPermitDocuments', [
            'className' => 'UserPreviousPermitDocuments',
            'foreignKey' => 'user_permit_id',
        ]);
        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
        ]);
        $this->hasOne('Renewable', [
            'className' => 'Deadlines',
            'foreignKey' => 'user_permit_id',
            'conditions' => ['Renewable.is_renewable' => 1,'Renewable.is_admin'=>0]
        ]);
    }

    /**
     * 
     * @return array list
     */
    public function saveData($data, $status = null) {
        if ($status) {
            $checkIfExist = $this->find()->where(['user_id' => Configure::read('LoggedCompanyId'), 'permit_id' => $data['permit_id'], 'operation_id' => $data['operation_id'], 'user_location_id' => $data['user_location_id'], 'is_previous' => 1, 'permit_status_id' => 0])->select(['id'])->first();
        } else {
            $checkIfExist = $this->find()->where(['user_id' => Configure::read('LoggedCompanyId'), 'permit_id' => $data['permit_id'], 'operation_id' => $data['operation_id'], 'user_location_id' => $data['user_location_id'], 'is_previous' => 0, 'permit_status_id !=' => 0])->select(['id'])->first();
        }
        $res = '';
        if (count($checkIfExist) <= 0) {
            $userPermit = $this->newEntity();
            $userPermit->user_id = Configure::read('LoggedCompanyId');
            $userPermit->permit_id = $data['permit_id'];
            $userPermit->operation_id = $data['operation_id'];
            $userPermit->user_location_id = $data['user_location_id'];
            $userPermit->permit_status_id = $data['status_id'];
            if (isset($data['is_previous'])) {
                $userPermit->is_previous = $data['is_previous'];
            }
            if ($data['status_id'] == 4) {
                $userPermit->is_previous = 1;
            }
            $userPermit->added_by = Configure::read('LoggedUserId');
            $res = $this->save($userPermit);
        } else {
            $userPermit = $this->get($checkIfExist['id']);
            $userPermit->permit_status_id = $data['status_id'];
            if ($data['status_id'] == 4) {
                $userPermit->is_previous = 1;
            }
            $res = $this->save($userPermit);
        }
        return $res;
    }

    public function getPermitList() {
        return $this->find()
                        ->hydrate(false)
                        ->select(['UserPermits.id', 'UserPermits.permit_id', 'UserPermits.operation_id', 'UserPermits.user_location_id'])
                        ->contain([
                            'Operations' => function($q) {
                                return $q
                                        ->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1])
                                        ->select(['id', 'name']);
                            },
                            'UserLocations' => function($q) {
                                return $q
                                        ->select(['id', 'title']);
                            }
                            ,
                            'Permits' => function($q) {
                                return $q
                                        ->select(['id', 'name']);
                            }
                        ])
                        ->where(['UserPermits.user_id' => Configure::read('LoggedCompanyId'), 'UserPermits.is_active' => 1, 'UserPermits.is_deleted' => 0, 'UserPermits.is_previous' => 0, 'UserPermits.permit_status_id >' => 0])
                        ->order(['UserPermits.created' => 'DESC'])
                        ->toArray();
    }

    public function getUserPreviousPermitList() {
        return $this->find()
                        ->hydrate(false)
                        ->select(['UserPermits.id', 'UserPermits.permit_id', 'UserPermits.operation_id', 'UserPermits.user_location_id'])
                        ->contain([
                            'Operations' => function($q) {
                                return $q
                                        ->where(['Operations.is_deleted' => 0, 'Operations.is_active' => 1])
                                        ->select(['id', 'name']);
                            },
                            'UserLocations' => function($q) {
                                return $q
                                        ->select(['id', 'title']);
                            }
                            ,
                            'Permits' => function($q) {
                                return $q
                                        ->select(['id', 'name']);
                            }
                        ])
                        ->where(['UserPermits.user_id' => Configure::read('LoggedCompanyId'), 'UserPermits.is_active' => 1, 'UserPermits.is_deleted' => 0, 'UserPermits.is_previous' => 1, 'UserPermits.permit_status_id' => 0])
                        ->order(['UserPermits.created' => 'DESC'])
                        ->toArray();
    }

    public function getPermitListByCompanyId($userId) {
        $permitList = $this->find('list', ['keyField' => 'permit_id', 'valueField' => 'permit_id']);
        $permitList->hydrate(false)->where(['UserPermits.user_id' => $userId, 'UserPermits.is_deleted' => 0, 'UserPermits.is_active' => 1]);
        return $permitList->toArray();
    }
    
    public function getPreviousPermitListByCompanyId($userId) {
        $permitList = $this->find('list', ['keyField' => 'permit_id', 'valueField' => 'permit_id']);
        $permitList->hydrate(false)->where(['UserPermits.user_id' => $userId, 'UserPermits.is_deleted' => 0, 'UserPermits.is_active' => 1, 'UserPermits.is_previous' => 1]);
        return $permitList->toArray();
    }

}

?>
