<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class HomesController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
        $this->Auth->allow(['index', 'howItWorks','unsubscribeAlert']);
    }

    /*
     * Function:index()
     * Description: Use for load and get fornt page  data
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function index() {
        $this->viewBuilder()->setLayout('home');
        $this->loadModel('HomePages');
        $this->loadModel('HomePages');
        $this->loadModel('SubscriptionPlans');
        $homePages = $this->HomePages->find()->hydrate(false)->select(['id', 'home_page_id', 'title', 'description', 'image'])->where(['is_deleted' => 0, 'is_active' => 1, 'home_page_id' => 0])->all();

        $subscriptionPlans = $this->SubscriptionPlans->find()->hydrate(false)->select(['id', 'name', 'description', 'price'])->where(['is_deleted' => 0, 'is_active' => 1])->all();

        $home = [];
        foreach ($homePages as $homePage) {
            $home[] = $homePage;
        }
        $this->set(compact('home', 'subscriptionPlans'));
    }

    /*
     * Function:howItWorks()
     * Description: Use for load how it work page
     * By @Ahsan Ahamad
     * Date : 3rd Nov. 2017
     */

    public function howItWorks() {
        $this->viewBuilder()->setLayout('login');
        $this->loadModel('HowItWorks');
        $howItWorks = $this->HowItWorks->find()->Where(['HowItWorks.is_active' => 1, 'HowItWorks.is_deleted' => 0])->all();
        $this->set(compact('howItWorks'));
    }

    public function unsubscribeAlert($userId = null, $alertId = null) {
        $this->viewBuilder()->setLayout('login');
        if (!empty($userId) && !empty($alertId)) {
            $this->loadModel('AlertNotifications');
            $flag = $this->AlertNotifications->find()->where(['user_id' => $userId, 'alert_id' => $alertId])->count();
            if ($flag > 0) {
                $userId = $this->Encryption->decode($userId);
                $alertId = $this->Encryption->decode($alertId);
                $tablename = TableRegistry::get("AlertNotifications");
                $query = $tablename->query();
                $result = $query->update()
                        ->set(['is_unsubscribed' => '1'])
                        ->where(['user_id' => $userId, 'alert_id' => $alertId])
                        ->execute();
                if ($result) {
                    $msg="";
                } else {
                    $msg="";
                }
                $this->set(compact('msg'));
            }
        } else {
            $this->redirect(array('controller' => 'Homes', 'action' => 'index'));
        }
    }

}
