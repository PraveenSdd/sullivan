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
        $this->hasMany('Staff', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ]);

        $this->hasOne('UserLocations', [
            'className' => 'UserLocations',
            'foreignKey' => 'user_id',
            'conditions' => ['UserLocations.is_company' => 1]
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

        $this->hasOne('AlertNotifications', [
            'className' => 'AlertNotifications',
            'foreignKey' => 'user_id'
        ]);
        $this->belongsTo('EditedBy', [
            'className' => 'Users',
            'foreignKey' => 'modified_by',
            'propertyName' => 'editedby',
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
                ->notEmpty('password', 'Please enter Confirm Password')
                ->add('password', ['length' => ['rule' => ['minLength', 8],
                        'message' => 'Password need to be at least 8 characters long',]])
                ->notEmpty('confirm_password', 'Please enter Password')
                ->add('confirm_password', [
                    'compare' => [
                        'rule' => ['compareWith', 'password'],
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
        $user = $this->find()->select(['email', 'id'])->where($conditions)->first();

        if ($user) {
            $responseFlag = false;
        } else {
            $responseFlag = true;
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
        $user = $this->find()->select(['company', 'id'])->where($conditions)->first();

        if ($user) {
            $responseFlag = false;
        } else {
            $responseFlag = true;
        }
        return $responseFlag;
    }

    public function getCompanyList($keyword = null) {
        $companies = $this->find('list', ['keyField' => 'id', 'valueField' => 'company']);
        $conditions = ['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.role_id' => 2];
        if ($keyword) {
            $conditions ['LOWER(Users.company) LIKE'] = "%" . strtolower(trim($keyword)) . "%";
        }
        $companies->hydrate(false)->select(['id', 'company'])->where($conditions);
        return $companies->toArray();
    }

    public function getCompanyInfo($userId = null) {
        $companyInfo['basic_info'] = $companyInfo['location_info'] = null;
        $conditions = ['Users.is_deleted' => 0, 'Users.id' => $userId];
        $companyInfo['basic_info'] = $this->find()->where($conditions)->first();
        $this->UserLocations = TableRegistry::get('UserLocations');
        if ($companyInfo['basic_info']->role_id == 2) {
            $companyInfo['location_info'] = $this->UserLocations->find()->where(['UserLocations.user_id' => $companyInfo['basic_info']->id, 'UserLocations.is_company' => 1])->first();
        } else {

            $companyInfo['basic_info']->logo = $this->getCompanyNameById($companyInfo['basic_info']->user_id);
            $companyInfo['location_info'] = $this->UserLocations->find()->where(['UserLocations.user_id' => $companyInfo['basic_info']->user_id, 'UserLocations.is_company' => 1])->first();
        }
        return $companyInfo;
    }

    public function getStaffList($authId, $roleId = null) {
        $companies = $this->find('list', ['keyField' => 'id', 'valueField' => 'first_name']);
        $companies->hydrate(false)->select(['id', 'first_name'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'user_id' => $authId]);
        return $companies->toArray();
    }

    /**
     * 
     * @param type $companyId
     * @return type
     */
    public function getStaffIdList($companyId) {
        $companies = $this->find('list', ['keyField' => 'id', 'valueField' => 'id']);
        if (is_array($companyId)) {
            $companies->hydrate(false)->select(['id', 'id'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'user_id IN' => $companyId]);
        } else {
            $companies->hydrate(false)->select(['id', 'id'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'user_id' => $companyId]);
        }
        return $companies->toArray();
    }

    /**
     * get email-id by users-id
     * @param type $userId
     * @return type
     */
    public function getEmailById($userId) {
        $email = '';
        $userData = $this->find()->select(['Users.email'])->where(array('Users.is_deleted' => 0, 'Users.id' => $userId))->first();
        if ($userData) {
            $email = $userData->email;
        }
        return $email;
    }

    /**
     * get email-id by users-id
     * @param type $userId
     * @return type
     */
    public function getLogoById($userId) {
        $logo = '';
        $userData = $this->find()->select(['Users.logo'])->where(array('Users.id' => $userId))->first();
        if ($userData) {
            $logo = $userData->logo;
        }
        return $logo;
    }

    /**
     * get company-name by users-id
     * @param type $userId
     * @return type
     */
    public function getCompanyNameById($userId) {
        $companyName = '';
        $userData = $this->find()->select(['Users.company'])->where(array('Users.is_deleted' => 0, 'Users.id' => $userId))->first();
        if ($userData) {
            $companyName = $userData->company;
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
        return $this->find()->select(['Users.first_name', 'Users.email', 'Users.email_verification', 'Users.token'])->where(array('Users.is_deleted' => 0, 'Users.id' => $userId))->first();
    }

    /**
     * get user-id by email-verification
     * @param type $userId
     * @return type
     */
    public function getIdByEmailVerification($emailVerification) {
        $emailVerfication = '';
        return $this->find()->select(['Users.id', 'Users.first_name', 'Users.email', 'Users.token'])->where(array('Users.is_deleted' => 0, 'Users.email_verification' => $emailVerification))->first();
    }

    /**
     * get user by role-id
     * @param type $role
     * @return type
     */
    public function getUserByRoleId($roleId) {
        return $this->find()->select(['Users.id', 'Users.first_name', 'Users.email'])->where(array('Users.is_deleted' => 0, 'role_id IN' => $roleId))->all();
    }

    /**
     * get user by id
     * @param type $role
     * @return type
     */
    public function getUserById($userId) {
        return $this->find()->select(['Users.id', 'Users.first_name', 'Users.email'])->where(array('Users.is_deleted' => 0, 'id IN' => $userId))->all();
    }

    /**
     * get user by id
     * @param type $role
     * @return type
     */
    public function getUserWithStaffByCompanyId($userId) {
        return $this->find()->select(['Users.id', 'Users.first_name', 'Users.email'])->where(['OR' => [
                        'Users.id IN' => $userId,
                        'Users.user_id IN' => $userId
                    ], "AND" => ['Users.is_deleted' => 0, 'Users.is_active' => 1]])->all();
    }

    /**
     * 
     * @return type
     */
    public function getSullivanStaffList() {
        $subAdminList = $this->find('list', ['keyField' => 'id', 'valueField' => 'first_name']);
        $subAdminList->hydrate(false)->select(['id', 'first_name'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.role_id' => 4]);
        return $subAdminList->toArray();
    }

    /**
     * 
     * @return type
     */
    public function getSullivanStaffIdList() {
        $subAdminList = $this->find('list', ['keyField' => 'id', 'valueField' => 'id']);
        $subAdminList->hydrate(false)->select(['id', 'id'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.role_id' => 4]);
        return $subAdminList->toArray();
    }

    /**
     * @description - Fetch Sullivan Staff list including Super admin
     * @return type
     */
    public function getSullivanPCList() {
        $sllivanPCList = $this->find('list', ['keyField' => 'id', 'valueField' => 'first_name']);
        $sllivanPCList->hydrate(false)->select(['id', 'first_name'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.role_id IN' => [1, 4]])->order(['Users.role_id' => 'ASC', 'Users.first_name' => 'ASC']);
        return $sllivanPCList->toArray();
    }

    /**
     * @description - Fetch Sullivan Staff list including Super admin
     * @return type
     */
    public function getSullivanPCIdList() {
        $sllivanPCList = $this->find('list', ['keyField' => 'id', 'valueField' => 'id']);
        $sllivanPCList->hydrate(false)->select(['id', 'id'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.role_id IN' => [1, 4]])->order(['Users.role_id' => 'ASC', 'Users.first_name' => 'ASC']);
        return $sllivanPCList->toArray();
    }

}

?>
