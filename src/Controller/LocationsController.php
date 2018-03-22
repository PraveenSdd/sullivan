<?php

namespace App\Controller;

use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use App\Model\Entity\UserLocationsTable;
use App\Model\Entity\StatesTable;
use App\Model\Entity\CountriesTable;

class LocationsController extends AppController {

    public $helpers = ['Location'];

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /* Function:login() 
     * Description: function use for logoin user function    
     * By @Ahsan Ahamad
     * Date : 17th Nov. 2017
     */

    public function index() {
        $pageTitle = 'Locations';
        $pageHedding = 'Locations';
        $breadcrumb = array(
            array('label' => 'Locations'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('UserLocations');
        if ($this->Auth->user('user_id') == 0) {
            $user_id = $this->Auth->user('id');
        } else {
            $user_id = $this->Auth->user('user_id');
        }
        $conditions = ['UserLocations.is_deleted' => 0, 'UserLocations.user_id' => $user_id];
        if ($this->request->query('title')) {
            $conditions['UserLocations.title LIKE'] = '%' . $this->request->query('title') . '%';
        }
        $this->paginate = [
            'contain' => ['LocationOperations', 'Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'select' => ['UserLocations.title', 'UserLocations.id', 'UserLocations.is_active', 'UserLocations.created'],
            'conditions' => $conditions,
            'limit' => 10,
        ];

        $locations = $this->paginate($this->UserLocations);
        $this->set(compact('locations'));
    }

    /* Function:add() 
     * Description: function use for add new location    
     * By @Ahsan Ahamad
     * Date : 17th Nov. 2017
     */

    public function add() {
        $pageTitle = 'Locations | Add';
        $pageHedding = 'Add';
        $breadcrumb = array(
            array('label' => 'Locations', 'link' => 'locations/'),
            array('label' => 'Add'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('UserLocations');
        $this->loadModel('LocationOperations');
        $this->loadModel('Countries');
        $this->loadModel('States');
        if ($this->request->is('post')) {
            $this->request->data['created'] = date('Y-m-d H:i:s');

            $UserLocation = $this->UserLocations->newEntity();
            /* these are line check serversite validation and save data  */
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->request->data['created'] = date('Y-m-d H:i:s');
            $this->request->data['is_operation'] = 1;
            $this->request->data['is_company'] = 0;
            $this->request->data['country_id'] = 254; //US
            $this->request->data['state_id'] = 154; //New York 

            $this->UserLocations->patchEntity($UserLocation, $this->request->data, ['validate' => 'Add']);
            if (!$UserLocation->errors()) {
                $success = $this->UserLocations->save($UserLocation);
                if ($success) {
                    $this->_updatedBy('UserLocations', $success->id);
                    $this->LocationOperations->saveOperations($this->Auth->user('id'), $success->id, $this->request->data['operation_id']);
                    /* === Added by vipin for  add log=== */
                    $message = 'Location added by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'user_locations';
                    $saveActivityLog['module_name'] = 'Location Front';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Add';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    $this->Flash->success(__('Location has been saved successfully.'));
                    return $this->redirect(['controller' => 'locations', 'action' => 'index']);
                    $this->Flash->success(__('Location has been saved successfully.'));
                    return $this->redirect(['controller' => 'locations', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Location could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($UserLocation->errors())));
            }
        }
        $this->loadModel('Operations');
        $operationList = $this->Operations->getList();
        $this->set(compact('operationList'));

        $this->set('_serialize', ['operationList']);
    }

    /* Function:edit() 
     * Description: function use for edit location 
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 17th Nov. 2017
     */

    public function edit($locationId = null) {
        $this->set(compact('locationId'));
        $pageTitle = 'Locations | Edit';
        $pageHedding = 'Edit';
        $breadcrumb = array(
            array('label' => 'Locations', 'link' => 'locations/'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('UserLocations');
        $this->loadModel('Countries');
        $this->loadModel('States');
        $this->loadModel('LocationOperations');

        $locationId = $this->Encryption->decode($locationId);
        $locationData = $this->UserLocations->find()->hydrate(false)->where(['UserLocations.id =' => $locationId])->first();

        if ($this->request->is('post')) {
            $UserLocation = $this->UserLocations->newEntity();
            $this->request->data['id'] = $locationId;
            if ($locationData['is_company'] == 1 && !isset($this->request->data['is_operation'])) {
                $this->request->data['is_operation'] = 0;
            } else {
                $this->request->data['is_operation'] = 1;
            }

            if (!empty($this->request->data['user_location_id'])) {
                $UserLocation = $this->UserLocations->get($locationId);
            }
            $this->UserLocations->patchEntity($UserLocation, $this->request->data, ['validate' => 'Add']);
            if (!$UserLocation->errors()) {
                $success = $this->UserLocations->save($UserLocation);
                if ($success) {
                    $this->_updatedBy('UserLocations', $success->id);
                    # Save new selected Operations                    
                    if ($this->request->data['is_operation'] == 1) {
                        $this->LocationOperations->updateOperations($this->Auth->user('id'), $locationId, $this->request->data['operation_id']);
                    } else {
                        # delete all Assocaited Operation basis on user-location-id
                        $this->LocationOperations->updateOperations($this->Auth->user('id'), $locationId);
                    }
                    /* === Added by vipin for  add log=== */
                    $message = 'Location updated by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $success->id;
                    $saveActivityLog['table_name'] = 'user_locations';
                    $saveActivityLog['module_name'] = 'Location Front';
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Edit';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    $this->Flash->success(__('Location has been saved successfully.'));
                    return $this->redirect(['controller' => 'locations', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Location could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($UserLocation->errors())));
            }
        }

        $this->loadModel('Operations');
        $operationList = $this->Operations->getList();
        $this->set(compact('operationList'));

        $this->loadModel('LocationOperations');
        $locationOperationIds = $this->LocationOperations->getOperationIdByLocationId($locationId);
        $this->set(compact('locationOperationIds'));


        $this->set(compact('locationData'));
        $this->set('_serialize');

        if (empty($this->request->data)) {
            $this->request->data = $locationData;
        }
    }

    /* Function:view() 
     * Description: function use for view selected location.
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 17th Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Locations | View';
        $pageHedding = 'View';
        $breadcrumb = array(
            array('label' => 'Locations', 'link' => 'location/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('UserLocations');

        $id = $this->Encryption->decode($id);
        $location = $this->UserLocations->find()->hydrate(false)
                        ->where(['UserLocations.id =' => $id])->first();
        $this->set(compact('location'));
    }

}
