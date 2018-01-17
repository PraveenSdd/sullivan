<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\View\Helper;
use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;

class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public $helpers = ['Encryption', 'Flash', 'Custom'];
    public $companyId;
    public $emaployeeId;
    public $userId;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Encryption');
        $this->loadComponent('Custom');
        $this->loadComponent('Flash');
        $this->loadComponent('Paginator');
        $this->loadComponent('Cookie');

        /* These are codes use for auth login */
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password',
                        'is_active' => 1,
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => $this->referer()
        ]);
        /* These are code use for check auth user */
        if ($this->Auth->user('user_id') != 0) {
            $this->companyId = $this->Auth->user('user_id');
            $this->userId = $this->Auth->user('id');
        } else {
            $this->emaployeeId = $this->Auth->user('id');
            $this->userId = $this->Auth->user('id');
        }

        Configure::write('EmaployeeId', $this->emaployeeId);
        Configure::write('CompanyId', $this->companyId);
        Configure::write('userId', $this->userId);
        $this->set('userId', $this->userId);
        $this->set('Authuser', $this->Auth->user());
    }

    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(Event $event) {
        if (!array_key_exists('_serialize', $this->viewVars) &&
                in_array($this->response->type(), ['application/json', 'application/xml'])
        ) {
            $this->set('_serialize', true);
        }
    }

    /* @Functio: sendEmail() function use for common send email function
     * @param array $data
     * @param type $to
     * @param type $templateId
     * @return boolean    
     * @By @Ahsan Ahamad
     * @Date : 26 Nov. 2017
     */

    public function sendEmail($data, $to, $templateId) {
        $this->loadModel('EmailTemplates');
        $template = $this->EmailTemplates->find()->where(['id' => $templateId])->first();
        $subject = $template->subject;
        $templateName = $template->email_type;
        $data['url'] = BASE_URL;
        $response = false;
        try {
            $Email = new Email();
            $Email->transport('gmail3');
            $Email->viewVars(array("data" => $data));
            $Email->to($to);
            $Email->subject($subject);
            $Email->template($templateName);
            $Email->emailFormat('html');
            if ($Email->send()) {
                $response = true;
            }
        } catch (Exception $ex) {
            $response = false;
        }
        return $response;
    }

}
