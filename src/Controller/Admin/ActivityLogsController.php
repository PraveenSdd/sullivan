<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class ActivityLogsController extends AppController {

    public function initialize() {
        parent::initialize();
        if (!$this->request->getParam('admin') && $this->Auth->user('role_id') != 1 && $this->Auth->user('role_id') != 4) {
            return $this->redirect('/');
        }
        $this->loadComponent('Paginator');
        $this->loadComponent('Flash'); // Include the FlashComponent
    }

    /*
     * Function: index()
     * Description: Listing of logs
     * By @Vipin chauhan
     * Date : 1rd Feb. 2018
     */

    public function index() {

        $pageTitle = 'Activity Logs';
        $pageHedding = 'Logs';
        $breadcrumb = array(
            array('label' => 'Activity Logs'),
        );
        $conditions = [];
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->paginate = [
            'conditions' => $conditions,
            'order' => ['ActivityLogs.id' => 'desc'],
            'limit' => $this->paginationLimit,
        ];
        $activityLogs = $this->paginate($this->ActivityLogs);
        $this->set(compact('activityLogs'));
    }
    /**
     * 
     * @param type $activityLogId
     * @return type
     */
    public function view($activityLogId) {
        $this->set(compact('$activityLogId'));
        $pageTitle = 'Activity Log | View';
        $pageHedding = 'View Activity Log';
        $breadcrumb[] = array('label' => 'Activity Log', 'link' => 'activityLogs/');
        $breadcrumb[] = array('label' => 'View');
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));

        $activityLogId = $this->Encryption->decode($activityLogId);
        $activityLogs = $this->ActivityLogs->getAllDataById($activityLogId);
        if (empty($activityLogs)) {
            $this->Flash->error(__('Log not available!'));
            return $this->redirect(['controller' => 'activityLogs', 'action' => 'index']);
        }
        $this->set(compact('activityLogs'));
    }

}
