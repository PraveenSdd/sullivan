<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

class CronJobsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['alertsEmail', 'alertsEmailNotification', 'repeatAlertsEmailNotification']);
    }

    public function alertsEmail() {
        $this->autoRender = false;
        $this->loadModel('CronAlertMails');
        $cornAlertData = $this->CronAlertMails->find()->contain(['Alerts', 'Alerts.AlertTypes'])->where(['CronAlertMails.is_sent' => 0])->all();
        //$cornAlertData = $this->CronAlertMails->find()->contain(['Alerts'])->all();
        if (!$cornAlertData->isEmpty()) {
            foreach ($cornAlertData as $cronAlert) {
                if (!empty($cronAlert->alert)) {
                    $userData = $this->getUserForEmail($cronAlert->alert->id, $cronAlert->alert->alert_type_id, $cronAlert->alert->user_id, $cronAlert->alert->is_admin);
                    $this->CronAlertMails->updateAll(['is_sent' => 1], ['id' => $cronAlert->id]);
                    $this->sendAlertEmail($userData, $cronAlert->alert);
                }
            }
        }
        exit;
    }

    # http://34.211.31.84:8013/cronJobs/sendAlertsEmail

    public function alertsEmailNotification() {
        $this->autoRender = false;
        $this->loadModel('Alerts');
        $todayDate = date('m-d-Y');
        $alertData = $this->Alerts->find()->contain(['AlertTypes'])->where(['is_completed' => 0, 'is_repeated' => 0, 'date' => $todayDate])->all();
        if (!$alertData->isEmpty()) {
            foreach ($alertData as $alert) {
                $userData = $this->getUserForEmail($alert->id, $alert->alert_type_id, $alert->user_id, $alert->is_admin);
                $this->sendAlertEmail($userData, $alert);
                $this->Alerts->updateAll(['executed_date' => $todayDate], ['id' => $alert->id]);
            }
        }
        exit;
    }

    public function repeatAlertsEmailNotification() {
        $this->autoRender = false;
        $this->loadModel('Alerts');
        $todayDate = date('m-d-Y');
        $alertData = $this->Alerts->find()->contain(['AlertTypes'])->where(['executed_date !=' => '', 'is_completed' => 0, 'is_repeated' => 1, 'Alerts.alert_end_date >=' => date('m-d-Y')])->all();
        if (!$alertData->isEmpty()) {
            foreach ($alertData as $alert) {
                $lastExecutedDate = $alert->executed_date->i18nFormat('YYY-MM-dd');
                $nextExecutedDate = null;
                switch ($alert->interval_type) {
                    case 'Days':
                        $nextExecutedDate = "+" . $alert->interval_value . ' day';
                        break;
                    case 'Weeks':
                        $nextExecutedDate = "+" . $alert->interval_value . ' week';
                        break;
                    case 'Months':
                        $nextExecutedDate = "+" . $alert->interval_value . ' month';
                        break;
                }
                $nextExecutedDate = date('Y-m-d', strtotime($nextExecutedDate, strtotime($lastExecutedDate)));

                if (strtotime($todayDate) != strtotime($nextExecutedDate)) {
                    continue;
                }

                $userData = $this->getUserForEmail($alert->id, $alert->alert_type_id, $alert->user_id, $alert->is_admin);
                $this->sendAlertEmail($userData, $alert);
                $this->Alerts->updateAll(['executed_date' => $todayDate], ['id' => $alert->id]);
            }
        }
        exit;
    }

    public function getUserForEmail($alertId, $alertTypeId, $userId, $isAdmin) {
        $this->autoRender = false;
        $this->loadModel('Users');
        $this->loadModel('AlertNotifications');
        $this->loadModel('AlertOperations');
        $this->loadModel('AlertStaffs');
        $this->loadModel('AlertCompanies');
        $userIds = [];
        $userData = [];
        switch ($alertTypeId) {
            case 1://Persnal- Role 1
                $userIds[] = $userId;
                break;
            case 2://Sullivan PC- Role 1,4
                $userIds = $this->AlertStaffs->getUserIdListForEmail($alertId, $userId);
                break;
            case 3://Company- Role 2,3
                $userIds = $this->AlertCompanies->getUserIdListForEmail($alertId, $userId);
                break;
            case 4://Operation- Role 2,3
                $userIds = $this->AlertOperations->getUserIdListForEmail($alertId, $userId);
                break;
            case 5:// Company Staff 
                $userIds = $this->AlertStaffs->getUserIdListForEmail($alertId, $userId);
                break;
        }

        if ($userIds) {
            $userData = $this->Users->find('all')->contain([
                        'AlertNotifications' => function($query) use($alertId) {
                            return $query
                                            ->where(['AlertNotifications.is_unsubscribed' => 1, 'AlertNotifications.alert_id' => $alertId])
                                            ->select(['id', 'user_id']);
                        }
                    ])->hydrate(false)->select(['Users.id', 'Users.first_name', 'Users.last_name', 'Users.email'])->where(['Users.is_deleted' => 0, 'Users.is_active' => 1, 'Users.id IN' => $userIds])->toArray();
        }
        return $userData;
    }

    /**
     * 
     * @param type $userData
     * @param type $alertData
     */
    private function sendAlertEmail($userData, $alertData) {//
        $templateId = 2;
        $this->loadModel('AlertNotifications');
        $this->loadModel('EmailTemplates');
        $emailTemplate = $this->EmailTemplates->find()->where(['id' => $templateId])->first();
        $path = "http://" . $_SERVER['HTTP_HOST'] . "/Homes/unsubscribeAlert/";
        $emailData = $emailTemplate->description;
        $emailData = str_replace('{NOTE}', $alertData->notes, $emailData);
        $emailData = str_replace('{TITLE}', $alertData->title, $emailData);
        $emailData = str_replace('{DATE}', $alertData->date, $emailData);
        $emailData = str_replace('{TYPE}', $alertData['alert_type']['name'], $emailData);
        $subject = $emailTemplate->subject;
        foreach ($userData as $user) {
            if (empty($userData['alert_notification'])) {
                $emailData = str_replace('{USER_NAME}', ($user['first_name'] . ' ' . $user['last_name']), $emailData);
                $url = '';
                if ($alertData->is_repeated) {
                    $userId = $this->Encryption->encode($user['id']);
                    $alertId = $this->Encryption->encode($alertData->id);
                    $url = 'If you do not want to receive this alert, <a href="' . $path . $userId . "/" . $alertId . '">Unsubscribe</a>';
                }
                $emailData = str_replace('{UNSUBSCRIBE}', $url, $emailData);
                $this->_sendSmtpMail($subject, $emailData, $user['email']);
                $newNotification['user_id'] = $user['id'];
                $newNotification['alert_id'] = $alertData->id;
                $notifications = $this->AlertNotifications->newEntity();
                $this->AlertNotifications->patchEntity($notifications, $newNotification);
                $this->AlertNotifications->save($notifications);
            }
        }
    }

}
