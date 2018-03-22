<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AlertNotificationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_notifications');
        $this->belongsTo(
                'Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id',
                ]
        );
        
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'users_id',
                ]
        );
    }

    /**
     * 
     * @param type $alertId
     * @return type
     */
    public function getUserAlertNotificationCount($userId) {
        return $this->find()->where(['is_active' => 1, 'is_deleted' => 0, 'is_readed' => 0, 'user_id' => $userId])->count();
    }

}
