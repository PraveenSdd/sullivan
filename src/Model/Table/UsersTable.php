<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UsersTable extends Table {
    
    function initialize(array $config) {
    parent::initialize($config);
    
        $this->hasMany('Employees', [
          'className' => 'Users',
          'foreignKey' => 'user_id'
        ]);
        
        $this->hasOne('UserLocations', [
          'className' => 'UserLocations',
          'foreignKey' => 'user_id',
            'conditions' => ['UserLocations.is_company'=>1]
        ]);
        $this->hasMany('UserIndustries', [
          'className' => 'UserIndustries',
          'foreignKey' => 'user_id'
        ]);
        
        $this->belongsTo('CompanyDetails', [
          'className' => 'Users',
          'foreignKey' => 'user_id'
        ]);
        $this->hasOne('Addresses', [
          'className' => 'Addresses',
          'foreignKey' => 'user_id'
        ]);
        $this->hasOne('PermissionAccess', [
          'className' => 'PermissionAccess',
          'foreignKey' => 'user_id'
        ]);
    }

    public function validationDefault(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('email', 'Please enter your email address')
                ->add('email', 'valid-email', ['rule' => 'email', 'message' => 'Please enter a valid email address'])
                ->notEmpty('username', 'Please enter a username')
                ->add('username', 'valid-username', ['rule' => 'username', 'message' => 'Please enter a valid username'])
                ->notEmpty('first_name', 'Please enter a first name')
                ->notEmpty('company', 'Please enter  company')
                ->notEmpty('password', 'Please enter your password');

        return $validator;
    }
    public function validationStaff(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('email', 'Please enter your email address')
                ->add('email', 'valid-email', ['rule' => 'email', 'message' => 'Please enter a valid email address'])
                ->notEmpty('first_name', 'Please enter a first name')
                ->notEmpty('phone', 'Please enter  phone')
                ->notEmpty('permission_id', 'Please enter  permission')
                ->notEmpty('position', 'Please enter your position');

        return $validator;
    }
    
     public function validationChangePassword(Validator $validator) {
        $validator
                ->notEmpty('password','Please enter Confirm Password')
                ->add('password', ['length' => ['rule' => ['minLength', 8],
                    'message' => 'Password need to be at least 8 characters long',]])
                ->notEmpty('confirm_password','Please enter Password')
                ->add('confirm_password', [
                    'compare' => [
                    'rule' => ['compareWith','password'],
                    'message' => 'Confirm Password does not match with Password.'
                    ]]);
           
        return $validator;
    }
    
/* check Unique user email  email id */    
    
     public function checkUniqueEmail($email = null, $userId = null) {
        $responseFlag = false;
        $conditions = array('Users.email' => $email, 'Users.is_deleted' => 0); 
        if ($userId) {
            $conditions['Users.id !='] = $userId;
        }
        $user = $this->find()->select(['email','id'])->where($conditions)->first();
    
        if ($user) {
            $responseFlag =  false;
        } else {
            $responseFlag =  true;
        }
        return $responseFlag;
    }
   
/* check Unique user email  email id */    
    
     public function checkComapnyUnique($comapny = null, $userId = null) {
        $responseFlag = false;
        $conditions = array('Users.company' => $comapny, 'Users.is_deleted' => 0); 
        if ($userId) {
            $conditions['Users.id !='] = $userId;
        }
        $user = $this->find()->select(['company','id'])->where($conditions)->first();
    
        if ($user) {
            $responseFlag =  false;
        } else {
            $responseFlag =  true;
        }
        return $responseFlag;
    }
   
   
    public function getCompanyList($keyword=null){
        $companies = $this->find('list',['keyField' => 'id','valueField' => 'company']); 
        $conditions = ['Users.is_deleted' => 0, 'Users.is_active' => 1,'Users.role_id'=>2];        
        if($keyword){
            $conditions ['LOWER(Users.company) LIKE'] = "%".strtolower(trim($keyword))."%";
        }
        $companies->hydrate(false)->select(['id','company'])->where($conditions);
        return $companies->toArray();
    }
    public function getCompanyInfo($userId =null){
        $companyInfo['basic_info'] = $companyInfo['location_info'] = null;
        $conditions = ['Users.is_deleted' => 0, 'Users.role_id'=>2,'Users.id'=>$userId];        
        $companyData = $this->find()->contain(['UserLocations'])->where($conditions)->first();
        if($companyData){            
           $companyInfo['location_info']= $companyData['user_location'];  
           $companyInfo['basic_info']= $companyData;
           unset($companyInfo['basic_info']['user_location']);
        }
       return $companyInfo;
    }    
    
    
    public function getStaffList($authId = null,$roleId= null){
        $companies = $this->find('list',['keyField' => 'id','valueField' => 'first_name']);         
        $companies->hydrate(false)->select(['id','first_name','last_name'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1,'Users.role_id'=>$roleId, 'user_id'=>$authId]);       
        return $companies->toArray();
    }
    
    /**
     * get email-id by users-id
     * @param type $userId
     * @return type
     */
    public function getEmailById($userId) {        
        $email = '';
        $userData = $this->find()->select(['Users.email'])->where(array('Users.is_deleted' => 0,'Users.id'=>$userId))->first();
        if ($userData) {
            $email =  $userData->email;
        }        
        return $email;
    }
    
    /**
     * get company-name by users-id
     * @param type $userId
     * @return type
     */
    public function getCompanyNameById($userId) {        
        $companyName = '';
        $userData = $this->find()->select(['Users.company'])->where(array('Users.is_deleted' => 0,'Users.id'=>$userId))->first();
        if ($userData) {
            $companyName =  $userData->company;
        }        
        return $companyName;
    }

    /**
     * get email-verification-data by users-id
     * @param type $userId
     * @return type
     */
    public function getVerificationDataById($userId) {        
        $emailVerfication = '';
        return $this->find()->select(['Users.first_name','Users.email','Users.email_verification','Users.token'])->where(array('Users.is_deleted' => 0,'Users.id'=>$userId))->first();
    }

    /**
     * get user-id by email-verification
     * @param type $userId
     * @return type
     */
    public function getIdByEmailVerification($emailVerification) {        
        $emailVerfication = '';
        return $this->find()->select(['Users.id','Users.first_name','Users.email','Users.token'])->where(array('Users.is_deleted' => 0,'Users.email_verification'=>$emailVerification))->first();
    }
    
    

}

?>
