<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UsersPermitLogsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('user_permit_logs');
        $this->belongsTo('PermitStatus', [
            'className' => 'PermitStatus',
            'foreignKey' => 'permit_status_id',
            'conditions' => ['PermitStatus.is_active' => 1, 'PermitStatus.is_deleted' => 0]
        ]);
        $this->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'added_by',
        ]);
    }

    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getUserPermitLog($userPermitId) {
        return $this->find()->hydrate(false)->select(['UsersPermitLogs.id','UsersPermitLogs.notes','UsersPermitLogs.modified','PermitStatus.title','Users.first_name','Users.last_name'])->contain(['PermitStatus','Users'])->where(['UsersPermitLogs.user_permit_id' => $userPermitId])->all();
    }

}

?>
