<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class CronAlertMailsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('cron_alert_mails');
        
        $this->belongsTo(
                'Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id'
        ]);
    }

   public function saveCronAlert($alertId = null){
        $cronAlert['alert_id'] = $alertId;
        $cronAlerts = $this->newEntity($cronAlert);
        $cronAlerts = $this->patchEntity($cronAlerts, $cronAlert);
        if($this->save($cronAlerts)){
              return  true;  
        }else{
            return false;
        }
       
   }

}

?>
