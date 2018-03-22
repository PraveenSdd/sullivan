<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PermitAgenciesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_agencies');
        
        $this->belongsTo('Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id',
            'conditions' => ['Permits.is_active' => 1, 'Permits.is_deleted' => 0]
        ]);
        
        $this->belongsTo('Agencies', [
            'className' => 'Agencies',
            'foreignKey' => 'agency_id',
            'conditions' => ['Agencies.is_active' => 1, 'Agencies.is_deleted' => 0]
        ]);

        $this->hasMany('PermitAgencyContacts', [
            'className' => 'PermitAgencyContacts',
            'foreignKey' => 'permit_agency_id',
            'conditions' => ['PermitAgencyContacts.is_active' => 1, 'PermitAgencyContacts.is_deleted' => 0]
        ]);


        
        
        
    }

    public function getAgencyDetails($permitId){

         return $this->find()->contain(['Agencies','Agencies.Addresses','Agencies.Addresses.States','PermitAgencyContacts.AgencyContacts','PermitAgencyContacts.AgencyContacts','PermitAgencyContacts.AgencyContacts.Addresses.States'])->where(['PermitAgencies.permit_id' => $permitId, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->first();

    }

    /**
     * 
     * @param int $permitId
     * @param int $agencyId
     * @return int id
     */
    public function getIdByPermitAndAgenyId($permitId, $agencyId) {
        $permitAgnecyId = null;
        $permitAgnecyData = $this->find()->hydrate(false)->select(['PermitAgencies.id'])->where(['PermitAgencies.permit_id' => $permitId, 'PermitAgencies.agency_id' => $agencyId, 'PermitAgencies.is_active' => 1, 'PermitAgencies.is_deleted' => 0])->first();
        if ($permitAgnecyData) {
            $permitAgnecyId = $permitAgnecyData['id'];
        }
        return $permitAgnecyId;
    }

    /**
     * 
     * @return array list
     */
    public function getAssignedPermitList() {
        $permitsList = $this->find('list', ['keyField' => 'permit_id', 'valueField' => 'permit_id']);
        $permitsList->hydrate(false)->where(['PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1]);
        return $permitsList->toArray();
    }
    
    /**
     * 
     * @param array $data
     * @return array
     */
    public function saveRelatedData($data) {
        $responseFlag['flag'] = false;
        $responseFlag['msg'] = '';
        if (empty($data['permit_id'])) {
            $responseFlag['msg'] = 'Permit is not selected!';
        } else if (empty($data['agency_id'])) {
            $responseFlag['msg'] = 'Agency is not selected!';
        } else {
            $permitAgencyData['permit_id'] = $data['permit_id'];
            $permitAgencyData['agency_id'] = $data['agency_id'];
            if ($data['permit_agency_id']) {
                $permitAgencyData['id'] = $data['permit_agency_id'];
            } else {
                $permitAgencyData['id'] = $this->getIdByPermitAndAgenyId($permitAgencyData['permit_id'], $permitAgencyData['agency_id']);
            }

            $permitAgencies = [];
            if (!empty($permitAgencyData['id'])) {
                $permitAgencies = $this->get($permitAgencyData['id']);
            } else {
                $permitAgencyData['added_by'] = Configure::read('LoggedCompanyId');
                $permitAgencies = $this->newEntity();
            }
            $this->patchEntity($permitAgencies, $permitAgencyData);
            if ($permitAgencies = $this->save($permitAgencies)) {
                $responseFlag['flag'] = true;
                $responseFlag['permit_agency_id'] = $permitAgencies->id;
                $responseFlag['msg'] = 'Permit has been added successfully!';
                $this->PermitAgencyContacts = TableRegistry::get('PermitAgencyContacts');
                if (!empty($data['contact_person'][0])) {
                    $this->PermitAgencyContacts->updateContacts($permitAgencies->id, $permitAgencyData['permit_id'], $data['contact_person']);
                } else {
                    $this->PermitAgencyContacts->updateContacts($permitAgencies->id, $permitAgencyData['permit_id']);
                }
            } else {
                $responseFlag['msg'] = 'Permit could not be added!';
            }
        }
        return $responseFlag;
    }
    
    /**
     * 
     * @param type $permitId
     */
    public function getDataByPermitId($permitId){
        return $this->find()->contain(['Agencies', 'PermitAgencyContacts.AgencyContacts'])->where(['PermitAgencies.permit_id' => $permitId, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->first();
    }

}

?>
