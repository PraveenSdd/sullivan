<?php

namespace App\Controller\Admin;

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
        $this->Auth->allow(['login']);
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
