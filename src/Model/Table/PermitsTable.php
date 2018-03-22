<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PermitsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permits');

        $this->hasOne('PermitAgencies', [
            'className' => 'PermitAgencies',
            'foreignKey' => 'permit_id',
            'conditions' => ['PermitAgencies.is_active' => 1, 'PermitAgencies.is_deleted' => 0]
        ]);

        $this->hasMany('PermitOperations', [
            'className' => 'PermitOperations',
            'foreignKey' => 'operation_id',
            'conditions' => ['PermitOperations.is_active' => 1, 'PermitOperations.is_deleted' => 0]
        ]);

        $this->hasMany('PermitDocuments', [
            'className' => 'PermitDocuments',
            'foreignKey' => 'permit_id'
        ]);
        $this->hasMany('PermitForms', [
            'className' => 'PermitForms',
            'foreignKey' => 'permit_id'
        ]);
        $this->hasMany('PermitDeadlines', [
            'className' => 'PermitDeadlines',
            'foreignKey' => 'permit_id'
        ]);
        $this->hasMany('PermitInstructions', [
            'className' => 'PermitInstructions',
            'foreignKey' => 'permit_id'
        ]);
        $this->hasMany('PermitAgencyContacts', [
            'className' => 'PermitAgencyContacts',
            'foreignKey' => 'permit_id'
        ]);
        $this->hasMany('Deadlines', [
            'className' => 'Deadlines',
            'foreignKey' => 'permit_id'
        ]);

        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );

        $this->hasMany('UserPreviousPermitDocuments', [
            'className' => 'UserPreviousPermitDocuments',
            'foreignKey' => 'permit_id'
        ]);
    }

    /**
     * 
     * @param Validator $validator
     * @return Validator
     */
    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('name', 'Permit name cannot be empty');

        return $validator;
    }

    public function permitDetails($permitId, $userPermitId, $isAdmin) {
        $permitDetails = $this->find()->contain([
                    'PermitDocuments' => function($q) {
                        return $q
                                        ->where(['PermitDocuments.is_deleted' => 0, 'PermitDocuments.is_active' => 1])
                                        ->select(['id', 'permit_id', 'document_id']);
                    },
                    'PermitDocuments.Documents' => function($q) {
                        return $q
                                        ->select(['id', 'name', 'slug']);
                    },
                    'PermitForms', 'PermitForms.PermitFormSamples',
                    'PermitForms.UserPermitForms' => function($q) use( $userPermitId ) {
                        return $q
                                        ->where(['UserPermitForms.is_deleted' => 0, 'UserPermitForms.user_permit_id' => $userPermitId])
                                        ->select(['id', 'permit_form_id', 'file', 'security_type_id', 'modified']);
                    },
                    'PermitDocuments.UserPermitDocuments' => function($q) use( $userPermitId ) {
                        return $q
                                        ->where(['UserPermitDocuments.is_deleted' => 0, 'UserPermitDocuments.user_permit_id' => $userPermitId])
                                        ->select(['id', 'permit_document_id', 'file', 'security_type_id', 'modified']);
                    },
                    'Deadlines' => function($q) use( $isAdmin ) {
                        return $q
                                        ->where(['Deadlines.is_admin' => $isAdmin, 'Deadlines.is_active' => 1, 'Deadlines.is_deleted' => 0])
                                        ->limit(1)
                                        ->order(['Deadlines.date' => 'DESC']);
                    },
                    'Deadlines.DeadlineTypes',
                    'PermitInstructions',
                    'PermitAgencies', 'PermitAgencies.Agencies', 'PermitAgencyContacts.AgencyContacts',
                ])->where(['Permits.id' => $permitId])->first();
        return $permitDetails;
    }

    /**
     * 
     * @param string $name
     * @return int id
     */
    public function getIdByName($name) {
        $permitId = null;
        $permitData = $this->find()->hydrate(false)->select(['Permits.id'])->where(['LOWER(Permits.name) LIKE' => '%' . strtolower($name) . '%', 'Permits.is_active' => 1, 'Permits.is_deleted' => 0])->first();
        if ($permitData) {
            $permitId = $permitData['id'];
        }
        return $permitId;
    }

    /**
     * 
     * @param type $permitData
     * @param type $permitId
     * @return array
     */
    public function savePermitData($permitData, $permitId = null) {
        $responce['flag'] = false;
        $responce['msg'] = '';
        // Get Agency-Id by name if id is empty
        if (empty($permitId)) {
            $permitId = $this->getIdByName($permitData['Permit']['name']);
        }

        # Save permit-data
        $permits = [];
        $permitData['Permit']['slug'] = $permitData['Permit']['name'];

        if ($permitId) {
            $permits = $this->get($permitId);
        } else {
            $permitData['Permit']['added_by'] = Configure::read('LoggedCompanyId');
            $permits = $this->newEntity();
        }
        $permits = $this->patchEntity($permits, $permitData['Permit'], ['validate' => 'Add']);
        if (!$permits->errors()) {
            # Check validation
            if ($this->checkRules($permits)) {
                if ($permits = $this->save($permits)) {
                    $responce['msg'] = 'Permit has been saved successfully.';
                    $responce['flag'] = true;
                    $responce['permit_id'] = $permits->id;
                } else {
                    $responce['msg'] = 'Permit could not be saved';
                }
            } else {
                $responce['msg'] = 'Permit name already exits';
            }
        } else {
            $responce['msg'] = $permits->errors();
        }
        return $responce;
    }

    /**
     * 
     * @return array list
     */
    public function getList() {
        $permitList = $this->find('list', ['valueField' => 'name']);
        $permitList->hydrate(false)->select(['Permits.name'])->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1]);
        return $permitList->toArray();
    }

    /**
     * 
     * @param int $agencyId
     * @return array list
     */
    public function getUnAssignedPermitList($agencyId = null) {
        $this->PermitAgencies = TableRegistry::get('PermitAgencies');
        $assignPermitList = $this->PermitAgencies->getAssignedPermitList();

        $permitList = $this->find('list');
        if ($agencyId) {
            unset($assignPermitList[$agencyId]);
        }
        if (!empty($assignPermitList)) {
            $permitList->hydrate(false)->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1, 'NOT' => ['Permits.id IN' => $assignPermitList]]);
        } else {
            $permitList->hydrate(false)->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1]);
        }
        return $permitList->toArray();
    }

    /*
     * Function:checkAgencyUniqueName()
     * Description: use for check Unique agency/agency by ajax
     * By @Ahsan Ahamad
     * Date : 13th Jan. 2018
     */

    public function checkPermitUniqueName($permitName = null, $permitId = null) {
        $responseFlag = false;
        $conditions = array('LOWER(Permits.name)' => strtolower($permitName), 'Permits.is_deleted' => 0);
        if ($permitId) {
            $conditions['Permits.id !='] = $permitId;
        }

        $permits = $this->find()->select(['name', 'id'])->where($conditions)->first();

        if ($permits) {
            $responseFlag = false;
        } else {
            $responseFlag = true;
        }
        return $responseFlag;
    }

    public function getPermitList($permitOperationIdList = null) {
        $permits = $this->find('list');
        if ($permitOperationIdList) {
            $permits->hydrate(false)->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1, 'Not' => ['Permits.id IN' => $permitOperationIdList]]);
        } else {
            $permits->hydrate(false)->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1]);
        }

        $permitsList = $permits->toArray();
        if ($permitsList) {
            return $permitsList;
        } else {
            return false;
        }
    }

    /**
     * 
     * @param int $agencyId
     * @return array list
     */
    public function getUnAssignedPermitListByOpertionId($operationId = null) {
        $this->PermitOperations = TableRegistry::get('PermitOperations');
        $assignPermitList = $this->PermitOperations->getAssignedPermitListByOperationId($operationId);
        $permitList = $this->find('list');
        if ($operationId) {
            unset($assignPermitList[$operationId]);
        }
        if (!empty($assignPermitList)) {
            $permitList->hydrate(false)->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1, 'NOT' => ['Permits.id IN' => $assignPermitList]]);
        } else {
            $permitList->hydrate(false)->where(['Permits.is_deleted' => 0, 'Permits.is_active' => 1]);
        }
        return $permitList->toArray();
    }

    public function previousPermitDetail($permitId, $userPermitId) {
        $permitDetails = $this->find()->contain([
                    'UserPreviousPermitDocuments' => function($q)use($permitId,$userPermitId) {
                        return $q
                                        ->where(['UserPreviousPermitDocuments.is_deleted' => 0, 'UserPreviousPermitDocuments.is_active' => 1,'UserPreviousPermitDocuments.user_permit_id'=>$userPermitId,'UserPreviousPermitDocuments.permit_id'=>$permitId]);
                    }])->where(['Permits.id' => $permitId])->first();
        return $permitDetails;
    }

}

?>
