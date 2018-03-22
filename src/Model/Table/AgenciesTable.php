<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;

class AgenciesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('agencies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        //$this->addBehavior('Tree');

        $this->hasOne('Addresses', [
            'className' => 'Addresses',
            'foreignKey' => 'agency_id',
            'conditions' => ['Addresses.is_active' => 1, 'Addresses.is_deleted' => 0, 'Addresses.agency_contact_id' => 0]
        ]);

        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );

        $this->hasMany('PermitAgencies', [
            'className' => 'PermitAgencies',
            'foreignKey' => 'agency_id',
            'conditions' => ['PermitAgencies.is_active' => 1, 'PermitAgencies.is_deleted' => 0]
        ]);
        $this->hasMany('AgencyContacts', [
            'className' => 'AgencyContacts',
            'foreignKey' => 'agency_id',
            'conditions' => ['AgencyContacts.is_active' => 1, 'AgencyContacts.is_deleted' => 0]
        ]);
    }

    /**
     * 
     * @param type $agencyId
     * @return type
     */
    public function getIdByName($name) {
        $agencyId = null;
        $agencyData = $this->find()->hydrate(false)->select(['Agencies.id'])->where(['LOWER(Agencies.name) LIKE' => '%' . strtolower($name) . '%', 'Agencies.is_active' => 1, 'Agencies.is_deleted' => 0])->first();
        if ($agencyData) {
            $agencyId = $agencyData['id'];
        }
        return $agencyId;
    }

    /**
     * 
     * @param type $agencyData
     * @param type $agencyId
     */
    public function saveAgencyData($agencyData, $agencyId = null) {
        $responce['flag'] = false;
        $responce['msg'] = '';
        // Get Agency-Id by name if id is empty
        if (empty($agencyId)) {
            $agencyId = $this->getIdByName($agencyData['Agency']['name']);
        }

        # Save agency-data
        $agencies = [];
        $agencyData['Agency']['slug'] = $agencyData['Agency']['name'];

        if ($agencyId) {
            $agencies = $this->get($agencyId);
        } else {
            $agencyData['Agency']['added_by'] = Configure::read('LoggedCompanyId');
            $agencies = $this->newEntity();
        }
        $agencyData['Agency']['modified_by'] = Configure::read('LoggedUserId');
        $agencies = $this->patchEntity($agencies, $agencyData['Agency'], ['validate' => 'Add']);
        if (!$agencies->errors()) {
            # Check validation
            if ($this->checkRules($agencies)) {
                if ($agencies = $this->save($agencies)) {
                    $agencyId = $agencies->id;
                    # Save agency-address-data
                    $this->Addresses = TableRegistry::get('Addresses');
                    $this->Addresses->saveAgencyAddress($agencyId, $agencyData['Address']);
                    $responce['msg'] = 'Agency has been saved successfully.';
                    $responce['flag'] = true;
                    $responce['agency_id'] = $agencyId;
                } else {
                    $responce['msg'] = 'Agency could not be saved';
                }
            } else {
                $responce['msg'] = 'Agency name already exits';
            }
        } else {
            $responce['msg'] = $agencies->errors();
        }
        return $responce;
    }

    /**
     * 
     * @return array list
     */
    public function getList() {
        $agencyList = $this->find('list', ['valueField' => 'name']);
        $agencyList->hydrate(false)->select(['Agencies.name'])->where(['Agencies.is_deleted' => 0, 'Agencies.is_active' => 1]);
        return $agencyList->toArray();
    }

    /*
     * Function:checkAgencyUniqueName()
     * Description: use for check Unique agency/agency by ajax
     * By @Ahsan Ahamad
     * Date : 13th Jan. 2018
     */

    public function checkAgencyUniqueName($agencyName = null, $agencyId = null, $parentId = null) {
        $responseFlag = false;
        $conditions = array('LOWER(Agencies.name)' => strtolower($agencyName), 'Agencies.is_deleted' => 0);
        if ($agencyId) {
            $conditions['Agencies.id !='] = $agencyId;
        }

        $agency = $this->find()->select(['name', 'id'])->where($conditions)->first();

        if ($agency) {
            $responseFlag = false;
        } else {
            $responseFlag = true;
        }
        return $responseFlag;
    }

    /*
     * validationAdd() use for check validation agency/agency
     * By @Ahsan Ahamad
     * Date : 13th Jan. 2018
     */

    public function validationAdd(Validator $validator) {

        $validator
                ->notEmpty('name', 'Agency name cannot be empty');

        return $validator;
    }

    /*
     * buildRules() use for check Unique agency/agency
     * By @Ahsan Ahamad
     * Date : 13th Jan. 2018
     */

// public function buildRules(RulesChecker $rules){
//        
//        $rules->add($rules->isUnique(['name'], 'Agencies name already exits'));
//         
//        return $rules;
//    }

    public function saveAgencyAndAddress() {

        $agencies = $this->newEntity();
        $agencyData['slug'] = strtolower(
                preg_replace(
                        "![^a-z0-9]+!i", "-", $agencyData['name']
                )
        );

        $agency['name'] = $agencyData['name'];
        $this->patchEntity($agencies, $agency, ['validate' => 'Add']);
        if (!$agencies->errors()) {
            if ($this->checkRules($agencies)) {
                if ($success = $this->save($agencies)) {
// code for add agency address
                    $address['address1'] = trim($agencyData['address1']);
                    $address['address2'] = trim($agencyData['address2']);
                    $address['city'] = trim($agencyData['city']);
                    $address['state_id'] = $agencyData['state_id'];
                    $address['zipcode'] = trim($agencyData['zipcode']);
                    $address['phone'] = $agencyData['phone'];
                    $address['phone_extension'] = $agencyData['phone_extension'];

                    $addresses = $this->Addresses->newEntity();
                    $this->Addresses->patchEntity($addresses, $address);
                    $successAddress = $this->Addresses->save($addresses);

                    $this->Flash->success(__('Agencies has been saved successfully.'));
                    return $this->redirect(['controller' => 'Agencies', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Agencies could not be saved'));
                }
            } else {
                $this->Flash->error(__('Agencies name already exits'));
            }
        } else {
            $this->Flash->error(__($this->Custom->multipleFlash($agencies->errors())));
        }
    }

}

?>
