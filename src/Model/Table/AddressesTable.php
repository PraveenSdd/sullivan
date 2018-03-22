<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class AddressesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('addresses');

        $this->belongsTo('States', [
            'className' => 'States',
            'foreignKey' => 'state_id'
        ]);
    }

    /*
     * Function: validationAdd()
     * desription: Validation for add agency address
     * By:Ahsan Ahamad
     * Date: 12th Jan 2018
     */

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('address1', 'Title cannot be empty')
                ->notEmpty('city', 'City cannot be empty')
                ->notEmpty('state_id', 'State cannot be empty')
                ->notEmpty('zipcode', 'Zip code cannot be empty');
        //->notEmpty('phone', 'Phone number cannot be empty');
        return $validator;
    }

    /**
     * 
     * @param type $agencyId
     * @return type
     */
    public function getIdByAgencyAddressId($agencyId) {
        $addressId = null;
        $addressData = $this->find()->hydrate(false)->select(['Addresses.id'])->where(['Addresses.agency_id' => $agencyId, 'Addresses.agency_contact_id' => 0])->first();
        if ($addressData) {
            $addressId = $addressData['id'];
        }
        return $addressId;
    }

    /**
     * 
     * @param int $agencyId
     * @param array $addressData
     */
    public function saveAgencyAddress($agencyId, $addressData) {
        $addresses = null;
        $addressData['id'] = $this->getIdByAgencyAddressId($agencyId);
        if (!empty($addressData['id'])) {
            $addresses = $this->get($addressData['id']);
        } else {
            $addressData['added_by'] = Configure::read('LoggedCompanyId');
            $addressData['agency_id'] = $agencyId;
            $addresses = $this->newEntity();
        }
        $this->patchEntity($addresses, $addressData);
        $this->save($addresses);
    }

    /**
     * 
     * @param int $agencyId
     * @param int $agencyContactId
     * @param array $addressData
     */
    public function saveContactAddress($agencyId, $agencyContactId, $addressDataArray= []) {
        $this->deleteContactAddress($agencyContactId);
        for($count=0;$count<count($addressDataArray['id']); $count++){
            $addressData = $addresses = [];
            $addressData['id'] = $addressDataArray['id'][$count];
            $addressData['address1'] = $addressDataArray['address1'][$count];
            $addressData['address2'] = $addressDataArray['address2'][$count];
            $addressData['city'] = $addressDataArray['city'][$count];
            $addressData['state_id'] = $addressDataArray['state_id'][$count];
            $addressData['zipcode'] = $addressDataArray['zipcode'][$count];
            $addressData['is_deleted'] = 0;
            $addressData['is_active'] = 1;
            
            if (!empty($addressData['id'])) {
                $addresses = $this->get($addressData['id']);
            } else {
                $addressData['added_by'] = Configure::read('LoggedCompanyId');
                $addressData['agency_id'] = $agencyId;
                $addressData['agency_contact_id'] = $agencyContactId;
                $addresses = $this->newEntity();
            }
            $this->patchEntity($addresses, $addressData);
            $this->save($addresses);
            
        }
    }
    
    public function deleteContactAddress($agencyContactId) {
        return $this->updateAll(array('is_deleted'=>1), array('agency_contact_id'=>$agencyContactId));
    }

    /**
     * 
     * @param type $agencyId
     * @return type
     */
    public function getAgencyAddress($agencyId) {
        return $this->find()->hydrate(false)->where(['Addresses.agency_id' => $agencyId, 'Addresses.agency_contact_id' => 0, 'Addresses.is_deleted' => 0, 'Addresses.is_active' => 1])->first();
    }

    /**
     * 
     * @param type $agencyContactId
     * @return type
     */
    public function getContactAddress($agencyContactId) {
        return $this->find()->hydrate(false)->where(['Addresses.agency_contact_id' => $agencyContactId, 'Addresses.is_deleted' => 0, 'Addresses.is_active' => 1])->all();
    }

    public function addAddress($address = array()) {
        if ($address['address_id']) {
            $addresses = $this->get($address['address_id']);
        } else {
            $addresses = $this->newEntity();
        }
        $this->patchEntity($addresses, $address);
        $successAddress = $this->save($addresses);
    }

}

?>
