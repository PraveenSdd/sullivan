<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Core\Configure;
use Cake\Http\Response;

require_once(ROOT . DS . 'vendor' . DS . 'PayPalInterface.php');

use PayPalInterface;

class PaymentsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadComponent('Paypal');
        $this->loadComponent('Stripe');
        $this->loadComponent('Flash'); // Include the FlashComponent

        $this->Auth->allow(['index', 'success', 'wellcome', 'paypalRecurringResponse']);
    }

    /* Function:wellcome() 
     * Description: function use for welcome page after payment
     * @param type $userId
     * @param type $amount     * By @Ahsan Ahamad
     * Date : 17th Dec. 2017
     */

    public function wellcome($userId = null, $amount = 0) {
        $this->viewBuilder()->setLayout('login');
        $this->set(compact('userId', 'amount'));
    }

    /* Function:success() 
     * Description: function use for success page after payment
     * @param type $userId
     *  By @Ahsan Ahamad
     * Date : 17th Dec. 2017
     */

    public function success($userId = null) {
        $this->viewBuilder()->setLayout('login');
        $userId = $this->Encryption->decode($userId);

        $this->Users = TableRegistry::get('Users');
        $userEmail = $this->Users->getEmailById($userId);
        $this->set(compact('userId', 'userEmail'));
    }

    /* Function:index() 
     * Description: function use for index payment payment 
     * @param type $userId
     * @param type $amount  
     * By @Ahsan Ahamad
     * Date : 17th Dec. 2017
     */

    public function index($userId = null, $amount = 0) {
        $this->viewBuilder()->setLayout('login');

        $responseData['status'] = true;
        $responseData['msg'] = '';
        $userId = $this->Encryption->decode($userId);
        $this->Users = TableRegistry::get('Users');
        $userExists = $this->Users->exists(['id' => $userId, 'is_deleted' => 0]);
        $locationCount = 0;
        $subscriptionDone = null;
        if ($userExists) {
            $this->loadModel('Subscriptions');
            $subscriptionDone = $this->Subscriptions->checkRegistrationByUserId($userId);
            if (!$subscriptionDone) {                
                $this->UserLocations = TableRegistry::get('UserLocations');
                $locationCount = $this->UserLocations->getCountByUserId($userId);
                if ($locationCount > 5) {
                    $amount = 1000;
                } else if ($locationCount <= 5 && $locationCount > 3) {
                    $amount = 750;
                } else {
                    $amount = 500;
                }

                # Get Subscription-plan data
                $this->loadModel('SubscriptionPlans');
                $subscriptionPlans = $this->SubscriptionPlans->getAllPlans();
                $this->set(compact('subscriptionPlans'));

                if ($this->request->is('post')) {
                    $companyInfo = $this->Users->getCompanyInfo($userId);
                    if (!empty($companyInfo)) {
                        if (strtolower($companyInfo['location_info']->email) == strtolower($this->request->data['Company']['email'])) {
                            $cardDetails['cardholder'] = $this->request->data['Payment']['card_holder'];
                            $cardDetails['cardNumber'] = $this->request->data['Payment']['card_number'];
                            $cardDetails['cvv'] = $this->request->data['Payment']['cvv'];
                            $expiry = explode('/', $this->request->data['Payment']['expiry']);
                            $cardDetails['expireMonth'] = $expiry[0];
                            $cardDetails['expireYear'] = $expiry[1];
                            $cardDetails['location'] = $locationCount;
                            $responseData = $this->Stripe->createSubscription($userId, $cardDetails, $this->request->data['SubscriptionPlan']['id']);
                            //$responseData = $this->Paypal->createSubscription($userId, $cardDetails,$this->request->data['SubscriptionPlan']['id']);
                            if ($responseData['status']) {
                                $responseData['msg'] = 'Payment has been successfully.';
                                $this->redirect(array('controller' => 'payments', 'action' => 'success', $userId));
                            } else {
                                $responseData['status'] = false;
                                $responseData['msg'] = $responseData['msg'];
                            }
                        } else {
                            $locationCount = 0;
                        }
                    } else {
                        $locationCount = 0;
                    }
                }
            }
        }
        $this->set(compact('userId', 'amount', 'userExists', 'subscriptionDone','locationCount', 'responseData'));
    }

    /* Function:paypalRecurringResponse() 
     * Description: function use for get pay pal details.
     * @param type $balance
     * @param type $invoiceId 
     * By @Ahsan Ahamad
     * Date : 17th Dec. 2017
     */

    function paypalRecurringResponse($balance = null, $invoiceId = null) {
        $this->autoRender = false;
        $this->loadModel('PaymentSettings');
        $paypaldetail = $this->PaymentSettings->find()->where(['is_deleted' => 0, 'role_id' => 1])->first();
        if (!empty($paypaldetail)) {
            try {
                $objpayPal = new PayPalInterface();
                $apiContext = $objpayPal->init($paypaldetail->client_id, $paypaldetail->secret_key);
                $responseData = $objpayPal->executeAgreement($apiContext, $this->request->query['token']);
                if ($responseData['status']) {
                    $data['ClientTransaction']['transactionid'] = $responseData['id'];
                    $data['ClientTransaction']['subscription_id'] = $responseData['id'];
                    $data['ClientTransaction']['invoice_id'] = $invoiceId;
                    $data['ClientTransaction']['gateway_id'] = $invoiceDetails['Invoice']['gateway_id'];
                    $data['ClientTransaction']['amount'] = $responseData['amount'];
                    $data['ClientTransaction']['sent_to'] = $invoiceDetails['Invoice']['send_to'];
                    $data['ClientTransaction']['sent_by'] = $invoiceDetails['Invoice']['sent_by'];
                    $data['ClientTransaction']['status'] = 1;
                    $data['ClientTransaction']['is_deleted'] = 0;
                    $data['ClientTransaction']['id'] = $this->ClientTransaction->getIdByInvoiceId($invoiceId);
                    if ($this->ClientTransaction->save($data)) {
                        $stat = "Paid";
                        $this->Invoice->updateAll(
                                array('Invoice.invoice_info' => '1', 'Invoice.invoice_status' => '"' . $stat . '"'), array('Invoice.id' => $invoiceId)
                        );

                        $recurringTransactionData = $data['ClientTransaction'];
                        $recurringTransactionData['id'] = $this->RecurringTransaction->getIdByInvoiceId($invoiceDetails['Invoice']['id']);
                        $recurringTransactionData['amount'] = $responseData['amount'];
                        $data['ClientTransaction']['status'] = 0;
                        $recurringTransactionData['gateway_id'] = $invoiceDetails['Invoice']['gateway_id'];
                        $recurringTransactionData['often_id'] = $invoiceDetails['Invoice']['often_id'];
                        $recurringTransactionData['how_many'] = $invoiceDetails['Invoice']['how_many'];
                        $recurringTransactionData['remaining_cycle'] = $invoiceDetails['Invoice']['how_many'];
                        $recurringTransactionData['current_billing_date'] = date('Y-m-d', strtotime($responseData['start_date']));
                        $recurringTransactionData['next_billing_date'] = $recurringTransactionData['current_billing_date'];
                        $recurringTransactionData['current_billing_status'] = 'Setup';
                        $recurringTransactionData['status_date'] = date('Y-m-d H:i:s');
                        $this->RecurringTransaction->save($recurringTransactionData);
                        $this->RecurringTransaction->saveLogInvoice($data['ClientTransaction']['invoice_id']);

                        $this->CronPdfMail->setPaidDataByInvoiceId($data['ClientTransaction']['invoice_id']);
                        $this->Flash->success(__('<div id="flashSuccess" class="msg">Thank You!! Transcation done successfully</div>'));
                    } else {
                        $this->Flash->error(__('<div id="flashUnsuccess" class="msg">Transaction not processed properly!</div>'));
                    }
                } else {
                    $this->Flash->error(__('<div id="flashUnsuccess" class="msg">' . $responseData['msg'] . '</div>'));
                }
            } catch (Exception $exc) {
                $this->Flash->error(__('<div id="flashUnsuccess" class="msg">' . $exc->getMessage() . '</div>'));
            }
        } else {
            $this->Flash->error(__('<div id="flashUnsuccess" class="msg errcolor">Payflow authentication failed!</div>'));
        }
        $role = $_SESSION['Auth']['User']['role_id'];
        if ($role == 2) {
            $this->redirect(array('controller' => 'Clients', 'action' => 'clientInvoicelist'));
        }
        $this->redirect(array('controller' => 'invoices', 'action' => 'invoicelist'));
    }

}
