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
        $this->viewBuilder()->setLayout('dashboard');
        $pageTitle = 'Locations';
        $pageHedding = 'Locations';
        $breadcrumb = array(
            array('label' => 'Locations'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('UserLocations');
        $conditions = ['UserLocations.is_deleted' => 0, 'UserLocations.user_id' => $this->Auth->user('id')];
        if ($this->request->query('title')) {
            $conditions['UserLocations.title LIKE'] = '%' . $this->request->query('title') . '%';
        }
        $this->paginate = [
            'contain' => ['LocationIndustries'],
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
        $this->loadModel('LocationIndustries');
        $this->loadModel('Countries');
        $this->loadModel('States');
        if ($this->request->is('post')) {
            $this->request->data['created'] = date('Y-m-d H:i:s');

            $UserLocation = $this->UserLocations->newEntity();
            /* these are line check serversite validation and save data  */
            $this->request->data['user_id'] = $this->Auth->user('id');
            $this->UserLocations->patchEntity($UserLocation, $this->request->data, ['validate' => 'Add']);
            if (!$UserLocation->errors()) {
                $success = $this->UserLocations->save($UserLocation);
                if ($success) {
                    foreach ($this->request->data['industry_id'] as $industry) {

                        $indusrtyData['industry_id'] = $industry;
                        $indusrtyData['user_id'] = $this->Auth->user('id');
                        $indusrtyData['user_location_id'] = $success->id;
                        $indusrtyData['created'] = date('Y-m-d H:i:s');
                        $locationIndustries = $this->LocationIndustries->newEntity();
                        $this->LocationIndustries->patchEntity($locationIndustries, $indusrtyData);
                        $this->LocationIndustries->save($locationIndustries);
                    }
                    $this->Flash->success(__('Location has been saved successfully.'));
                    return $this->redirect(['controller' => 'locations', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Location could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($UserLocation->errors())));
            }
        }
        $this->loadModel('Industries');
        $industries = $this->Industries->find('list', ['valueField' => 'name']);
        $industries->hydrate(false)->select(['Industries.name'])->where(['Industries.is_deleted' => 0, 'Industries.is_active' => 1]);
        $industryList = $industries->toArray();
        $this->set(compact('industryList'));

        $this->set('_serialize', ['industryList']);
    }

    /* Function:edit() 
     * Description: function use for edit location 
     * @param: $id ,
     * By @Ahsan Ahamad
     * Date : 17th Nov. 2017
     */

    public function edit($id = null) {
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
        if ($this->request->is('post')) {
            $UserLocation = $this->UserLocations->newEntity();
            /* these are line check serversite validation and save data  */
            $this->request->data['user_id'] = $this->Auth->user('id');
            if (!empty($this->request->data['user_location_id'])) {
                $UserLocation = $this->UserLocations->get($this->request->data['user_location_id']);
            }
            $this->UserLocations->patchEntity($UserLocation, $this->request->data, ['validate' => 'Add']);
            if (!$UserLocation->errors()) {
                $success = $this->UserLocations->save($UserLocation);
                if ($success) {

                    $this->loadModel('LocationIndustries');
                    if ($this->request->data['user_location_id']) {
                        $deleteId = $this->request->data['user_location_id'];
                        $condition = array('UserIndustries.user_location_id' => $deleteId);
                        $this->LocationIndustries->deleteAll($condition, false);
                    }
                    foreach ($this->request->data['industry_id'] as $industry) {
                        $indusrtyData['industry_id'] = $industry;
                        $indusrtyData['user_id'] = $this->Auth->user('id');
                        $indusrtyData['user_location_id'] = $success->id;
                        $indusrtyData['created'] = date('Y-m-d H:i:s');
                        $locationIndustries = $this->LocationIndustries->newEntity();
                        $this->LocationIndustries->patchEntity($locationIndustries, $indusrtyData);
                        $this->LocationIndustries->save($locationIndustries);
                    }

                    $this->Flash->success(__('Location has been saved successfully.'));
                    return $this->redirect(['controller' => 'locations', 'action' => 'index']);
                } else {
                    $this->Flash->error(__('Location could not be saved'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($UserLocation->errors())));
            }
        }

        $id = $this->Encryption->decode($id);
        $location = $this->UserLocations->find()->hydrate(false)
                        ->contain(['LocationIndustries'])->where(['UserLocations.id =' => $id])->first();

        $this->loadModel('Industries');
        $industries = $this->Industries->find('list', ['valueField' => 'name']);
        $industries->hydrate(false)->select(['Industries.name'])->where(['Industries.is_deleted' => 0, 'Industries.is_active' => 1]);
        $industryList = $industries->toArray();


        $this->set(compact('location', 'industryList'));
        $this->set('_serialize', ['industryList']);
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
                        ->contain(['LocationIndustries'])->where(['UserLocations.id =' => $id])->first();
        $this->set(compact('location'));
    }

}
