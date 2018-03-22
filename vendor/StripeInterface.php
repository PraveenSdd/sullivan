<?php

include('Stripe/init.php');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class StripeInterface {

    public function init($secretKey) {
        \Stripe\Stripe::setApiKey($secretKey);
    }
    
    
    /**
     * 
     * @param type $secretKey
     * @param type (array) $subscriptionData 
     * @return type (array)
     */
    public function createPlanSubscription($secretKey,$subscriptionData) {
        $objStripe = $this->init($secretKey);
        $token = $customer = $plan = $subscription = array();
        $responseData['status'] = false;
        $responseData['msg'] = '';
        $errorMsg = '';
        try {
            $token = \Stripe\Token::create(array(
                        "card" => array(
                            "number" => $subscriptionData['card']['number'],
                            "exp_month" => $subscriptionData['card']['expMonth'],
                            "exp_year" => $subscriptionData['card']['expYear'],
                            "cvc" => $subscriptionData['card']['cvv'],
                        )
            ));
            $token = json_decode(json_encode($token), true);

            $customer = \Stripe\Customer::create(array(
                        "id" => $subscriptionData['customer']['id'],
                        "email" => $subscriptionData['customer']['email'],
                        'card' => $token['id'],
            ));
            $customer = json_decode(json_encode($customer), true);
            /*
            $plan = \Stripe\Plan::create(array(
                        "id" => $subscriptionData['plan']['id'],
                        "name" => $subscriptionData['plan']['name'],
                        "currency" => "usd",
                        "amount" => $subscriptionData['plan']['amount'],
                        "interval" => $subscriptionData['plan']['interval'],
                        'interval_count' => $subscriptionData['plan']['intervalcount'],
                        'trial_period_days' => $subscriptionData['plan']['trialPeriodDays'],
            ));
            $plan = json_decode(json_encode($plan), true);
            */
            $subscription = \Stripe\Subscription::create(array(
                        "customer" => $customer['id'],
                        "plan" => $subscriptionData['plan']['id'],
            ));
            $subscription = json_decode(json_encode($subscription), true);
            $responseData['status'] = true;
            $responseData['subscription'] = $subscription;
        } catch (Exception $subscribtionEx) {
            $subscribtionEx = json_decode(json_encode($subscribtionEx), true);
            $responseData['msg'] = $subscribtionEx['jsonBody']['error']['message'];
        }
        return $responseData;
    }
    

    /**
     * 
     * @param type $secretKey
     * @param type (array) $subscriptionData 
     * @return type (array)
     */
    public function createCustomSubscription($secretKey,$subscriptionData) {
        $token = $customer = $plan = $subscription = array();
        $responseData['status'] = false;
        $responseData['msg'] = '';
        $errorMsg = '';
        try {
            $token = \Stripe\Token::create(array(
                        "card" => array(
                            "number" => $subscriptionData['card']['number'],
                            "exp_month" => $subscriptionData['card']['expMonth'],
                            "exp_year" => $subscriptionData['card']['expYear'],
                            "cvc" => $subscriptionData['card']['cvv'],
                        )
            ));
            $token = json_decode(json_encode($token), true);

            $customer = \Stripe\Customer::create(array(
                        "id" => $subscriptionData['customer']['id'],
                        "email" => $subscriptionData['customer']['email'],
                        'card' => $token['id'],
            ));
            $customer = json_decode(json_encode($customer), true);

            $plan = \Stripe\Plan::create(array(
                        "id" => $subscriptionData['plan']['id'],
                        "name" => $subscriptionData['plan']['name'],
                        "currency" => "usd",
                        "amount" => $subscriptionData['plan']['amount'],
                        "interval" => $subscriptionData['plan']['interval'],
                        'interval_count' => $subscriptionData['plan']['intervalcount'],
                        'trial_period_days' => $subscriptionData['plan']['trialPeriodDays'],
            ));
            $plan = json_decode(json_encode($plan), true);

            $subscription = \Stripe\Subscription::create(array(
                        "customer" => $customer['id'],
                        "plan" => $plan['id'],
            ));
            $subscription = json_decode(json_encode($subscription), true);
            $responseData['status'] = true;
            $responseData['subscription'] = $subscription;
        } catch (Exception $subscribtionEx) {
            $subscribtionEx = json_decode(json_encode($subscribtionEx), true);
            $responseData['msg'] = $subscribtionEx['jsonBody']['error']['message'];
        }
        return $responseData;
    }

}
