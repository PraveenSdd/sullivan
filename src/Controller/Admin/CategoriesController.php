<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class CategoriesController extends AppController {
    /* $paginate
     * @Description:use for ordering and limit data from data base
     * @By @Ahsan Ahamad
     * @Date : 22 setp. 2017
     */

    public $paginate = [
        'limit' => 50,
        'order' => [
            'Categories.name' => 'asc'
        ]
    ];

    public function initialize() {

        parent::initialize();
        if (!$this->request->getParam('admin') && $this->Auth->user('role_id') != 1) {
            return $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * @Function: index()
     * @Description: use for listing of data table
     * @By @Ahsan Ahamad
     * @Date : 2rd Nov. 2017
     */

    public function index() {

        $pageTitle = 'Manage Agencies';
        $pageHedding = 'Manage Agencies';
        $breadcrumb = array(
            array('label' => 'Manage Agencies'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $conditions = ['Categories.is_deleted' => 0, 'Categories.is_active' => 1];

        if (isset($this->request->query['name']) && $this->request->query['name'] != '') {
            $conditions['Categories.name LIKE'] = '%' . $this->request->query['name'] . '%';
        }

        if ($this->request->query) {
            $this->request->data = $this->request->query;
        }

        $this->paginate = [
            'conditions' => $conditions,
            'order' => ['Categories.name' => 'asc'],
            'limit' => 10,
        ];

        $categories = $this->paginate($this->Categories);

        $this->set(compact('categories'));
    }

    /*
     * @Function:Add()
     * @Description: use for create new records for multile form
     * @By @Ahsan Ahamad
     * @Date : 3rd Nov. 2017
     */

    public function add() {

        $pageTitle = 'Manage Agencies | Add';
        $pageHedding = 'Add Agencies';
        $breadcrumb = array(
            array('label' => 'Manage Agencies', 'link' => 'categories/index'),
            array('label' => 'Add'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('FormAgencies');
        $this->loadModel('AgencyContacts');
        $this->loadModel('Addresses');
        if ($this->request->is('post')) {
            $categories = $this->Categories->newEntity();
            $this->request->data['slug'] = strtolower(
                    preg_replace(
                            "![^a-z0-9]+!i", "-", $this->request->data['name']
                    )
            );

            $agency['name'] = $this->request->data['name'];
            $this->Categories->patchEntity($categories, $agency, ['validate' => 'Add']);
            if (!$categories->errors()) {
                if ($this->Categories->checkRules($categories)) {
                    if ($success = $this->Categories->save($categories)) {
// code for add agency address
                        $address['address1'] = trim($this->request->data['address1']);
                        $address['address2'] = trim($this->request->data['address2']);
                        $address['city'] = trim($this->request->data['city']);
                        $address['state_id'] = $this->request->data['state_id'];
                        $address['zipcode'] = trim($this->request->data['zipcode']);
                        $address['phone'] = $this->request->data['phone'];
                        $address['phone_extension'] = $this->request->data['phone_extension'];

                        $addresses = $this->Addresses->newEntity();
                        $this->Addresses->patchEntity($addresses, $address);
                        $successAddress = $this->Addresses->save($addresses);

                        $this->Flash->success(__('Agencies has been saved successfully.'));
                        return $this->redirect(['controller' => 'Categories', 'action' => 'index', 'prefix' => 'admin']);
                    } else {
                        $this->Flash->error(__('Agencies could not be saved'));
                    }
                } else {
                    $this->Flash->error(__('Agencies name already exits'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($categories->errors())));
            }
        }

        /* get all permit list */
        $this->loadModel('Forms');
        $permits = $this->Forms->find('list');
        $permits->hydrate(false)->where(['Forms.is_deleted' => 0, 'Forms.is_active' => 1]);
        $permitsList = $permits->toArray();
        /*  get all us state  list */
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();

        $this->set(compact('permitsList', 'statesList'));

        $this->set('_serialize', ['permitsList', 'statesList']);
    }

    /*
     * @Function:addAgencyConatct()
     * @Description:use for add new agency conatct person
     * @By @Ahsan Ahamad
     * @Date : 4th Jan. 2018
     */

    public function addAgencyConatct() {
        $this->autoRender = false;
        $responce['flag'] = false;
        $responce['msg'] = '';
        if ($this->request->is('post')) {

            $this->loadModel('AgencyContacts');
            $this->loadModel('Addresses');
            $this->request->data['added_by'] = $this->Auth->user('id');
            $contact['name'] = $this->request->data['name'];
            $contact['email'] = $this->request->data['email'];
            $contact['phone_extension'] = $this->request->data['phone_extension'];
            $contact['phone'] = $this->request->data['phone'];
            $contact['position'] = $this->request->data['position'];
            $contact['agency_id'] = $this->request->data['category_id'];
            $contactId = $this->request->data['id'];
            if ($contactId != ' ') {
                $contacts = $this->AgencyContacts->get($this->request->data['id']);
                $responce['msg'] = 'Agency contact has been updatedit successfully';
            } else {
                $contacts = $this->AgencyContacts->newEntity();
                $responce['msg'] = 'Agency contact has been added successfully';
            }
            $this->AgencyContacts->patchEntity($contacts, $contact);
            if (!$contacts->errors()) {
                if ($contactSuccess = $this->AgencyContacts->save($contacts)) {

                    /*  code for add multiple address */

                    if (!empty($this->request->data['address_id'])) {
                        $conditionSample = array('Addresses.agency_contact_id in' => $this->request->data['id']);
                        $this->Addresses->deleteAll($conditionSample, false);
                    }
                    $count = count($this->request->data['Address']['address1']);

                    for ($number = 0; $number < $count; $number++) {

                        $addresses['agency_contact_id'] = $contactSuccess->id;
                        $addresses['agency_id'] = $contactSuccess->agency_id;
                        $addresses['address1'] = $this->request->data['Address']['address1'][$number];
                        $addresses['address2'] = $this->request->data['Address']['address2'][$number];
                        $addresses['city'] = $this->request->data['Address']['city'][$number];
                        $addresses['state_id'] = $this->request->data['Address']['state_id'][$number];
                        $addresses['zipcode'] = $this->request->data['Address']['zipcode'][$number];
                        $addresses['phone_extension'] = $this->request->data['Address']['phone_extension'][$number];
                        $addresses['phone'] = $this->request->data['Address']['phone'][$number];


                        $contactAddresses = $this->Addresses->newEntity($addresses);

                        $this->Addresses->patchEntity($contactAddresses, $addresses);
                        $contactAddresssSuccess = $this->Addresses->save($contactAddresses);
                    }
                    /* get all category / agencies list */
                    $responce['flag'] = true;
                    $responce['category_id'] = $this->request->data['category_id'];
                    $responce['contact_id'] = $contactSuccess->id;
                    if (!empty($this->request->data['permit_id'])) {
                        $responce['permit_id'] = $this->request->data['permit_id'];
                    }
                } else {
                    $responce['msg'] = 'Agency contatct could not be added successfully';
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = $this->Custom->multipleFlash($contacts->errors());
            }

            echo json_encode($responce);
            exit;
        }
    }

    /*
     * @Function:getReleatedAgencyContact()
     * @Description:use for get all contact person related to agency
     * @By @Ahsan Ahamad
     * @Date : 5th Jan. 2018
     */

    public function getReleatedAgencyContact($categoryId = null) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        $category['contact'] = $this->AgencyContacts->find()->where(['AgencyContacts.agency_id' => $categoryId, 'AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1])->all();
        // Render the json element  
        $this->set('category', $category);
        echo $this->render('/Element/backend/agency/contact_list');
        exit;
    }

    /*
     * @Function: getReleatedAgencyContactAddress()
     * @Description: use for get all contact person address related to agency
     * @By: Ahsan Ahamad
     * @Date : 5th Jan. 2018
     */

    public function getReleatedAgencyContactAddress($contactId = null) {
        $this->autoRender = false;
        $this->loadModel('Addresses');
        $addresses = $this->Addresses->find()->hydrate(false)->where(['Addresses.agency_contact_id' => $contactId, 'Addresses.is_deleted' => 0, 'Addresses.is_active' => 1])->all();
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();

        $this->set('addresses', $addresses);
        $this->set('statesList', $statesList);
        echo $this->render('/Element/backend/agency/contact_address');
        exit;
    }

    /*
     * @Functon:saveAgencyData()
     * @Description: use for add new records by ajax
     * @By @Ahsan Ahamad
     * @Date : 5th Jan. 2018
     */

    public function saveAgencyData() {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $category['name'] = $this->request->data['name'];
            $category['short_description'] = $this->request->data['description'];
            $category['created'] = date('Y-m-d');
            $category['added_by'] = $this->Auth->user('id');
            $categories = $this->Categories->newEntity($category);
            $category['slug'] = strtolower(
                    preg_replace(
                            "![^a-z0-9]+!i", "-", $this->request->data['name']
                    )
            );
            $this->Categories->patchEntity($categories, $category, ['validate' => 'Add']);
            if (!$categories->errors()) {
                $successForm = $this->Categories->save($categories);
                if ($successForm) {
                    $responce['flag'] = true;
                    $responce['category_id'] = $successForm->id;
                    $responce['msg'] = 'Agency has been saved successfully.';
                } else {
                    $responce['flag'] = false;
                    $responce['msg'] = 'Agency could not be saved successfully.';
                }
            } else {
                $responce['flag'] = false;
                $responce['msg'] = $this->Custom->multipleFlash($categories->errors());
            }
            echo json_encode($responce);
            exit;
        }
    }

    /*
     * @Function:subAgencies()
     * @DEscription:use for get all of associated sub agency    
     * @By @Ahsan Ahamad
     * @Date : 6rd Nov. 2017
     */

    public function subAgencies($id = null) {
        $id = $this->Encryption->decode($id);

        $pageTitle = 'Agencies | Sub Agencies';
        $pageHedding = 'Sub Agencies';
        $breadcrumb = array(
            array('label' => 'Agencies', 'link' => 'categories/index'),
            array('label' => 'Sub Agency'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $conditions = [];

        if (isset($this->request->query['sub_category']) || isset($this->request->query['category']) || isset($this->request->query['is_active'])) {

            $data = array($this->request->query['category'], $this->request->query['sub_category']);

            if (!empty($this->request->query['is_active'])) {

                $conditions = ['Categories.name IN' => $data, 'Categories.is_deleted' => 0, 'Categories.is_active' => $this->request->query['is_active'], 'Categories.parent_id <>' => 0];
            } else {
                $conditions = ['Categories.name IN' => $data, 'Categories.is_deleted' => 0];
            }
        } else {
            if ($id) {
                $conditions = ['Categories.parent_id' => $id, 'Categories.is_deleted' => 0];
            } else {
                $conditions = ['Categories.parent_id <>' => 0, 'Categories.is_deleted' => 0];
            }
        }

        $this->request->data = $this->request->query;

        $this->paginate = [
            'contain' => ['ParentCategories'],
            'conditions' => $conditions,
            'limit' => 10,
        ];

        $categories = $this->paginate($this->Categories);
        $id = $this->Encryption->encode($id);
        $this->set(compact('categories', 'parentAgencies', 'id'));
    }

    /*
     * @Function:checkAgencyUniqueName()
     * @Description:use for get agency name is unique or not    
     * @By @Ahsan Ahamad
     * @Date : 6rd Nov. 2017
     */

    public function checkAgencyUniqueName($categoryName = null, $categoryId = null) {
        $this->autorander = FALSE;
        if (isset($this->request->data['name'])) {
            $categoryName = $this->request->data['name'];
        }
        if (isset($this->request->data['id'])) {
            $categoryId = $this->request->data['id'];
        }
        $nameStatus = $this->Categories->checkAgencyUniqueName($categoryName, $categoryId);


        echo json_encode($nameStatus);

        exit;
    }

    /* @Function:edit()
     * @Description: function use for edit only selected data    
     * @By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Manage Agencies | Edit';
        $pageHedding = 'Edit Agency';
        $breadcrumb = array(
            array('label' => 'Manage Agencies', 'link' => 'categories/index'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('Industries');
        $this->loadModel('Addresses');
        $ecdId = $id;
        $id = $this->Encryption->decode($id);
        if ($this->request->is(['post', 'put'])) {
            $id = $this->request->data['id'];
            $categories = $this->Categories->get($id);
            $categories = $this->Categories->patchEntity($categories, $this->request->data, ['validate' => 'Add']);
            if (!$categories->errors()) {
                /* this line for check unique name server side validation */
                if ($this->Categories->checkRules($categories)) {
                    if ($success = $this->Categories->save($categories)) {
                        /* code for add agency address */
                        $address['address1'] = trim($this->request->data['address1']);
                        $address['address2'] = trim($this->request->data['address2']);
                        $address['city'] = trim($this->request->data['city']);
                        $address['state_id'] = $this->request->data['state_id'];
                        $address['zipcode'] = trim($this->request->data['zipcode']);
                        $address['phone'] = $this->request->data['phone'];
                        $address['phone_extension'] = $this->request->data['phone_extension'];

                        $addresses = $this->Addresses->newEntity();
                        $this->Addresses->patchEntity($addresses, $address);
                        $successAddress = $this->Addresses->save($addresses);
                        if ($this->request->data['address_id']) {
                            $addresses = $this->Addresses->get($this->request->data['address_id']);
                        } else {
                            $address['agency_id'] = $success->id;
                            $addresses = $this->Addresses->newEntity();
                        }
                        $this->Addresses->patchEntity($addresses, $address);
                        $successAddress = $this->Addresses->save($addresses);
                        $this->Flash->success(__('Agency has been updated successfully.'));
                        return $this->redirect(['controller' => 'Categories', 'action' => 'index', 'prefix' => 'admin']);
                    } else {
                        $this->Flash->error(__('Agency could not be updated'));
                    }
                } else {
                    $this->Flash->error(__('Agencies name already exits'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($categories->errors())));
            }
        }

        $category = $this->Categories->find()->contain(['Addresses'])->where(['Categories.id =' => $id])->first();
        $this->loadModel('AgencyContacts');
        $category['contact'] = $this->AgencyContacts->find()->where(['AgencyContacts.agency_id' => $category['id'], 'AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1])->all();
        /* get all US states list */
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();
        $this->set(compact('category', 'statesList'));
    }

    /* @Function:view()
     * @Description: function use for view particular get data by select id
     * @By @Ahsan Ahamad
     * @Date : 22 setp. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Manage Agencies | View';
        $pageHedding = 'View Agency';
        $breadcrumb = array(
            array('label' => 'Manage Agencies', 'link' => 'categories/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $id = $this->Encryption->decode($id);
        $category = $this->Categories->find()->select(['name', 'id', 'short_description'])->where(['Categories.id =' => $id])->first();
        /* get conatct person related to agency */
        $this->loadModel('AgencyContacts');
        $category['contact'] = $this->AgencyContacts->find()->where(['AgencyContacts.agency_id' => $category['id'], 'AgencyContacts.is_deleted' => 0, 'AgencyContacts.is_active' => 1])->all();
        /* get all US states list */
        $this->loadModel('States');
        $states = $this->States->find('list');
        $states->where(['States.country_id' => 254, 'States.is_deleted' => 0, 'States.is_active' => 1]);
        $statesList = $states->toArray();

        $this->set(compact('industryList', 'agenyIndustriesyList', 'category', 'statesList'));
    }

    /*
     * @Function: getContactPerson()
     * @Description: use for get conatct person details related to agency
     * @By @Ahsan Ahamad
     * @Date : 14th Jan. 2018
     */

    public function getContactPerson($cinatctPersionId = null) {
        $this->autoRender = false;
        $this->loadModel('AgencyContacts');
        if ($this->request->is('post')) {
            $cinatctPersionId = $this->request->data['personId'];
            $conatct = $this->AgencyContacts->find()->contain(['Addresses'])->where(['AgencyContacts.id' => $cinatctPersionId])->first();
            $this->set('conatct', $conatct);
            echo $this->render('/Element/backend/agency/contact_person_details');
            exit;
        }
    }

}
