<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class DeadlinesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('deadlines');

        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
                ]
        );
        $this->belongsTo(
                'DeadlineTypes', [
            'className' => 'DeadlineTypes',
            'foreignKey' => 'deadline_type_id'
                ]
        );
        $this->belongsTo(
                'Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id'
                ]
        );

        $this->hasMany(
                'UserPermitDeadlines', [
            'className' => 'UserPermitDeadlines',
            'foreignKey' => 'deadline_id'
                ]
        );
    }

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('date', 'Date cannot be empty')
                ->notEmpty('time', 'Time cannot be empty');
        return $validator;
    }

    /**
     * 
     * @param array $deadlineData
     * @param int $addedFrom     
     */
    public function saveData($deadlineData, $permitId) {
        $responce['flag'] = false;
        $responce['msg'] = '';
        $deadlines = [];
        if (!empty($deadlineData['id'])) {
            $deadlines = $this->get($deadlineData['id']);
        } else {
            $deadlineData['user_id'] = Configure::read('LoggedCompanyId');
            $deadlineData['added_by'] = Configure::read('LoggedUserId');
            $deadlineData['permit_id'] = $permitId;
            if (in_array(Configure::read('LoggedRoleId'), array(1, 4))) {
                $deadlineData['is_admin'] = 1;
            } else {
                $deadlineData['is_admin'] = 0;
            }
            $deadlines = $this->newEntity($deadlineData);
        }

        $deadlines = $this->patchEntity($deadlines, $deadlineData);
        if (!$deadlines->errors()) {
            if ($deadlines = $this->save($deadlines)) {
                $responce['flag'] = true;
                $responce['id'] = $deadlines->id;
                $responce['msg'] = 'Deadline has been added successfully';
            } else {
                $response['msg'] = 'Deadline could not be added!';
            }
        } else {
            $response['msg'] = 'Deadline could not be added!';
        }
        return $responce;
    }

    /**
     * 
     * @param type $deadlineData
     * @param type $permitId
     */
    public function saveAdminPermitData($deadlineData, $permitId) {
        $response = $this->saveData($deadlineData, $permitId);
        return $response;
    }

    /**
     * 
     * @param type $deadlineData
     * @param type $permitId
     */
    public function saveCompanyPermitData($deadlineData, $permitId = null) {
        $response = $this->saveData($deadlineData, 14);
        if (empty($deadlineData['id']) && $response['flag']) {
            $this->UserDeadlinePermits = TableRegistry::get('UserDeadlinePermits');
            //$this->UserDeadlinePermits->saveData($response['id'], $permitId);
        }
        return $response;
    }

    /**
     * 
     * @param int $deadlineId
     * @return type
     */
    public function getDataById($deadlineId) {
        return $this->find()->where(['Deadlines.id' => $deadlineId, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0])->first();
    }

    /**
     * 
     * @param int $deadlineId
     * @return type
     */
    public function getAllDataById($deadlineId) {
        return $this->find()->contain(['USerPermitDeadlines'])->where(['Deadlines.id' => $deadlineId, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0])->first();
    }

    /**
     * 
     * @param type $permitId
     */
    public function getAdminDataByPermitId($permitId) {
        return $this->find()->where(['Deadlines.permit_id' => $permitId, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'Deadlines.is_admin' => 1])->first();
    }

    /**
     * 
     * @param type $permitId
     */
    public function getCompanyDataByPermitIdNoUse($permitId, $userPermitId) {
        return $this->find()->contain([
                    'UserPermitDeadlines' => function($q) use( $userPermitId ) {
                        return $q
                                        ->where(['UserPermitDeadlines.user_permit_id' => $userPermitId, 'UserPermitDeadlines.is_deleted' => 0, 'UserPermitDeadlines.is_active' => 1])
                                        ->select(['id', 'deadline_id', 'document_id', 'permit_form_id']);
                    },
                    'UserPermitDeadlines.Documents' => function($q) {
                        return $q
                                        ->select(['id', 'name']);
                    },
                    'UserPermitDeadlines.PermitForms' => function($q) {
                        return $q
                                        ->select(['id', 'name']);
                    },
                    'DeadlineTypes' => function($q) {
                        return $q
                                        ->select(['name']);
                    },
                ])->where(['Deadlines.permit_id' => $permitId, 'Deadlines.user_permit_id' => $userPermitId, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'Deadlines.is_admin' => 0])->all();
    }

    public function getDeadlineData($deadlineId) {
        return $this->find()->contain([
                    'UserPermitDeadlines' => function($q) use( $deadlineId ) {
                        return $q
                                        ->where(['UserPermitDeadlines.deadline_id' => $deadlineId, 'UserPermitDeadlines.is_deleted' => 0, 'UserPermitDeadlines.is_active' => 1]);
                    }
                ])->where(['Deadlines.id' => $deadlineId, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'Deadlines.is_admin' => 0])->first();
    }

    public function getCompanyDataByPermitId($permitId, $userPermitId) {
        $conditions['OR'][] = ['Deadlines.permit_id' => $permitId, 'Deadlines.is_admin' => 1];
        if ($userPermitId) {
            $conditions['OR'][]['Deadlines.user_permit_id'] = $userPermitId;
        }
        $userDeadlineData = $this->find()
                ->where($conditions)
                ->order(['Deadlines.is_admin' => 'DESC', 'Deadlines.date' => 'DESC'])
                ->first();
        return $userDeadlineData;
        //return $this->find()->where(['Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0, 'OR' => [['Deadlines.is_admin' => $isAdmin, 'Deadlines.permit_id' => $permitId], ['Deadlines.user_permit_id' => $userPermitId]]])->all();
    }

}

?>
