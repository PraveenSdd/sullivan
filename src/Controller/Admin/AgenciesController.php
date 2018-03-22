<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class AgenciesController extends AppController {

    /**
     * 
     */
    public function initialize() {
        parent::initialize();
    }

    /**
     * 
     */
    public function index() {
        $pageTitle = 'Manage Agencies';
        $pageHedding = 'Manage Agencies';
        $breadcrumb = array(
            array('label' => 'Manage Agencies'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $conditions = ['Agencies.is_deleted' => 0, 'Agencies.is_active' => 1];
        if (!empty($this->request->query)) {
            if (isset($this->request->query['name']) && $this->request->query['name'] != '') {
                $conditions['LOWER(Agencies.name) LIKE'] = '%' . strtolower(trim($this->request->query['name'])) . '%';
            }
            # Save searched value in search-form input-fields
            $this->request->data = $this->request->query;
        }

        $this->paginate = [
            'contain' => ['Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'conditions' => $conditions,
            'order' => ['Agencies.id' => 'DESC'],
            'limit' => $this->paginationLimit,
        ];
        $agencies = $this->paginate($this->Agencies);
        $this->set(compact('agencies'));
    }

    /**
     * 
     * @param type $agencyId
     * @return type
     */
    public function view($agencyId = null) {
        $this->set(compact('agencyId'));
        $pageTitle = 'View Agency';
        $pageHedding = 'View Agency';
        $breadcrumb = array(
            array('label' => 'Manage Agencies', 'link' => 'agencies/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $agencyId = $this->Encryption->decode($agencyId);
        $agency = $this->Agencies->find()->contain(['Addresses', 'PermitAgencies', 'PermitAgencies.Permits', 'AgencyContacts', 'AgencyContacts.Addresses', 'PermitAgencies.PermitAgencyContacts.AgencyContacts'])->where(['Agencies.id =' => $agencyId])->first();
        if (empty($agency)) {
            $this->Flash->error(__('Agency not available!'));
            return $this->redirect(['controller' => 'Agencies', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('agency'));

        /* get all US states list */
        $this->loadModel('States');
        $statesList = $this->States->getListByCountryId(254);
        $this->set(compact('statesList'));
        $redirectHere = '/admin/agencies/view/' . $this->Encryption->encode($agencyId);
        $this->set(compact('redirectHere'));
    }

    /**
     * 
     * @return type
     */
    public function add() {
        $pageTitle = 'Add Agency';
        $pageHedding = 'Add Agency';
        $breadcrumb = array(
            array('label' => 'Manage Agencies', 'link' => 'agencies/'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $this->loadModel('FormAgencies');
        $this->loadModel('AgencyContacts');

        if ($this->request->is('post')) {
            $response = $this->Agencies->saveAgencyData($this->request->data, $this->request->data['Agency']['id']);
            if ($response['flag']) {
                /* === Added by vipin for  add log=== */
                $message = 'Agency added by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['agency_id'];
                $saveActivityLog['table_name'] = 'agencies';
                $saveActivityLog['module_name'] = 'Agency';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Add';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__($response['msg']));
                return $this->redirect(['controller' => 'Agencies', 'action' => 'index', 'prefix' => 'admin']);
            } else {
                $this->Flash->error(__((is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg']));
            }
        }

        /* get all permit list */
        $this->loadModel('Permits');
        $permitsList = $this->Permits->getList();

        /*  get all us state  list */
        $this->loadModel('States');
        $statesList = $this->States->getListByCountryId(254);
        $this->set(compact('permitsList', 'statesList'));

        $this->set('_serialize', ['permitsList', 'statesList']);
    }

    /**
     * 
     * @param type $agencyId
     * @return type
     */
    public function edit($agencyId = null) {
        $this->set(compact('agencyId'));
        $pageTitle = 'Edit Agency';
        $pageHedding = 'Edit Agency';
        $breadcrumb = array(
            array('label' => 'Manage Agencies', 'link' => 'agencies/index'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $agencyId = $this->Encryption->decode($agencyId);
        $agency = $this->Agencies->find()->contain(['Addresses', 'PermitAgencies', 'PermitAgencies.Permits', 'AgencyContacts', 'AgencyContacts.Addresses', 'PermitAgencies.PermitAgencyContacts.AgencyContacts'])->where(['Agencies.id =' => $agencyId])->first();
        if (empty($agency)) {
            $this->Flash->error(__('Agency not available!'));
            return $this->redirect(['controller' => 'Agencies', 'action' => 'index', 'prefix' => 'admin']);
        }
        $this->set(compact('agency'));
        if ($this->request->is(['post', 'put'])) {
            $response = $this->Agencies->saveAgencyData($this->request->data, $agencyId);
            if ($response['flag']) {
                /* === Added by vipin for  add log=== */
                $message = 'Agency edit by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['agency_id'];
                $saveActivityLog['table_name'] = 'agencies';
                $saveActivityLog['module_name'] = 'Agency';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__($response['msg']));
                return $this->redirect(['controller' => 'Agencies', 'action' => 'index', 'prefix' => 'admin']);
            } else {
                $this->Flash->error(__((is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg']));
            }
        }

        /* get all permit list */
        $this->loadModel('Permits');
        $permitsList = $this->Permits->getList();

        /*  get all us state  list */
        $this->loadModel('States');
        $statesList = $this->States->getListByCountryId(254);
        $this->set(compact('permitsList', 'statesList'));
        $redirectHere = '/admin/agencies/edit/' . $this->Encryption->encode($agencyId);
        $this->set(compact('redirectHere'));
    }

    /**
     * 
     */
    public function saveAgencyData($agencyId = null) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('ajax')) {
            $response = $this->Agencies->saveAgencyData($this->request->data, $agencyId);
            $response['msg'] = (is_array($response['msg'])) ? $this->Custom->multipleFlash($response['msg']) : $response['msg'];
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /*
     * @Function:checkAgencyUniqueName()
     * @Description:use for get agency name is unique or not    
     * @By @Ahsan Ahamad
     * @Date : 6rd Nov. 2017
     */

    public function checkAgencyUniqueName($agencyName = null, $agencyId = null) {
        $this->autorander = FALSE;
        if (isset($this->request->data['name'])) {
            $agencyName = $this->request->data['name'];
        }
        if (isset($this->request->data['id'])) {
            $agencyId = $this->request->data['id'];
        }
        $nameStatus = $this->Agencies->checkAgencyUniqueName($agencyName, $agencyId);
        echo json_encode($nameStatus);
        exit;
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getContactListByAgencyId($agencyId = null) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        if ($this->request->is('post')) {
            $agencyContactList = $this->AgencyContacts->getListByAgencyId($this->request->data['agencyId']);
            //$listHtml = '<option value="">-- Select Contact Person -- </option>';
            $listHtml = '';
            foreach ($agencyContactList as $key => $value) {
                $listHtml .= '<option value="' . $key . '">' . htmlentities($value) . '</option>';
            }
            echo $listHtml;
            exit;
        }
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getReleateContact($agencyId) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        $agencyContacts = $this->AgencyContacts->find()->contain(['Addresses'])->where(['AgencyContacts.agency_id' => $agencyId, 'AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1])->all();
        // Render the json element 
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($agencyId));
        $this->set(compact('agencyContacts', 'redirectHere'));
        echo $this->render('/Element/backend/agency/contact_person_list');
        exit;
    }

    /**
     * 
     * @param type $agencyContacttId
     */
    public function getContactAddressByContactId($agencyContacttId = null) {
        $this->autoRender = false;
        $this->loadModel('Addresses');
        $addresses = $this->Addresses->getContactAddress($agencyContacttId);
        $this->loadModel('States');
        $statesList = $this->States->getListByCountryId(254);

        $this->set('addresses', $addresses);
        $this->set(compact('statesList', 'addresses'));
        echo $this->render('/Element/backend/agency/contact_addresses');
        exit;
    }

    /**
     * 
     * @param int $agencyId     
     */
    public function saveAgencyContact($agencyId) {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {
            # Save Agency-Contact Data
            $this->loadModel('AgencyContacts');
            $agencyContacts = [];
            if ($this->request->data['agency_contact_id']) {
                $this->request->data['AgencyContact']['id'] = $this->request->data['agency_contact_id'];
                $agencyContacts = $this->AgencyContacts->get($this->request->data['agency_contact_id']);
                $message = 'Agency Contact updated by ' . $this->loggedusername;
                $activity = 'Edit';
            } else {
                $this->request->data['AgencyContact']['added_by'] = Configure::read('LoggedCompanyId');
                $this->request->data['AgencyContact']['agency_id'] = $agencyId;
                $agencyContacts = $this->AgencyContacts->newEntity();
                $message = 'Agency Contact added by ' . $this->loggedusername;
                $activity = 'Add';
            }

            $this->AgencyContacts->patchEntity($agencyContacts, $this->request->data['AgencyContact']);
            if (!$agencyContacts->errors()) {
                if ($agencyContacts = $this->AgencyContacts->save($agencyContacts)) {
                    /* === Added by vipin for  add log=== */
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $agencyContacts->id;
                    $saveActivityLog['table_name'] = 'agency_contacts';
                    $saveActivityLog['module_name'] = 'Agency Related Contact Person';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = $activity;
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */

                    # Save Additional-Address for Agency-Contact
                    $this->loadModel('Addresses');
                    if (isset($this->request->data['Address'])) {

                        $this->Addresses->saveContactAddress($agencyId, $agencyContacts->id, $this->request->data['Address']);
                    } else {
                        $this->Addresses->deleteContactAddress($agencyContacts->id);
                    }

                    $response['flag'] = true;
                    $response['msg'] = 'Agency contact has been added successfully';
                } else {
                    $response['msg'] = 'Agency contact could not be added successfully';
                }
                $this->_updatedBy('Agencies', $agencyId);
            } else {
                $response['flag'] = false;
                $response['msg'] = $this->Custom->multipleFlash($agencyContacts->errors());
            }
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $agencyContactId
     */
    public function getAgencyContactInfoById($agencyContactId) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        $agencyCoatacts = null;
        if ($this->request->is('post')) {
            $agencyCoatacts = $this->AgencyContacts->find()->contain(['Addresses'])->where(['AgencyContacts.id' => $agencyContactId])->first();
            $this->loadModel('States');
            $statesList = $this->States->getListByCountryId(254);
            $this->set(compact('statesList'));
        }
        $this->set(compact('agencyCoatacts'));
        echo $this->render('/Element/backend/agency/contact_details');
        exit;
    }

    public function saveReleatedPermit() {
        $this->autorander = FALSE;
        $response['flag'] = false;
        $response['msg'] = '';

        if ($this->request->is('post')) {
            $this->loadModel('PermitAgencies');
            $response = $this->PermitAgencies->saveRelatedData($this->request->data);
            /* === Added by vipin for  add log=== */
            if (!empty($response['permit_agency_id'])) {
                if (!empty($this->request->data['permit_agency_id'])) {
                    $message = 'Agency Related Permit updated by ' . $this->loggedusername;
                    $activity = 'Edit';
                } else {
                    $message = 'Agency Related Permit added by ' . $this->loggedusername;
                    $activity = 'Add';
                }
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $response['permit_agency_id'];
                $saveActivityLog['table_name'] = 'permit_agencies';
                $saveActivityLog['module_name'] = 'Agency Related Permit';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = $activity;
                $this->Custom->saveActivityLog($saveActivityLog);
            }
            $this->_updatedBy('Agencies', $this->request->data['agency_id']);
            /* === Added by vipin for  add log=== */
        } else {
            $response['msg'] = 'Invalid request!';
        }
        echo json_encode($response);
        exit;
    }

    /**
     * 
     * @param type $agencyId
     */
    public function getReleatedPermit($agencyId) {
        $this->autoRender = false;
        $this->loadModel('PermitAgencies');
        $permitAgencies = $this->PermitAgencies->find()->contain(['Permits', 'PermitAgencyContacts.AgencyContacts'])->where(['PermitAgencies.agency_id' => $agencyId, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->all();
        $redirectHere = $this->Custom->getRedirectPath($this->referer('/', true), $this->referer(), $this->Encryption->encode($agencyId));
        $this->set(compact('permitAgencies', 'redirectHere'));
        echo $this->render('/Element/backend/agency/permit_list');
        exit;
    }

    # OLD ACTION


    /*
     * @Function:addAgencyConatct()
     * @Description:use for add new agency conatct person
     * @By @Ahsan Ahamad
     * @Date : 4th Jan. 2018
     */

    public function addAgencyConatct() {
        $this->autoRender = false;
        $response['flag'] = false;
        $response['msg'] = '';
        if ($this->request->is('post')) {

            $this->loadModel('AgencyContacts');
            $this->loadModel('Addresses');
            $this->request->data['added_by'] = $this->Auth->user('id');
            $contact['name'] = $this->request->data['name'];
            $contact['email'] = $this->request->data['email'];
            $contact['phone_extension'] = $this->request->data['phone_extension'];
            $contact['phone'] = $this->request->data['phone'];
            $contact['position'] = $this->request->data['position'];
            $contact['agency_id'] = $this->request->data['agency_id'];
            $contactId = $this->request->data['id'];

            if ($contactId != ' ') {
                $contacts = $this->AgencyContacts->get($this->request->data['id']);
                $response['msg'] = 'Agency contact has been updated successfully';
            } else {
                $contacts = $this->AgencyContacts->newEntity();
                $response['msg'] = 'Agency contact has been added successfully';
            }
            $this->AgencyContacts->patchEntity($contacts, $contact);
            if (!$contacts->errors()) {
                if ($contactSuccess = $this->AgencyContacts->save($contacts)) {
                    /*  code for add multiple address */
                    if (isset($this->request->data['id']) && trim($this->request->data['id']) != '') {
                        $conditionSample = array('Addresses.agency_contact_id' => $this->request->data['id']);
                        $this->Addresses->deleteAll($conditionSample, false);
                    }
                    if (isset($this->request->data['Address'])) {

                        $count = 0;
                        $count = count($this->request->data['Address']['address1']);

                        for ($number = 0; $number < $count; $number++) {

                            $addresses['agency_contact_id'] = $contactSuccess->id;
                            $addresses['agency_id'] = $contactSuccess->agency_id;
                            $addresses['address1'] = $this->request->data['Address']['address1'][$number];
                            $addresses['address2'] = $this->request->data['Address']['address2'][$number];
                            $addresses['city'] = $this->request->data['Address']['city'][$number];
                            $addresses['state_id'] = $this->request->data['Address']['state_id'][$number];
                            $addresses['zipcode'] = $this->request->data['Address']['zipcode'][$number];
                            $contactAddresses = $this->Addresses->newEntity($addresses);

                            $this->Addresses->patchEntity($contactAddresses, $addresses);
                            $contactAddresssSuccess = $this->Addresses->save($contactAddresses);
                        }
                    }
                    /* get all agency / agencies list */
                    $response['flag'] = true;
                    $response['agency_id'] = $this->request->data['agency_id'];
                    $response['contact_id'] = $contactSuccess->id;
                    if (!empty($this->request->data['permit_id'])) {
                        $response['permit_id'] = $this->request->data['permit_id'];
                    }
                } else {
                    $response['msg'] = 'Agency contact could not be added successfully';
                }
            } else {
                $response['flag'] = false;
                $response['msg'] = $this->Custom->multipleFlash($contacts->errors());
            }

            echo json_encode($response);
            exit;
        }
    }

    /*
     * @Function: getContactPerson()
     * @Description: use for get conatct person details related to agency
     * @By @Ahsan Ahamad
     * @Date : 14th Jan. 2018
     */

    public function getContactPerson($agencyContactId = null) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        if ($this->request->is('post')) {
            $agencyContactId = $this->request->data['personId'];
            $conatct = $this->AgencyContacts->find()->contain(['Addresses'])->where(['AgencyContacts.id' => $agencyContactId])->first();
            $this->set('conatct', $conatct);
            echo $this->render('/Element/backend/agency/contact_person_details');
            exit;
        }
    }

    /* @Function:getReleatedFormAttachment()
     * @Descrition:get forms attachmentmnt  document of the permit  
     * @param type $formId
     * @By @Ahsan Ahamad
     * @Date : 10 Dec. 2017
     */

    public function getPermitAgency($agencyId = null) {
        $this->autoRender = false;
        $this->loadModel('PermitAgencies');
        $agency['permit_agencies'] = $this->PermitAgencies->find()->contain(['Forms', 'PermitAgencyContacts.AgencyContacts'])->where(['PermitAgencies.agency_id' => $agencyId, 'PermitAgencies.is_deleted' => 0, 'PermitAgencies.is_active' => 1])->all();
        $subAdminDelete = $this->subAdminDelete;
        $subAdminAdd = $this->subAdminAdd;
        $subAdminEdit = $this->subAdminEdit;
        $this->set(compact('agency', 'subAdminDelete', 'subAdminAdd', 'subAdminEdit'));
        echo $this->render('/Element/backend/agency/permit_list');
        exit;
    }

}
