<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class PermitAgencyContactsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_agency_contacts');
        
         $this->belongsTo('AgencyContacts', [
            'className' => 'AgencyContacts',
            'foreignKey' => 'agency_contact_id',
            'conditions' => ['AgencyContacts.is_active'=>1,'AgencyContacts.is_deleted'=>0]
        ]);
    }
    
    /**
     *      
     * @param id $permitAgencyId
     * @return array list
     */
    public function getAllContactIdByPermitAgencyId($permitAgencyId) {
        $permitAgenctContactList = $this->find('list', ['valueField' => 'agency_contact_id']);
        $permitAgenctContactList->hydrate(false)->select(['PermitAgencyContacts.agency_contact_id'])->where(['PermitAgencyContacts.permit_agency_id' => $permitAgencyId]);
        return $permitAgenctContactList->toArray();
    }
    
    /**
     * 
     * @param type $permitAgencyId
     * @param type $permitId     
     * @param type $contactIds
     */
    public function updateContacts($permitAgencyId,$permitId, $contactIds = []) {
        $existedPermitAgenctContactList = $this->getAllContactIdByPermitAgencyId($permitAgencyId);
        $deletedPermitAgenctContactList = $permitAgenctContactData = [];
        if (!empty($contactIds)) {            
            $unsedPermitAgenctContactIds = [];
            foreach ($contactIds as $contact) {
                $permitAgenctContactData['agency_contact_id'] = $contact;
                $permitAgenctContactData['permit_agency_id'] = $permitAgencyId;
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
                    $permitAgenctContactData['added_by'] = Configure::read('LoggedCompanyId');
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
        $permitAgenctContactData = $this->find()->hydrate(false)->select(['PermitAgencyContacts.id'])->where(['PermitAgencyContacts.permit_agency_id' => $permitAgencyId, 'PermitAgencyContacts.agency_contact_id' => $contactId])->first();
        if ($permitAgenctContactData) {
            $permitAgnecyContactId = $permitAgenctContactData['id'];
        }
        return $permitAgnecyContactId;
    }

    

}

?>
