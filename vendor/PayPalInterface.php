<?php

require_once('PayPal/autoload.php');
require_once('PayPal/common.php');

use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use PayPal\Api\ChargeModel;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Common\PayPalModel;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementDetails;
use PayPal\Api\Payer;
use PayPal\Api\CreditCard;
use PayPal\Api\FundingInstrument;
use PayPal\Api\ShippingAddress;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Details;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payment;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Webhook;
use PayPal\Api\WebhookEvent;
use PayPal\Api\WebhookEventType;
use PayPal\Api\PayerInfo;

//use PaypalIPN;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class PayPalInterface {

    public function init($clientId, $scretKey) {

        $apiContext = new ApiContext(
                new OAuthTokenCredential(
                $clientId, $scretKey
                )
        );




        $apiContext->setConfig(
                array(
                    'mode' => PAYPAL_MODE,
                    'log.LogEnabled' => false,
                    'log.FileName' => '../PayPal.log',
                    'log.LogLevel' => 'DEBUG',
                    'validation.level' => 'log',
                    'cache.enabled' => false,
                )
        );
        return $apiContext;
    }

    public function createAgreement($apiContext, $agreementData) {
        $responseData['status'] = false;
        $responseData['msg'] = '';

        try {
            $plan = new Plan();
            $plan->setName($agreementData['plan']['name'])
                    ->setDescription($agreementData['plan']['description'])
                    ->setType($agreementData['plan']['type']);

            // Define a trial plan that will charge 'trialPrice' for 'trialLength'
            // After that, the standard plan will take over.

            $paymentDefinition = new PaymentDefinition();
            $paymentDefinition->setName($agreementData['paymentDefinition']['name'])
                    ->setType($agreementData['paymentDefinition']['type'])
                    ->setFrequency($agreementData['paymentDefinition']['frequency'])
                    ->setFrequencyInterval($agreementData['paymentDefinition']['frequencyInterval'])
                    ->setCycles($agreementData['paymentDefinition']['cycle'])
                    ->setAmount(new Currency(array('value' => $agreementData['paymentDefinition']['amount'], 'currency' => 'USD')));

            $plan->setPaymentDefinitions(array($paymentDefinition));

            $merchantPreferences = new MerchantPreferences();
            $merchantPreferences->setAutoBillAmount("yes")
                    ->setInitialFailAmountAction("CONTINUE")
                    ->setMaxFailAttempts("0")
                    ->setSetupFee(new Currency(array('value' => 0, 'currency' => 'USD')))
                    ->setReturnUrl($agreementData['merchantPreferences']['returnUrl'])
                    ->setCancelUrl($agreementData['merchantPreferences']['cancelUrl'])
            //->setNotifyUrl($agreementData['merchantPreferences']['notifyUrl'])
            ;
            $plan->setMerchantPreferences($merchantPreferences);

            $createdPlan = $plan->create($apiContext);

            $patch = new Patch();

            $value = new PayPalModel('{
                           "state":"ACTIVE"
                         }');

            $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
            $patchRequest = new PatchRequest();
            $patchRequest->addPatch($patch);

            $createdPlan->update($patchRequest, $apiContext);
            $createdPlan = Plan::get($createdPlan->getId(), $apiContext);

            $agreement = new Agreement();
            $agreement->setName($agreementData['agreement']['name'])
                    ->setDescription($agreementData['agreement']['description'])
                    ->setStartDate($agreementData['agreement']['startDate']); //$agreementData['agreement']['startDate'] //->setStartDate(date("c", time() + 43200));

            $plan = new Plan();
            $plan->setId($createdPlan->getId());
            $agreement->setPlan($plan);

            $payer = new Payer();
            #IF you want to redirect to paypal account 
            //$payer->setPaymentMethod('paypal');            
            // pay via credi card
            $payer->setPaymentMethod('credit_card')
                    ->setPayerInfo(new PayerInfo(array('email' => (PAYPAL_MODE == 'live') ? $agreementData['payerInfo']['email'] : 'sullivan.sdd@smartdatainc.net')));


            //ahsan.ahamad.merchant@mailinator.com/merchantahsan
            //ahsan.ahamad.buyer.com/buyerahsan
            /* Generate Credit Card for Testing/Sandbox */
            //http://credit-card-generator.2-ee.com/q_valid-working-credit-card-numbers.htm        
            // Add Credit Card to Funding Instruments
            $creditCard = new CreditCard();
            if (PAYPAL_MODE == 'live') {
                $creditCard->setNumber($agreementData['creditCard']['cardNumber'])
                        ->setType('visa')
                        ->setExpireMonth($agreementData['creditCard']['expireMonth'])
                        ->setExpireYear($agreementData['creditCard']['expireYear'])
                        ->setCvv2($agreementData['creditCard']['cvv'])
                        ->setFirstName($agreementData['creditCard']['firstName'])
                        ->setLastName($agreementData['creditCard']['lastName']);
            } else {
                // If payment mode is 'sanbox' then use below credit card detail (this card is generated from paypal)
                $creditCard->setNumber('5302359883928792')
                        ->setType('mastercard')
                        ->setExpireMonth('01')
                        ->setExpireYear('2019')
                        ->setCvv2('444')
                        ->setFirstName('Ankit')
                        ->setLastName('Tiwari');
            }

            $fundingInstrument = new FundingInstrument();
            $fundingInstrument->setCreditCard($creditCard);
            $payer->setFundingInstruments(array($fundingInstrument));
            $agreement->setPayer($payer);

            // Add Shipping Address

            $shippingAddress = new ShippingAddress();
            $shippingAddress->setLine1('7 East 20th Street')
                    ->setCity('New York')
                    ->setState('NY')
                    ->setPostalCode('10003')
                    ->setCountryCode('US');
            $agreement->setShippingAddress($shippingAddress);


            $agreement = $agreement->create($apiContext);
            if (is_array($agreement)) {
                $responseData = $agreement;
                $responseData['status'] = false;
                return false;
            }
            $responseData['id'] = $agreement->getId();
            $responseData['state'] = $agreement->getState();
            $responseData['plan_id'] = $plan->getId();

            $agreementDetail = $agreement->getAgreementDetails();
            $responseData['start_date'] = $agreement->getStartDate();
            $responseData['next_billing_date'] = $agreementDetail->getNextBillingDate();
            $responseData['status'] = true;
        } catch (Exception $e) {
            $responseData['msg'] = $e->getMessage();
            $responseData['code'] = $e->getCode();
            $responseData['data'] = $e->getData();
        }
        return $responseData;
    }

    public function cancelAgreement($apiContext, $agreementId) {
        $responseData['status'] = false;
        $responseData['msg'] = '';
        try {
            $agreement = new Agreement();
            $agreement = Agreement::get($agreementId, $apiContext);

            //Create an Agreement State Descriptor, explaining the reason to suspend.
            $agreementStateDescriptor = new AgreementStateDescriptor();
            $agreementStateDescriptor->setNote("Agreement (Subscription) is canceled because Invoice has been deleted by admin - NYCompliances");
            $responseData['status'] = $agreement->cancel($agreementStateDescriptor, $apiContext);
        } catch (Exception $ex) {
            $responseData['msg'] = $ex->getMessage();
        }
        return $responseData;
    }

    public function getAgreement($apiContext, $agreementId) {
        $responseData['status'] = false;
        $responseData['msg'] = '';
        try {
            $agreement = new Agreement();
            $agreement = Agreement::get($agreementId, $apiContext);
            $responseData['agreement'] = $agreement;
            $responseData['status'] = true;
        } catch (Exception $e) {
            $responseData['msg'] = $e->getMessage();
            //echo $e->getMessage();
        }
        return $responseData;
    }

    /**
     * 
     * @param type $apiContext
     * @param type $agreementId
     * @param type $billingType => 1=weekly, 2= monthly, 3=quartely, 4=yearly
     * @return type
     */
    public function getAgreementData($apiContext, $agreementId, $billingType = null) {
        $billingData = '';
        try {
            $agreement = new Agreement();
            $agreement = Agreement::get($agreementId, $apiContext);
            $billingData['voidedAmount'] = 0.00;
            $billingData['refundedAmount'] = 0.00;
            $billingData['isRecurring'] = 1;
            $billingData['lastRecurringTransactionId'] = '';
            $billingData['currentStatus'] = 'Setup';
            $billingData['currentBillingDate'] = '';
            $billingData['nextBillingDate'] = '';
            $billingData['completedBillingCycle'] = $agreement->agreement_details->cycles_completed;
            $billingData['totalRecurringAmount'] = 0.00;
            if (isset($agreement->agreement_details->last_payment_date)) {
                $billingData['currentStatus'] = 'Approved';
                $billingData['totalRecurringAmount'] = $billingData['completedBillingCycle'] * $agreement->agreement_details->last_payment_amount->value;
                $billingData['currentBillingDate'] = date('Y-m-d H:i:s', strtotime($agreement->agreement_details->last_payment_date));
                if (isset($agreement->agreement_details->next_billing_date)) {
                    $billingData['nextBillingDate'] = date('Y-m-d H:i:s', strtotime($agreement->agreement_details->next_billing_date));
                } else {
                    $billingData['nextBillingDate'] = date('Y-m-d H:i:s', strtotime($agreement->agreement_details->final_payment_date));
                }
            } else {
                $billingData['currentBillingDate'] = date('Y-m-d H:i:s', strtotime($agreement->start_date));
                $billingData['nextBillingDate'] = $this->getNextBillingDate($billingData['nextBillingDate'], $billingType);
            }

            if ($agreement->state != 'Active') {
                $billingData['currentStatus'] = $agreement->state;
            }
            if ($agreement->agreement_details->cycles_remaining == 0) {
                $billingData['currentStatus'] = 'Completed';
            }

            $billingData['totalAmount'] = $billingData['totalRecurringAmount'];
            $billingData['recurringTransaction'] = array();
        } catch (Exception $e) {
            $billingData = '';
        }
        return $billingData;
    }

    /**
     * 
     * @param type $currentBillingDate
     * @param type $billingType
     * @return type
     */
    public function getNextBillingDate($currentBillingDate, $billingType) {
        $nextBillingDate = '';
        switch ($billingType) {
            case 1;
                $nextBillingDate = date('Y-m-d H:i:s', strtotime($currentBillingDate . '+7 day'));
                break;
            case 2;
                $nextBillingDate = date('Y-m-d H:i:s', strtotime($currentBillingDate . '+1 month'));
                break;
            case 3;
                $nextBillingDate = date('Y-m-d H:i:s', strtotime($currentBillingDate . '+3 month'));
                break;
            case 4;
                $nextBillingDate = date('Y-m-d H:i:s', strtotime($currentBillingDate . '+1 year'));
                break;
        }
        return $nextBillingDate;
    }

}
