<?php

namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class ActivityLogsController extends AppController {

    public function initialize() {
        parent::initialize();
        
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
        $conditions = ['ActivityLogs.user_id' => $this->LoggedCompanyId];
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
