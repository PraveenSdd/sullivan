<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class AgencyContactsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('agency_contacts');

        $this->hasMany('Addresses', [
            'className' => 'Addresses',
            'foreignKey' => 'agency_contact_id'
        ]);
    }

    /**
     * 
     * @return array list
     */
    public function getList() {
        $agencyContactList = $this->find('list');
        $agencyContactList->hydrate(false)->where(['AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1]);
        return $agencyContactList->toArray();
    }

    /**
     * 
     * @param int $agencyId
     * @return array list
     */
    public function getListByAgencyId($agencyId) {
        $agencyContactList = $this->find('list');
        $agencyContactList->hydrate(false)->where(['AgencyContacts.agency_id' => $agencyId, 'AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1]);
        return $agencyContactList->toArray();
    }

}

?>
