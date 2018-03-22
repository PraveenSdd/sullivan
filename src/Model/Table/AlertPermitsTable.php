<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class AlertPermitsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('alert_permits');
        $this->belongsTo(
                'Alerts', [
            'className' => 'Alerts',
            'foreignKey' => 'alert_id'
        ]);

        $this->belongsTo(
                'Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id'
                ]
        );
    }

    /**
     *      
     * @param type $alertId
     * @param array $data
     * 
     */
    public function saveData($alertId, $permitId, $userPermitId, $userPreviousPermitDocumentId) {
        $alertPermit['alert_id'] = $alertId;
        $alertPermit['permit_id'] = $permitId;
        $alertPermit['is_active'] = 1;
        $alertPermit['is_deleted'] = 0;
        $alertPermit['user_permit_id'] = $userPermitId;
        $alertPermit['user_previous_permit_document_id'] = $userPreviousPermitDocumentId;
        $alertPermit['added_by'] = Configure::read('LoggedUserId');
        $alertPermits = $this->newEntity();
        $alertPermits = $this->patchEntity($alertPermits, $alertPermit);
        $this->save($alertPermits);
    }

    /**
     * 
     * @param int $alertId
     * @param int $permitId
     * @return null/int
     */
    public function getIdByAlertAndPermitId($alertId, $permitId) {
        $alertPermitId = null;
        $alertPermitData = $this->find()->hydrate(false)->select(['AlertPermits.id'])->where(['AlertPermits.alert_id' => $alertId, 'AlertPermits.permit_id' => $permitId])->first();
        if ($alertPermitData) {
            $alertPermitId = $alertPermitData['id'];
        }
        return $alertPermitId;
    }

    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getDataByPermitId($permitId) {
        return $this->find()->contain(['Alerts', 'Alerts.AlertStaffs', 'Alerts.AlertCompanies', 'Alerts.AlertOperations'])->where(['AlertPermits.permit_id' => $permitId, 'AlertPermits.is_active' => 1, 'AlertPermits.is_deleted' => 0])->all();
    }

}

?>
