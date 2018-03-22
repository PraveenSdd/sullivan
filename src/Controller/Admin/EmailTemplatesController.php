<?php

namespace App\Controller\Admin;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;

class EmailTemplatesController extends AppController {

    public function initialize() {
        ;
        $this->loadComponent('Paginator');
        $this->loadComponent('Encryption');
        parent::initialize();
    }

    public function index() {
        $pageTitle = 'Manage Email Template';
        $pageHedding = 'Manage Email Template';
        $breadcrumb = array(
            array('label' => 'Manage Email Template'),
        );
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('EmailTemplates');
        $this->paginate = [
            'contain' => ['Users' => function($q) {
                    return $q->select(['Users.id', 'Users.first_name', 'Users.last_name']);
                }],
            'limit' => 10];
        $emailTemplates = $this->paginate($this->EmailTemplates);
        $this->set(compact('emailTemplates'));
    }

    public function edit($templateId = null) {
        $pageTitle = 'Edit Email Template';
        $pageHedding = 'Edit Email Template';
        $breadcrumb = array(
            array('label' => 'Manage Email Template', 'link' => 'emailTemplates'),
            array('label' => 'Edit'));
        $this->set(compact('breadcrumb', 'pageTitle', 'pageHedding'));
        $this->loadModel('EmailTemplates');
        if ($this->request->is(['post', 'put'])) {
            $templateData = $this->EmailTemplates->newEntity();
            $this->EmailTemplates->patchEntity($templateData, $this->request->data);
            if ($success = $this->EmailTemplates->save($templateData)) {
                $this->_updatedBy('EmailTemplates', $success->id);
                /* === Added by vipin for  add log=== */
                $message = 'Email Template updated by ' . $this->loggedusername;
                $saveActivityLog = [];
                $saveActivityLog['table_id'] = $success->id;
                $saveActivityLog['table_name'] = 'email_templates';
                $saveActivityLog['module_name'] = 'Email Template';
                $saveActivityLog['url'] = $this->referer();
                $saveActivityLog['message'] = $message;
                $saveActivityLog['activity'] = 'Edit';
                $this->Custom->saveActivityLog($saveActivityLog);
                /* === Added by vipin for  add log=== */
                $this->Flash->success(__('Email Template has been update successfully.'));
            } else {
                $this->Flash->error(__('Email Template could not be saved.'));
            }
            return $this->redirect($this->referer());
        }
        if (!empty($templateId)) {
            $templateId = $this->Encryption->decode($templateId);
            $this->request->data = $this->EmailTemplates->getEmailTemplateById($templateId);
        }
    }

}
