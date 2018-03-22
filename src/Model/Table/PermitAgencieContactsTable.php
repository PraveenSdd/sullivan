<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitAgencieContactsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_agencie_contacts');
        
         $this->belongsTo('AgencyContacts', [
            'className' => 'AgencyContacts',
            'foreignKey' => 'agency_contact_id',
            'conditions' => ['AgencyContacts.is_active'=>1,'AgencyContacts.is_deleted'=>0]
        ]);
    }
    
    /**
     * 
     * @param type $permitId
     * @param type $agencyId
     * @return type
     */
    public function getAllContactIdByPermitAgencyId($permitAgencyId) {
        $permitAgenctContactList = $this->find('list', ['valueField' => 'agency_contact_id']);
        $permitAgenctContactList->hydrate(false)->select(['PermitAgencieContacts.agency_contact_id'])->where(['PermitAgencieContacts.permit_agency_id' => $permitAgencyId]);
        return $permitAgenctContactList->toArray();
    }
    
    /**
     * 
     * @param type $permitAgencyId
     * @param type $permitId
     * @param type $agencyId
     * @param type $contactIds
     */
    public function updateContacts($permitAgencyId,$permitId, $agencyId, $contactIds = []) {
        $existedPermitAgenctContactList = $this->getAllContactIdByPermitAgencyId($permitAgencyId);
        $deletedPermitAgenctContactList = $permitAgenctContactData = [];
        if (!empty($contactIds)) {
            $unsedPermitAgenctContactIds = [];
            foreach ($contactIds as $contact) {
                $permitAgenctContactData['agency_contact_id'] = $contact;
                $permitAgenctContactData['permit_agency_id'] = $permitAgencyId;
                $permitAgenctContactData['agency_id'] = $agencyId;
                $permitAgenctContactData['permit_id'] = $permitId;
                $permitAgenctContactData['is_active'] = 1;
                $permitAgenctContactData['is_deleted'] = 0;
                if (in_array($permitAgenctContactData['agency_contact_id'], $existedPermitAgenctContactList)) {
                    $permitAgenctContactData['id'] = array_search($permitAgenctContactData['agency_contact_id'], $existedPermitAgenctContactList);
                } else {
                    $permitAgenctContactData['id'] = $this->getIdByPermitAgencyAndContactId($permitAgencyId,$contact);
                }
                $permitAgenctContacts = null;
                if (!empty($permitAgenctContactData['id'])) {
                    $unsedPermitAgenctContactIds[$permitAgenctContactData['id']] = $permitAgenctContactData['id'];
                    $permitAgenctContacts = $this->get($permitAgenctContactData['id']);
                } else {
                    $permitAgenctContacts = $this->newEntity();
                }
                $this->patchEntity($permitAgenctContacts, $permitAgenctContactData);
                $this->save($permitAgenctContacts);
            }
            $deletedPermitAgenctContactList = array_diff_key($existedPermitAgenctContactList, $unsedPermitAgenctContactIds);
        } else {
            $deletedPermitAgenctContactList = $existedPermitAgenctContactList;
        }

        if ($deletedPermitAgenctContactList) {
            $deletedPermitAgenctContactList = array_flip($deletedPermitAgenctContactList);
            foreach ($deletedPermitAgenctContactList as $deletedId) {
                $this->updateAll(array('is_deleted' => 1, 'is_active' => 0), array('id' => $deletedId));
            }
        }
    }
    
   /**
    * 
    * @param type $permitAgencyId
    * @param type $contactId
    * @return type
    */
    public function getIdByPermitAgencyAndContactId($permitAgencyId,$contactId) {
        $permitAgnecyContactId = null;
        $permitAgenctContactData = $this->find()->hydrate(false)->select(['PermitAgencieContacts.id'])->where(['PermitAgencieContacts.permit_agency_id' => $permitAgencyId, 'PermitAgencieContacts.agency_contact_id' => $contactId])->first();
        if ($permitAgenctContactData) {
            $permitAgnecyContactId = $permitAgenctContactData['id'];
        }
        return $permitAgnecyContactId;
    }

    

}

?>
