<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class AlertsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alerts');

        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
                ]
        );
        $this->belongsTo(
                'AlertTypes', [
            'className' => 'AlertTypes',
            'foreignKey' => 'alert_type_id'
                ]
        );

        $this->hasMany('AlertStaffs', [
            'className' => 'AlertStaffs',
            'foreignKey' => 'alert_id',
            'conditions' => ['AlertStaffs.is_active' => 1, 'AlertStaffs.is_deleted' => 0]
        ]);
        $this->hasMany('AlertCompanies', [
            'className' => 'AlertCompanies',
            'foreignKey' => 'alert_id',
            'conditions' => ['AlertCompanies.is_active' => 1, 'AlertCompanies.is_deleted' => 0]
        ]);
        $this->hasMany('AlertOperations', [
            'className' => 'AlertOperations',
            'foreignKey' => 'alert_id',
            'conditions' => ['AlertOperations.is_active' => 1, 'AlertOperations.is_deleted' => 0]
        ]);


        $this->hasOne('AlertPermits', [
            'className' => 'AlertPermits',
            'foreignKey' => 'alert_id',
            'conditions' => ['AlertPermits.is_active' => 1, 'AlertPermits.is_deleted' => 0]
        ]);
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );
    }

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('title', 'Title cannot be empty')
                ->notEmpty('notes', 'Notes cannot be empty');
        return $validator;
    }

    /**
     * 
     * @param array $alertData
     * @param int $addedFrom     
     */
    public function saveData($alertData, $addedFrom) {
        $responce['flag'] = false;
        $responce['msg'] = '';
        $alerts = [];
        if (!empty($alertData['id'])) {
            $alerts = $this->get($alertData['id']);
        } else {
            $alertData['user_id'] = Configure::read('LoggedCompanyId');
            $alertData['added_by'] = Configure::read('LoggedUserId');
            $alertData['added_from'] = $addedFrom;
            if (in_array(Configure::read('LoggedRoleId'), array(1, 4))) {
                $alertData['is_admin'] = 1;
            } else {
                $alertData['is_admin'] = 0;
            }
            $alerts = $this->newEntity($alertData);
        }

        $alerts = $this->patchEntity($alerts, $alertData, ['validate' => 'Add']);
        if (!$alerts->errors()) {
            if ($alerts = $this->save($alerts)) {
                $this->AlertStaffs = TableRegistry::get('AlertStaffs');
                $this->AlertCompanies = TableRegistry::get('AlertCompanies');
                $this->AlertOperations = TableRegistry::get('AlertOperations');
                $this->AlertStaffs->updateAll(array('is_deleted' => 1), array('alert_id' => $alerts->id));
                $this->AlertCompanies->updateAll(array('is_deleted' => 1), array('alert_id' => $alerts->id));
                $this->AlertOperations->updateAll(array('is_deleted' => 1), array('alert_id' => $alerts->id));
                switch ($alertData['alert_type_id']) {
                    case 1: // Personal
                        break;
                    case 2: // Sullivan Staff -- Sub-admin
                        if (isset($alertData['staff_id'][0]) && !empty($alertData['staff_id'][0])) {
                            $this->AlertStaffs->saveData($alerts->id, $alertData['staff_id']);
                        }
                        break;
                    case 3: //Company
                        if (isset($alertData['company_id'][0]) && !empty($alertData['company_id'][0])) {
                            $this->AlertCompanies->saveData($alerts->id, $alertData['company_id']);
                        }
                        break;
                    case 4: // Operation
                        if (isset($alertData['operation_id'][0]) && !empty($alertData['operation_id'][0])) {
                            $this->AlertOperations->saveData($alerts->id, $alertData['operation_id']);
                        }
                        break;     
                    case 5: // Sullivan Staff
                        if (isset($alertData['staff_id'][0]) && !empty($alertData['staff_id'][0])) {
                            $this->AlertStaffs->saveData($alerts->id, $alertData['staff_id']);
                        }
                        break;    
                }
                
                # Save date for sending alert-email via cron-jobs
                $this->CronAlertMails = TableRegistry::get('CronAlertMails');
                $this->CronAlertMails->saveCronAlert($alerts->id);

                $responce['flag'] = true;
                $responce['id'] = $alerts->id;
                $responce['msg'] = 'Alert has been added successfully';
            } else {
                $response['msg'] = 'Alert could not be added!';
            }
        } else {
            $responce['msg'] = $alerts->errors();
        }
        return $responce;
    }
    
    /**
     * 
     * @param type $alertData
     * @param type $permitId
     */
    public function saveAdminData($alertData) {
        return $this->saveData($alertData, 5);
    }

    /**
     * 
     * @param type $alertData
     * @param type $permitId
     */
    public function saveAdminPermitData($alertData, $permitId = null) {
        $response = $this->saveData($alertData, 4);
        if (empty($alertData['id']) && $response['flag']) {
            $this->AlertPermits = TableRegistry::get('AlertPermits');
            $this->AlertPermits->saveData($response['id'], $permitId);
        }
        return $response;
    }
    
    /**
     * 
     * @param type $alertData
     * @param type $operationId
     */
    public function saveAdminOperationData($alertData, $operationId = null) {
        return $this->saveData($alertData, 3);
    }
    
    /**
     * 
     * @param type $alertData
     * @param type $permitId
     */
    public function saveCompanyData($alertData) {
        return $this->saveData($alertData, 13);
    }
    
    /**
     * 
     * @param type $alertData
     * @param type $permitId
     */
    public function saveCompanyPermitData($alertData, $permitId = null) {
        $response = $this->saveData($alertData, 14);
        if (empty($alertData['id']) && $response['flag']) {
            $this->AlertPermits = TableRegistry::get('AlertPermits');
            $this->AlertPermits->saveData($response['id'], $permitId,$alertData['Permit']['user_permit_id'],$alertData['Permit']['user_previous_permit_document_id']);
        }
        return $response;
    }
    
    /**
     * 
     * @param int $alertId
     * @return type
     */
    public function getDataId($alertId){
        return $this->find()->contain(['AlertTypes','AlertStaffs','AlertCompanies','AlertOperations'])->where(['Alerts.id' => $alertId, 'Alerts.is_active' => 1, 'Alerts.is_deleted' => 0])->first();
    }
    
    /**
     * 
     * @param int $alertId
     * @return type
     */
    public function getAllDataId($alertId){
        return $this->find()->contain(['AlertTypes','AlertStaffs','AlertStaffs.Users','AlertCompanies','AlertCompanies.Users','AlertOperations','AlertOperations.Operations'])->where(['Alerts.id' => $alertId, 'Alerts.is_active' => 1, 'Alerts.is_deleted' => 0])->first();
    }
    

    /**
     * @Function:addAlert()
     * @description: This function use for save alert data in alerts table
     * @param type $dataAlerts
     * @return type
     */
    public function addAlert($dataAlerts = array()) {
        $responce['flag'] = false;
        $alertData['alert_type_id'] = $dataAlerts['alert_type_id'];
        $alertData['title'] = $dataAlerts['title'];
        $alertData['notes'] = $dataAlerts['notes'];
        $alertData['date'] = date('Y-m-d', strtotime($dataAlerts['date']));
        $alertData['time'] = $dataAlerts['time'];
        $usersTable = TableRegistry::get('Users');

        if (isset($dataAlerts['is_repeated']))
            $alertData['is_repeated'] = $dataAlerts['is_repeated'];
        if (isset($dataAlerts['interval']))
            $alertData['interval_value'] = $dataAlerts['interval'];
        if (isset($dataAlerts['interval_type']))
            $alertData['interval_type'] = $dataAlerts['interval_type'];
        $alertData['user_id'] = $dataAlerts['user_id'];

        if (isset($dataAlerts['alert_id']) && $dataAlerts['alert_id'] != '') {
            $alerts = $this->get($dataAlerts['alert_id']);
            $responce['msg'] = 'Alerts has been updated successfully.';
        } else {
            $alerts = $this->newEntity($alertData);
            $responce['msg'] = 'Alerts has been added successfully.';
        }
        $alerts = $this->patchEntity($alerts, $alertData, ['validate' => 'Add']);

        if (!$alerts->errors()) {
            $success = $this->save($alerts);


            $cronAlertMailsTable = TableRegistry::get('CronAlertMails');
            $cronAlertMailsTable->saveCronAlert($success->id);
            $alertPermit['alert_id'] = $success->id;

            if (isset($dataAlerts['form_id'])) {
                $alertPermitsTable = TableRegistry::get('AlertPermits');
                $alertPermit['form_id'] = $dataAlerts['form_id'];
                $alertPermit['user_id'] = $dataAlerts['user_id'];
                if (isset($dataAlerts['form_permit_id'])) {
                    $alertPermits = $alertPermitsTable->get($dataAlerts['form_permit_id']);
                } else {
                    $alertPermits = $alertPermitsTable->newEntity();
                }
                $alertPermitsTable->patchEntity($alertPermits, $alertPermit);
                $successAlertPermit = $alertPermitsTable->save($alertPermits);
                $responce['permit_id'] = $dataAlerts['form_id'];
            }
            /* code for save alert company */

            if (!empty($dataAlerts['company_id']) && $dataAlerts['alert_type_id'] == 3) {
                $alertCompaniesTable = TableRegistry::get('AlertCompanies');
                $dataAlerts['alert_id'] = $success->id;
                $alertsComapny = $alertCompaniesTable->saveAlertCompany($dataAlerts, $dataAlerts['notes']);
            }
            /* code for save alert Staff */
            if (!empty($dataAlerts['staff_id']) && $dataAlerts['alert_type_id'] == 2) {
                $alertStaffsTable = TableRegistry::get('AlertStaffs');
                $conditionSample = array('AlertStaffs.alert_id' => $dataAlerts['alert_id']);
                $alertStaffsTable->deleteAll($conditionSample, false);

                foreach ($dataAlerts['staff_id'] as $key => $value) {
                    $staff['user_id'] = $value;
                    $staff['created'] = date('Y-m-d');
                    $staff['alert_id'] = $success->id;
                    $staff['alert_type_id'] = $dataAlerts['alert_type_id'];
                    $staffs = $alertStaffsTable->newEntity();
                    $alertStaffsTable->patchEntity($staffs, $staff);
                    $successAlertStaff = $alertStaffsTable->save($staffs);
                }
            }
            /* code for save alert industry */
            if (!empty($dataAlerts['operation_id']) && $dataAlerts['alert_type_id'] == 4) {

                $alertOperationsTable = TableRegistry::get('AlertOperations');
                if (isset($dataAlerts['alert_id']) && $dataAlerts['alert_id'] != '') {
                    $conditionSample = array('AlertOperations.alert_id' => $dataAlerts['alert_id']);
                    $alertOperationsTable->deleteAll($conditionSample, false);
                }

                foreach ($dataAlerts['operation_id'] as $key => $value) {
                    $operation['operation_id'] = $value;
                    $operation['created'] = date('Y-m-d');
                    $operation['alert_id'] = $success->id;
                    $operation['alert_type_id'] = $dataAlerts['alert_type_id'];
                    $operations = $alertOperationsTable->newEntity();
                    $alertOperationsTable->patchEntity($operations, $operation);
                    $successAlertOperation = $alertOperationsTable->save($operations);
                }
                $responce['operation_id'] = $successAlertOperation->operation_id;
            }




            $responce['flag'] = true;
            $responce['alert_id'] = $success->id;
        } else {
            $responce['flag'] = false;
            $responce['error'] = $this->Custom->multipleFlash($alerts->errors());
        }
        return $responce;
    }

}

?>
