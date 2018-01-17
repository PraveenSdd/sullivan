<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class CustomsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->Auth->allow(['login', 'checkUniqueComapny', 'checkEmailUnique', 'autoCompany']);
    }

   /*@Function: changeStatus()
* @Description: function use for common change status all the module
* @param: $id module id,
* @param: $status id,
* @param: $module name,
* @By @Ahsan Ahamad
* @Date : 23rd Nov. 2017
*/ 

    public function changeStatus() {
        $this->autoRender = FALSE;
        $userId = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $model = $this->request->data['model'];
            $title = $this->request->data['title'];
            $this->loadModel($model);
            $articles = TableRegistry::get('' . $model . '');
            $id = $this->request->data['id'];
            $status = $this->request->data['newStatus'];
            $categories = $this->$model->get($id);
            $query = $articles->query();
            $update = $query->update()
                    ->set(['is_active' => $status])
                    ->where(['id' => $id])
                    ->execute();
            if ($update == true) {
                $this->Flash->success(__($title . ' status has been change successfully.'));
                $data = ['success' => 'success', 'status' => $status];
            } else {
                $this->Flash->error(__($title . ' status could not been changed.'));
                $data = ['success' => 'error', 'status' => $status];
            }
        }

        echo json_encode($data);
    }

  /*@Function: deleteStatus()
* @Description: function use for common delete data all the module
* @param: $id module id,
* @param: $module name,
* @By @Ahsan Ahamad
* @Date : 23rd Nov. 2017
*/ 
    
    public function deleteStatus() {
        $this->autoRender = FALSE;
        $userId = $this->Auth->user('id');
        if ($this->request->is('post')) {
            $model = $this->request->data['model'];
            $modelSub = $this->request->data['subModel'];
            $sub_id = $this->request->data['sub_id'];
            $title = $this->request->data['title'];

            if (!empty($title)) {
                $msg = $title;
            } else {
                $msg = $model;
            }

            $this->loadModel($model);
            $articles = TableRegistry::get('' . $model . '');
            $id = $this->request->data['id'];
            $categories = $this->$model->get($id);
            $query = $articles->query();
            $update = $query->update()
                    ->set(['is_deleted' => 1])
                    ->where(['id' => $id])
                    ->execute();
            if ($update == true) {
                $this->Flash->success(__("'" . $msg . "' has been deleted successfully."));

                $data = ['success' => 'success', 'status' => $status];
            } else {
                $this->Flash->success(__("'" . $msg . "' has been deleted successfully."));
                $data = ['success' => 'error', 'status' => $status];
            }
        }

        echo json_encode($data);
    }

    /*
     * Function:getSubCategory()
     * Description: use for get status details 
     * By @Ahsan Ahamad
     * Date : 15th Nov. 2017
     */

    public function getStates($id = null) {
        $this->loadModel('States');
        $this->autoRender = FALSE;
        $id = $this->request->data['id'];
        $states = $this->States->find('list');
        $states->hydrate(false)->where(['States.is_deleted' => 0, 'States.is_active' => 1, 'States.country_id' => $id]);
        $statesList = $states->toArray();

        $listHtml = '<option value="">-- Select State -- </option>';
        $listArray = array();

        foreach ($statesList as $key => $value) {
            $listHtml .='<option value="' . $key . '">' . $value . '</option>';
            $listArray[$key] = $value;
        }
        echo $listHtml;
        exit;
    }

    /*
     * Function:checkEmailUnique()
     * Description: use for check uique email address
     * By @Ahsan Ahamad
     * Date : 27th Oct. 2017
     */

    public function checkEmailUnique($email = null, $userId = null) {
        $this->autorander = FALSE;
        $this->loadModel('Users');
        if (isset($this->request->data['email'])) {
            $email = $this->request->data['email'];
        }
        if (isset($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        $nameStatus = $this->Users->checkUniqueEmail($email, $userId);
        echo json_encode($nameStatus);

        exit;
    }

    /*
     * Function:checkUniqueComapny()
     * Description: use for check uique compay name
     * By @Ahsan Ahamad
     * Date : 27th Oct. 2017
     */

    public function checkUniqueComapny($company = null, $userId = null) {
        $this->autorander = FALSE;
        $this->loadModel('Users');
        if (isset($this->request->data['company'])) {
            $comapny = $this->request->data['company'];
        }
        if (isset($this->request->data['id'])) {
            $userId = $this->request->data['id'];
        }
        $nameStatus = $this->Users->checkComapnyUnique($comapny, $userId);
        echo json_encode($nameStatus);

        exit;
    }

    /* Function: changeFormStatus()
     * Descrption: use for change Permit status
     * Date :- 9 Dec 2017
     * by:- Ahsan ahamad
     * 
     *  */

    public function changeFormStatus() {
        $this->autoRender = FALSE;
        $userId = $this->Auth->user('id');
        $this->loadModel('Permits');
        if ($this->request->is('post')) {
            $title = $this->request->data['title'];
            if ($this->request->data['oldStatus'] == 1) {

                $permit = TableRegistry::get('Permits');
                $dataPermit['form_id'] = $this->request->data['id'];
                $dataPermit['user_id'] = $this->request->data['userId'];
                $dataPermit['user_location_id'] = $this->request->data['locationId'];
                $dataPermit['industry_id'] = $this->request->data['industryId'];
                $dataPermit['category_id'] = $this->request->data['agencyId'];
                $dataPermit['permit_status_id'] = $this->request->data['newstatus'];
                $permits = $permit->newEntity($dataPermit);
                $this->Permits->patchEntity($permits, $dataPermit);
                $update = $this->Permits->save($permits);
            } else {
                $id = $this->request->data['id'];
                $categories = $this->Permits->get($id);
                $query = $articles->query();
                $update = $query->update()
                        ->set(['permit_status_id' => $this->request->data['newstatus']])
                        ->where(['id' => $id])
                        ->execute();
            }

            if ($update == true) {
                $this->Flash->success(__($title . ' status has been change successfully.'));
                $data = ['success' => 'success', 'status' => $status];
            } else {
                $this->Flash->error(__($title . ' status could not been changed.'));
                $data = ['success' => 'error', 'status' => $status];
            }
        }

        echo json_encode($data);
    }

    /* Function: autoCompany()
     * Descrption: use for get all company list
     * Date :- 9 Dec 2017
     * by:- Ahsan ahamad
     * 
     *  */

    public function autoCompany() {
        $companyList = [];
        $this->loadModel('Users');
        $this->viewBuilder()->setLayout('');
        if (isset($this->request->data['keyword'])) {
            $keyword = $this->request->data['keyword'];
            $companyList = $this->Users->getCompanyList($keyword);
        }
        $this->set(compact('companyList'));
    }

}
