<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class AlertCompaniesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_companies');
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ]);
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
    public function saveData($alertId,$data) {
        foreach ($data as $key => $value) {
            $alertCompany = [];
            $alertCompany['alert_id'] = $alertId;
            $alertCompany['user_id'] = $value;
            $alertCompany['is_active'] = 1;
            $alertCompany['is_deleted'] = 0;
            $alertCompany['id'] = $this->getIdByAlertAndUserId($alertCompany['alert_id'], $alertCompany['user_id']);
            
            $alertCompanies = [];
            if (!empty($alertCompany['id'])) {

                $alertCompanies = $this->get($alertCompany['id']);
            } else {                
                $alertCompany['added_by'] = Configure::read('LoggedUserId');
                $alertCompanies = $this->newEntity();
            }
            $alertCompanies = $this->patchEntity($alertCompanies, $alertCompany);
            $this->save($alertCompanies);
        }
    }
    

    /**
     * 
     * @param int $alertId
     * @param int $userId
     * @return null/int
     */
    public function getIdByAlertAndUserId($alertId, $userId) {
        $alertCompanyId = null;
        $alertCompanyData = $this->find()->hydrate(false)->select(['AlertCompanies.id'])->where(['AlertCompanies.alert_id' => $alertId, 'AlertCompanies.user_id' => $userId])->first();
        if ($alertCompanyData) {
            $alertCompanyId = $alertCompanyData['id'];
        }
        return $alertCompanyId;
    }
    
    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getUserIdListForEmail($alertId,$userId) {
        $userIdList = $this->find('list', ['valueField' => 'user_id']);
        $userIdList->hydrate(false)->select(['AlertCompanies.alert_id'])->where(['AlertCompanies.is_deleted' => 0, 'AlertCompanies.is_active' => 1, 'AlertCompanies.alert_id' => $alertId]);
        $userIdList =  $userIdList->toArray();
        if(!empty($userIdList)){
            $this->Users = TableRegistry::get('Users');
            $staffIdList = $this->Users->getStaffIdList($userIdList);
            $userIdList = array_merge($userIdList,$staffIdList);
        }
        return $userIdList;
    }
    

    /**
     * 
     * @param type $operationId
     * @return type
     */
    public function getCompanyIdByAlertId($alertId) {
        $userList = $this->find('list', ['valueField' => 'user_id']);
        $userList->hydrate(false)->select(['AlertCompanies.alert_id'])->where(['AlertCompanies.is_deleted' => 0, 'AlertCompanies.is_active' => 1, 'AlertCompanies.alert_id IN' => $alertId]);
        return $userList->toArray();
    }
    
    public function getCompanyAndEmployeeEmail($companyId = null, $notes = null){
        $emailTemplatesTable = TableRegistry::get('EmailTemplates');
        $templateId = 2;
        $emailTemplate = $emailTemplatesTable->find()->where(['EmailTemplates.id' => $templateId])->first();
        $emailData = $emailTemplate->description;
        $emailData = str_replace('{NOTE}', @$notes, $emailData);
        $subject = $emailTemplate->subject;
           $company = $this->Users->find()->contain(['Employees'])->select(['Users.email', 'Users.id','Users.first_name'])->where(['Users.id' => $companyId])->first();
            foreach ($company->employees as $employee) {
                                    
                if ($employee->last_name) {
                    $fullName = $employee->first_name . " " . $employee->last_name;
                } else {
                    $fullName = $user->first_name;
                }
                $emailData = str_replace('{USER_NAME}', $fullName, $emailData);
                $to = $employee->email;
                $sendEmail = $this->_sendSmtpMail($subject, $emailData, $to);
                
            }
             return true;
           
    }

    /**
     * @Function: saveAlertCompany();
     * @description: This function use for save alert related company
     * @param type $company
     * @return boolean
     */
    
    public function saveAlertCompany($company = null,$notes){
            if (!empty($company['alert_id'])) {
                $conditionSample = array('AlertCompanies.alert_id' => $company['alert_id']);
                $this->deleteAll($conditionSample, false);
            }
        foreach ($company['company_id'] as $key => $value) {
            $company['company_id'] = $value;
            $company['created'] = date('Y-m-d');
            $company['alert_id'] = $company['alert_id'];
            $company['alert_type_id'] = $company['alert_type_id'];
            $companies = $this->newEntity();
            $this->patchEntity($companies, $company);
            $savedCompany = $this->save($companies);
            if($savedCompany){
                $details = $this->getCompanyAndEmployeeEmail($value,$notes);
               
                 $responce['flag'] = true;
               
            }else{
                 $responce['flag'] = true;
            }
        }
       return $responce;
        
    }
}

?>
