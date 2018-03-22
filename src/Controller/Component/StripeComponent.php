<?php

namespace App\Controller\Component;

use Cake\Core\Configure;
use Cake\Http\Response;
use Cake\Controller\Component;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use StripeInterface;

require_once(ROOT . DS . 'vendor' . DS . 'StripeInterface.php');


class StripeComponent extends Component {    

    /**
     * 
     * @param type $userId
     * @param type $cardDetails
     * @param type $subscriptionPlanId
     * @return string
     */
    public function createSubscription($userId, $cardDetails, $subscriptionPlanId) {        
        set_time_limit(180);
        $responseData['status'] = false;
        $responseData['msg'] = '';        
        $this->Users = TableRegistry::get('Users');
        $companyInfo = $this->Users->getCompanyInfo($userId);
        if (!empty($companyInfo['basic_info']) && !empty($companyInfo['location_info'])) {
            $this->PaymentSettings = TableRegistry::get('PaymentSettings');
            $stripeDetail = $this->PaymentSettings->getStripeCredential();
            if (!empty($stripeDetail)) {
                $this->SubscriptionPlans = TableRegistry::get('SubscriptionPlans');
                $stripeProductId = $this->SubscriptionPlans->getStripeProductIdById($subscriptionPlanId);

                $subscriptionData['card']['number'] = $cardDetails['cardNumber'];
                $subscriptionData['card']['expMonth'] = $cardDetails['expireMonth'];
                $subscriptionData['card']['expYear'] = $cardDetails['expireYear'];
                $subscriptionData['card']['cvv'] = $cardDetails['cvv'];

                $subscriptionData['customer']['id'] = 'cust_sullivan_pc_' . $companyInfo['basic_info']->id . '_' . time();
                $subscriptionData['customer']['email'] = $companyInfo['basic_info']->email;

                $subscriptionData['plan']['id'] = $stripeProductId;
                
                try {                               
                    $objStripe = new StripeInterface();                    
                    $responseData = $objStripe->createPlanSubscription($stripeDetail['secret_key'],$subscriptionData);                                        
                    if ($responseData['status']) {
                        $this->Subscriptions = TableRegistry::get('Subscriptions');
                        $subscription['user_id'] = $userId;
                        $subscription['subscription_id'] = $responseData['subscription']['id'];
                        $subscription['customer_id'] = $responseData['subscription']['customer'];
                        $subscription['status'] = $responseData['subscription']['status'];
                        $subscription['plan_id'] = $stripeProductId;
                        $subscription['subscription_plan_id'] = $subscriptionPlanId;
                        $subscription['amount'] = $this->SubscriptionPlans->getPriceById($subscriptionPlanId);
                        $subscription['start_date'] = date('Y-m-d H:i:s', $responseData['subscription']['current_period_start']);
                        $subscription['next_date'] = date('Y-m-d H:i:s',$responseData['subscription']['current_period_end']);
                        $subscription['location'] = $cardDetails['location'];
                        $subscription['paymet_gateway'] = 'Stripe';
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
                $responseData['msg'] = 'Stripe authentication failed! Please contact to NYCompliance';
            }
        } else {
            $responseData['msg'] = 'Company not Found. Please contact to NYCompliance';
        }        
        return $responseData;
    }

}
