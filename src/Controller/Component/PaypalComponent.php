<?php

namespace App\Controller\Component;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Controller\Component;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use PayPalInterface;

require_once(ROOT . DS . 'vendor' . DS . 'PayPalInterface.php');

class PaypalComponent extends Component {

    /**
     * 
     * @param type $userId
     * @param type $cardDetails
     * @return string
     */
    public function createSubscription($userId, $cardDetails,$subscriptionPlanId) {
        
        set_time_limit(180);
        $responseData['status'] = false;
        $responseData['msg'] = '';

        $this->Users = TableRegistry::get('Users');
        $companyInfo = $this->Users->getCompanyInfo($userId);
        if (!empty($companyInfo['basic_info']) && !empty($companyInfo['location_info'])) {
            $this->PaymentSettings = TableRegistry::get('PaymentSettings');
            $paypalDetail = $this->PaymentSettings->getPaypalCredential();
            if (!empty($paypalDetail)) {
                $frequency = 'YEAR';
                $frequencyInterval = '1';
                $companyName = Inflector::slug($companyInfo['basic_info']->company, ' ');
                $agreementData['plan']['name'] = 'NYCompliance - ' . $companyName . ' - ' . $userId . '_' . date('Y_m_d');
                ;
                $agreementData['plan']['description'] = $agreementData['plan']['name'] . ' - ' . $companyInfo['basic_info']->first_name . "_" . $companyInfo['basic_info']->last_name;
                $agreementData['plan']['type'] = 'fixed';

                $agreementData['paymentDefinition']['name'] = 'NYCompliance - Regulatory Compliance';
                $agreementData['paymentDefinition']['type'] = 'REGULAR';
                $agreementData['paymentDefinition']['frequency'] = $frequency;
                $agreementData['paymentDefinition']['frequencyInterval'] = $frequencyInterval;
                $agreementData['paymentDefinition']['cycle'] = 24;
                $this->SubscriptionPlans = TableRegistry::get('SubscriptionPlans');
                $agreementData['paymentDefinition']['amount'] = $this->SubscriptionPlans->getPriceById($subscriptionPlanId);
                $serverHost = Configure::read('PROTOTYPE') . $_SERVER['HTTP_HOST'];
                $agreementData['merchantPreferences']['returnUrl'] = BASE_URL . '/payments/paypalRecurringResponse/' . base64_encode($agreementData['paymentDefinition']['amount']) . '/' . base64_encode($userId) . '?flag=success';
                $agreementData['merchantPreferences']['cancelUrl'] = BASE_URL . '/payments/paypalRecurringResponse/' . base64_encode($agreementData['paymentDefinition']['amount']) . '/' . base64_encode($userId) . '?flag=cancel';
                $agreementData['merchantPreferences']['notifyUrl'] = BASE_URL . '/payments/paypalRecurringResponse/' . base64_encode($agreementData['paymentDefinition']['amount']) . '/' . base64_encode($userId) . '?flag=notify';
                ;

                $agreementData['agreement']['name'] = $agreementData['plan']['name'];
                $agreementData['agreement']['description'] = 'This is an agreement between ' . $companyInfo['basic_info']->first_name . ' ' . $companyInfo['basic_info']->last_name . ' (' . $companyInfo['basic_info']->company . ') and NYCompliance (Sullivan PC)';

                $agreementData['agreement']['startDate'] = date('c', strtotime(date('Y-m-d H:i:s', strtotime('+1 day'))));

                $agreementData['creditCard']['cardNumber'] = $cardDetails['cardNumber'];
                $agreementData['creditCard']['expireMonth'] = $cardDetails['expireMonth'];
                $agreementData['creditCard']['expireYear'] = $cardDetails['expireYear'];
                $agreementData['creditCard']['cvv'] = $cardDetails['cvv'];
                $cardholder = explode(' ', $cardDetails['cardholder']);
                $agreementData['creditCard']['firstName'] = $cardholder[0];
                if (count($cardholder) >= 2) {
                    unset($cardholder[0]);
                    $agreementData['creditCard']['lastName'] = implode(' ', $cardholder);
                } else {
                    $agreementData['creditCard']['lastName'] = '';
                }
                $agreementData['payerInfo']['email'] = $companyInfo['location_info']->address1;
                $agreementData['shippingAddress']['line1'] = $companyInfo['location_info']->address2;
                $agreementData['shippingAddress']['line2'] = $companyInfo['location_info']->email;
                $agreementData['shippingAddress']['city'] = '';
                $agreementData['shippingAddress']['state'] = 'NY';
                $agreementData['shippingAddress']['countryCode'] = 'US';
                $agreementData['shippingAddress']['postalCode'] = '';                
                try {
                    $objpayPal = new PayPalInterface();
                    $apiContext = $objpayPal->init($paypalDetail['client_id'], $paypalDetail['secret_key']);
                    $responseData = $objpayPal->createAgreement($apiContext, $agreementData);                    
                    if ($responseData['status']) {
                        $this->Subscriptions = TableRegistry::get('Subscriptions');
                        $subscription['user_id'] = $userId;
                        $subscription['subscription_id'] = $responseData['id'];
                        $subscription['status'] = $responseData['state'];
                        $subscription['plan_id'] = $responseData['plan_id'];
                        $subscription['subscription_plan_id'] = $subscriptionPlanId;
                        $subscription['amount'] = $agreementData['paymentDefinition']['amount'];
                        $subscription['start_date'] = $responseData['start_date'];
                        $subscription['next_date'] = $responseData['next_billing_date'];
                        $subscription['location'] = $cardDetails['location'];
                        $subscription['payment_gateway'] = 'Paypal';
                        if (!$this->Subscriptions->checkRegistrationByUserId($userId)) {
                            $subscription['is_registration'] = 1;
                        }                        
                        $subscriptions = $this->Subscriptions->newEntity();
                        $this->Subscriptions->patchEntity($subscriptions, $subscription);
                        $this->Subscriptions->save($subscriptions);
                        $responseData['status'] = true;
                    } else {
                        $responseData['status'] = false;
                    }
                } catch (Exception $exc) {
                    $responseData['msg'] = $exc->getMessage();
                }
            } else {
                $responseData['msg'] = 'Paypal authentication failed! Please contact to NYCompliance';
            }
        } else {
            $responseData['msg'] = 'Company not Found. Please contact to NYCompliance';
        }
        return $responseData;
    }    

}
