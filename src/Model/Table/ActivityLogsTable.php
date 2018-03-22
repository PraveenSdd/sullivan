<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class ActivityLogsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('activity_logs');
        
//        $this->belongsTo('Users', [
//            'className' => 'Users',
//            'foreignKey' => 'user_id'
//        ]);
//        $this->belongsTo('AddedBy', [
//            'className' => 'Users',
//            'foreignKey' => 'added_by'
//        ]);
    }


    public function log($user_id = null, $message = null,$module_id = null,$sub_module_id = null,$module_name = null, $sub_module_name = null,$url = null){
        $log = $this->newEntity();        
        $log->message = $message;
        $log->module_id = $module_id;
        $log->sub_module_id = $sub_module_id;
        $log->module_name = $module_name;
        $log->sub_module_name = $sub_module_name;
        $log->url = $url;
        $log->activity = $sub_module_name;
        $log->created = date('Y-m-d h:i:s');
        $log->user_id = Configure::read('LoggedCompanyId');
        $log->added_by = Configure::read('LoggedUserId');
        if (in_array(Configure::read('LoggedRoleId'), array(1, 4))) {
                $log->is_admin = 1;
            } else {
                $log->is_admin = 0;
            }
        if ($this->save($log)) {
            return true;
        }
        return false;
    }
    
    /**
     * 
     * @param int $deadlineId
     * @return type
     */
    public function getAllDataById($activityLogId){
        return $this->find()->contain(['Users','AddedBy'])->where(['ActivityLogs.id' => $activityLogId])->first();
    }
    
    /**
     * 
     * @param int $deadlineId
     * @return type
     */
    public function getDataById($activityLogId){
        return $this->find()->where(['ActivityLogs.id' => $activityLogId])->first();
    }

}

?>
