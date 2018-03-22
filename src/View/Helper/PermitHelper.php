<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PermitHelper extends Helper {
    /* @Function: checkStatus()
     * @Description: function use for return status and check if exist
     * @param type $permit_id,$operation_id,$user_id,$user_location_id
     * @return boolean
     * By @Vipin Chauhan
     * Date : 5th Feb. 2018
     */

    public function checkStatus($permit_id, $operation_id, $user_id, $user_location_id, $permit_status_id) {

        $userPermitTable = TableRegistry::get('UserPermits');
        $checkIfExist = $userPermitTable->find()->where(['added_by' => $user_id, 'permit_id' => $permit_id, 'operation_id' => $operation_id, 'user_location_id' => $user_location_id, 'permit_status_id' => $permit_status_id])->count();
        if ($checkIfExist > 0) {
            return true;
        }return false;
    }

    public function getUserPermitModificationDate($permitId, $operationId, $userLocationId) {
        $modificationDate = 'NA';
        $userPermitTable = TableRegistry::get('UserPermits');
        $userPermitData = $userPermitTable->find()
                ->where(['UserPermits.user_id' => Configure::read('LoggedCompanyId'), 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId, 'UserPermits.user_location_id' => $userLocationId,'UserPermits.is_previous'=>0,'UserPermits.permit_status_id !='=>4])
                ->select(['modified'])
                ->first();
        if (!empty($userPermitData)) {
            $modificationDate = $userPermitData;
        }
        return $modificationDate;
    }

    public function getDeadlineDate($permitId, $userPermitId = null) {
        $permitDeadline = 'NA';
        $conditions['OR'][] = ['Deadlines.permit_id' => $permitId, 'Deadlines.is_admin' => 1];
        if ($userPermitId) {
            $conditions['OR'][]['Deadlines.user_permit_id'] = $userPermitId;
        }
        $userDeadlineTable = TableRegistry::get('Deadlines');
        $userDeadlineData = $userDeadlineTable->find()
                ->where($conditions)
                ->order(['Deadlines.is_admin' => 'DESC','Deadlines.date' => 'DESC'])
                ->select(['date'])
                ->first();
        if($userDeadlineData){
            $permitDeadline = $userDeadlineData->date;
        }
        return $permitDeadline;
    }
    
    public function getPermitDates($permitId, $operationId, $userLocationId) {
        $permitDate['modified_at'] = $permitDate['modified_by'] = $permitDate['deadline'] = 'NA';
            
        $userPermitId = '';
        $userPermitTable = TableRegistry::get('UserPermits');
        $userPermitData = $userPermitTable->find()
                ->contain(['Users' => function($q) {
                        return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                    }])
                ->where(['UserPermits.user_id' => Configure::read('LoggedCompanyId'), 'UserPermits.permit_id' => $permitId, 'UserPermits.operation_id' => $operationId, 'UserPermits.user_location_id' => $userLocationId,'UserPermits.is_previous'=>0,'UserPermits.permit_status_id !='=>4])
                ->select(['id', 'modified'])
                ->first();
        if (!empty($userPermitData)) {
            $permitDate['modified_at'] = $userPermitData->modified;
            $permitDate['modified_by'] = (isset($userPermitData->user->first_name) ? $userPermitData->user->first_name : '');
            $userPermitId = $userPermitData->id;
        }
        $permitDate['deadline'] = $this->getDeadlineDate($permitId, $userPermitId);
        return $permitDate;
    }

    public function getCurrentPermitStatusId($permit_id, $operation_id, $user_location_id) {
        $userPermitTable = TableRegistry::get('UserPermits');
        $checkIfExist = $userPermitTable->find()->select(['UserPermits.permit_status_id'])->where(['user_id' => Configure::read('LoggedCompanyId'), 'permit_id' => $permit_id, 'operation_id' => $operation_id, 'user_location_id' => $user_location_id, 'is_previous' => 0])->first();
        if (!empty($checkIfExist)) {
            return $checkIfExist->permit_status_id;
        } else {
            return 1;
        }
    }

}
