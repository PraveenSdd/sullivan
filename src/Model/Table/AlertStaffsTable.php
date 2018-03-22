<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class AlertStaffsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_staffs');
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
            $alertStaff = [];
            $alertStaff['alert_id'] = $alertId;
            $alertStaff['user_id'] = $value;
            $alertStaff['is_active'] = 1;
            $alertStaff['is_deleted'] = 0;
            $alertStaff['id'] = $this->getIdByAlertAndUserId($alertStaff['alert_id'], $alertStaff['user_id']);
            
            $alertStaffs = [];
            if (!empty($alertStaff['id'])) {

                $alertStaffs = $this->get($alertStaff['id']);
            } else {                
                $alertStaff['added_by'] = Configure::read('LoggedUserId');
                $alertStaffs = $this->newEntity();
            }
            $alertStaffs = $this->patchEntity($alertStaffs, $alertStaff);
            $this->save($alertStaffs);
        }
    }

    /**
     * 
     * @param int $alertId
     * @param int $userId
     * @return null/int
     */
    public function getIdByAlertAndUserId($alertId, $userId) {
        $alertStaffId = null;
        $alertStaffData = $this->find()->hydrate(false)->select(['AlertStaffs.id'])->where(['AlertStaffs.alert_id' => $alertId, 'AlertStaffs.user_id' => $userId])->first();
        if ($alertStaffData) {
            $alertStaffId = $alertStaffData['id'];
        }
        return $alertStaffId;
    }

    public function saveAlertStaff($staff = null) {
        if (!empty($staff['alert_id'])) {
            $conditionSample = array('AlertStaffs.alert_id' => $staff['alert_id']);
            $this->deleteAll($conditionSample, false);
        }

        foreach ($staff['staff_id'] as $key => $value) {
            $staff['user_id'] = $value;
            $staff['created'] = date('Y-m-d');
            $staff['alert_id'] = $staff['alert_id'];
            $staff['alert_type_id'] = $staff['alert_type_id'];
            $staffs = $this->newEntity();
            $this->patchEntity($staffs, $staff);
            $savedStaff = $this->save($staffs);
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
     * @return type
     */
    public function getUserIdListForEmail($alertId,$userId) {
        $userIdList = $this->find('list', ['keyField' => 'id', 'valueField' => 'user_id']);
        $userIdList->hydrate(false)->select(['id', 'user_id'])->where(['AlertStaffs.alert_id' => $alertId, 'AlertStaffs.is_deleted' => 0, 'AlertStaffs.is_active' => 1]);
        $userIdList = $userIdList->toArray();
        if(empty($userIdList)){
            $this->Users = TableRegistry::get('Users');
            $userIdList = $this->Users->getStaffIdList($userId);
        }
        $userIdList[] = 1;
        return $userIdList;
    }

}

?>
