<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class HomePagesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Upload');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * Function:index()
     * Description: use for listing of data Home ages
     * By @Ahsan Ahamad
     * Date : 16th Nov. 2017
     */

    public function index() {
        $pageTitle = 'Homes';
        $pageHedding = 'Homes';
        $breadcrumb = array(
            array('label' => 'Homes'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $conditions = ['HomePages.is_deleted' => 0, 'HomePages.home_page_id' => 0];
        if ($this->request->query('title')) {
            $conditions['HomePages.title LIKE'] = '%' . $this->request->query('title') . '%';
        }
        $this->paginate = [
            'contain' => ['SubHomePage'],
            'conditions' => $conditions,
            'limit' => 10,
        ];
        $homes = $this->paginate($this->HomePages);
        $this->set(compact('homes'));
    }

    /*
     * Function: edit()
     *  Description:  use for Edit of data Home pages
     * @param type: $id
     * By @Ahsan Ahamad
     * Date : 16th Nov. 2017
     */

    public function edit($id = null) {
        $pageTitle = 'Homes | Edit';
        $pageHedding = 'Edit';
        $breadcrumb = array(
            array('label' => 'Homes', 'link' => 'homePages/'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $homeId = $id;
        if ($this->request->is('post')) {
            $homes = $this->HomePages->newEntity();
            $this->HomePages->patchEntity($homes, $this->request->data, ['validate' => 'Edit']);
            $fineData = $this->Upload->uploadImage($this->request->data['file']);
            $homes['image'] = $fineData;
            if (!$homes->errors()) {
                $success = $this->HomePages->save($homes);
                if ($success) {
                    $this->Flash->success(__('Home page has been updated successfully.'));
                    return $this->redirect(['controller' => 'homePages', 'action' => 'index', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Home page could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($homes->errors())));
                return $this->redirect(['controller' => 'homePages', 'action' => 'edit', $homeId, 'prefix' => 'admin']);
            }
        }

        $id = $this->Encryption->decode($id);
        $home = $this->HomePages->find()->hydrate(false)
                        ->where(['HomePages.id =' => $id])->first();
        $this->set(compact('home'));
    }

    /*
     * Function: view()
     *  Description:  use for view of data Home ages
     *  @param type: $id
     * By @Ahsan Ahamad
     * Date : 16th Nov. 2017
     */

    public function view($id = null) {
        $pageTitle = 'Homes | View';
        $pageHedding = 'View';
        $breadcrumb = array(
            array('label' => 'Homes', 'link' => 'forms/index'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $id = $this->Encryption->decode($id);
        $home = $this->HomePages->find()->hydrate(false)
                        ->where(['HomePages.id =' => $id])->first();
        $this->set(compact('home'));
    }

    /*
     *  Function: SubscriptionPlans()
     *  Description:  use for view of data Home ages Subscription Plans
     *   * @param type: $id
     * By @Ahsan Ahamad
     * Date : 16th Nov. 2017
     */

    public function SubscriptionPlans() {
        $pageTitle = 'Subscription Plans';
        $pageHedding = 'Subscription Plans';
        $breadcrumb = array(
            array('label' => 'Homes', 'link' => 'homePages/'),
            array('label' => 'Subscription Plans'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('SubscriptionPlans');
        $conditions = ['SubscriptionPlans.is_deleted' => 0];
        if ($this->request->query('name')) {
            $conditions['SubscriptionPlans.name LIKE'] = '%' . $this->request->query('name') . '%';
            $this->request->data = $this->request->query('name');
        }
        $this->paginate = [
            'contain' => ['Attributes'],
            'conditions' => $conditions,
            'limit' => 10,
        ];
        $SubscriptionPlans = $this->paginate($this->SubscriptionPlans);
        $this->set(compact('SubscriptionPlans'));
    }

    /*
     * Function: SubscriptionPlans()
     *  Description:  use for view of data Home ages Edit Subscription Plan
     *   * @param type: $id
     * By @Ahsan Ahamad
     * Date : 16th Nov. 2017
     */

    public function EditSubscriptionPlans($id = null) {
        $pageTitle = 'Subscription Plans | Edit';
        $pageHedding = 'Subscription Plans | Edit';
        $breadcrumb = array(
            array('label' => 'Subscription Plans', 'link' => 'homePages/subscriptionPlans/'),
            array('label' => 'Edit'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('SubscriptionPlans');
        $this->loadModel('SubscriptionPlanAttributes');

        if ($this->request->is('post')) {

            $SubscriptionPlan = $this->SubscriptionPlans->newEntity();
            /* these are line check serversite validation and save data  */
            $this->SubscriptionPlans->patchEntity($SubscriptionPlan, $this->request->data, ['validate' => 'Edit']);
            if (!$SubscriptionPlan->errors()) {
                $success = $this->SubscriptionPlans->save($SubscriptionPlan);
                if ($success) {
                    if ($this->request->data['remove_attribute_id']) {
                        $deleteId = explode(',', $this->request->data['remove_attribute_id']);
                        $condition = array('SubscriptionPlanAttributes.id in' => $deleteId);
                        $this->SubscriptionPlanAttributes->deleteAll($condition, false);
                    }

                    $coun = count($this->request->data['attribute']);
                    for ($i = 0; $i <= $coun - 1; $i++) {
                        /* $data for get data of form  */
                        if (!empty($this->request->data['attributes_id'][$i])) {
                            $attributesId = $this->request->data['attributes_id'][$i];

                            $SubscriptionPlanAttributes = TableRegistry::get('SubscriptionPlanAttributes');
                            $query = $SubscriptionPlanAttributes->query();
                            $query->update()
                                    ->set(['attribute' => $this->request->data['attribute'][$i],
                                        'subscription_plan_id' => $success->id,
                                    ])
                                    ->where(['id' => $attributesId])
                                    ->execute();
                        } else {
                            $dataFaq = [
                                'attribute' => $this->request->data['attribute'][$i],
                                'subscription_plan_id' => $success->id,
                            ];
                            $SubscriptionPlanAttributes = TableRegistry::get('SubscriptionPlanAttributes');
                            $SubscriptionPlanAttribute = $SubscriptionPlanAttributes->newEntity($dataFaq);
                            $attributet = $this->SubscriptionPlanAttributes->patchEntity($SubscriptionPlanAttribute, $dataFaq);
                            $succ = $SubscriptionPlanAttributes->save($SubscriptionPlanAttribute);
                        }
                    }
                    $this->Flash->success(__('Subscription plans has been updated successfully.'));
                    return $this->redirect(['controller' => 'homePages', 'action' => 'SubscriptionPlans', 'prefix' => 'admin']);
                } else {
                    $this->Flash->error(__('Subscription plans could not be updated'));
                }
            } else {
                $this->Flash->error(__($this->Custom->multipleFlash($SubscriptionPlan->errors())));
            }
        }
        $id = $this->Encryption->decode($id);
        $SubscriptionPlan = $this->SubscriptionPlans->find()->contain('Attributes')->hydrate(false)
                        ->where(['SubscriptionPlans.id =' => $id])->first();

        $this->set(compact('SubscriptionPlan'));
    }

    /*
     *  Function: viewSubscriptionPlans()
     *  Description:  use for view of data Home ages View Subscription Plan
     *  @param type: $id
     * By @Ahsan Ahamad
     * Date : 16th Nov. 2017
     */

    public function viewSubscriptionPlans($id = null) {
        $pageTitle = 'Subscription Plans | View';
        $pageHedding = 'Subscription Plans | View';
        $breadcrumb = array(
            array('label' => 'Subscription Plans', 'link' => 'homePages/subscriptionPlans/'),
            array('label' => 'View'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('SubscriptionPlans');
        $id = $this->Encryption->decode($id);
        $SubscriptionPlan = $this->SubscriptionPlans->find()->contain('Attributes')->hydrate(false)
                        ->where(['SubscriptionPlans.id =' => $id])->first();

        $this->set(compact('SubscriptionPlan'));
    }

}
