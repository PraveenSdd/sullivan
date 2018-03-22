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

    /* @Function: changeStatus()
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

    /* @Function: verifyStaff()
     * @Description: function use for common vefiry/UNverify data all the module
     * @param: $id module id,
     * @param: $module name,
     * @By @VIin chauhan
     * @Date : 09Feb. 2018
     */

    public function verifyStaff() {
        $this->autoRender = FALSE;
        $userid = $this->Auth->user('id');
        //echo $id;die;
        if ($this->request->is('post')) {
            $model = $this->request->data['model'];
            $title = $this->request->data['title'];
            $id = $this->request->data['id'];
            $response = [];
            if ($title == 'Verify') {
                $usersTable = TableRegistry::get('Users');
                $query = $usersTable->query();
                $update = $query->update()->set(['is_verify' => 1])->where(['id' => $id])->execute();

                if ($update) {
                    $response['statusCode'] = 200;
                } else {
                    $response['statusCode'] = 202;
                }
            } else if ($title == 'UnVerify') {
                $usersTable = TableRegistry::get('Users');
                $query = $usersTable->query();
                $update = $query->update()->set(['is_verify' => 0])->where(['id' => $id])->execute();

                if ($update) {
                    $response['statusCode'] = 200;
                } else {
                    $response['statusCode'] = 202;
                }
            } else {
                $response['statusCode'] = 202;
            }
        }

        echo json_encode($response);
    }

    /* @Function: deleteStatus()
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
            $subModel = $this->request->data['subModel'];
            $foreignId = $this->request->data['foreignId'];
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
            if ($title == 'Verify') {
                $query = $articles->query();
                $update = $query->update()
                        ->set(['is_verify' => 1])
                        ->where(['id' => $id])
                        ->execute();
                if ($update == true) {
                    $this->Flash->success(__("'" . $msg . "' has been successfully."));

                    $data = ['success' => 'success', 'status' => $status];
                } else {
                    $this->Flash->success(__("'" . $msg . "' could not  successfully."));
                    $data = ['success' => 'error', 'status' => $status];
                }
            } else {
                $query = $articles->query();
                $update = $query->update()
                        ->set(['is_deleted' => 1])
                        ->where(['id' => $id])
                        ->execute();
                if ($update == true) {
                    if (isset($subModel)) {
                        $subArticles = TableRegistry::get();
                        TableRegistry::get('' . $subModel . '')->updateAll(
                                array("is_deleted" => 1), array($foreignId => $id)
                        );
                    }
                    $this->Flash->success(__("'" . $msg . "' has been deleted successfully."));

                    $data = ['success' => 'success', 'status' => $status];
                } else {
                    $this->Flash->success(__("'" . $msg . "' could not deleted successfully."));
                    $data = ['success' => 'error', 'status' => $status];
                }
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
            $listHtml .= '<option value="' . $key . '">' . $value . '</option>';
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
        $this->loadModel('UserPermits');
        if ($this->request->is('post')) {
            $title = $this->request->data['title'];
            if ($this->request->data['oldStatus'] == 1) {
                $permit = TableRegistry::get('UserPermits');
                $this->request->data['permit_status_id'] = $this->request->data['newstatus'];

                $permits = $this->UserPermits->newEntity($this->request->data);
                $this->UserPermits->patchEntity($permits, $this->request->data);
                $update = $this->UserPermits->save($permits);
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
                $data = ['success' => 'success'];
            } else {
                $this->Flash->error(__($title . ' status could not been changed.'));
                $data = ['success' => 'error'];
            }
        }
    }

    /* Function: autoCompany()
     * Descrption: use for get all company list
     * Date :- 9 Dec 2017
     * by:- Praveen 
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

    /*
     * Function: download()
     * Description: download the file after click preview and donload button 
     * By @Vipin chauhan
     * Date : 12th Feb. 2018
     */

    //$path = WWW_ROOT.'files/permits/forms/2018020704454620131231103232738561744pdf.pdf';
    public function download() {
        if ($this->request->query('attachmentId') && $this->request->query('attachmentTable') && $this->request->query('path')) {
            $path = WWW_ROOT . '/' . $this->request->query('path');
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            $requestName = $this->request->query('documentname');
            $savedName = $requestName . '.' . $ext;
            $this->response->file($path, array(
                'download' => true,
                'name' => $savedName,
            ));
            return $this->response;
        } else {
            echo "Target file not found!";
            die;
        }
    }

    public function delete($id) {
        $this->autoRender = FALSE;
        if ($this->request->is('post') && !empty($id)) {
            $model_name = $this->request->data['model_name'];
            $module_name = $this->request->data['module_name'];
            $table_name = $this->request->data['table_name'];
            $title = $this->request->data['title'];
            $redirect_url = $this->request->data['redirect_url'];
            $subModel = $this->request->data['subModel'];
            $foreignId = $this->request->data['foreignId'];
            if (!empty($title)) {
                $msg = $title;
            } else {
                $msg = $model;
            }
            $this->loadModel($model_name);
            $articles = TableRegistry::get('' . $model_name . '');
            $id = $this->Encryption->decode($id);
            if (!empty($id)) {
                $query = $articles->query();
                $update = $query->update()
                        ->set(['is_deleted' => 1])
                        ->where(['id' => $id])
                        ->execute();
                if ($update == true) {
                    if (isset($subModel) && !empty($subModel) && !empty($foreignId)) {
                        TableRegistry::get('' . $subModel . '')->updateAll(
                                array("is_deleted" => 1), array($foreignId => $id)
                        );
                    }
                    /* === Added by vipin for  add log=== */
                    $message = $module_name . ' deleted by ' . $this->loggedusername;
                    $saveActivityLog = [];
                    $saveActivityLog['table_id'] = $id;
                    $saveActivityLog['table_name'] = $table_name;
                    $saveActivityLog['module_name'] = $module_name;
                    $saveActivityLog['url'] = $this->referer();
                    $saveActivityLog['message'] = $message;
                    $saveActivityLog['activity'] = 'Delete';
                    $this->Custom->saveActivityLog($saveActivityLog);
                    /* === Added by vipin for  add log=== */

                    $this->Flash->success(__("'" . $msg . "' has been deleted successfully."));
                    $this->redirect($redirect_url);
                } else {
                    $this->Flash->success(__("'" . $msg . "' could not deleted successfully."));
                    $this->redirect($this->referer());
                }
            }
        }
    }

}
