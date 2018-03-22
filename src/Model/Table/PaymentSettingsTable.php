<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PaymentSettingsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('payment_settings');
    }
    
    public function validationEdit(Validator $validator) {
        $validator = new Validator();
            $validator->notEmpty('client_id', 'Please enter client-id');
            $validator->notEmpty('secret_key', 'Please enter secret-key');
        return $validator;
    }
    
    /**
     * 
     * @return type
     */
    public function getPaypalTest(){
        return $this->find()->hydrate(false)->select(['client_id', 'secret_key'])->where(['is_deleted' => 0, 'is_active' => 1,'payment_gateway' => 'Paypal', 'is_live_credential' => 0])->first();
    }
    
        
    /**
     * 
     * @return type
     */
    public function getPaypalLive(){
        return $this->find()->hydrate(false)->select(['client_id', 'secret_key'])->where(['is_deleted' => 0, 'is_active' => 1,'payment_gateway' => 'Paypal', 'is_live_credential' => 1])->first();
    }
    
    /**
     * 
     * @return type
     */
    public function getPaypalCredential(){
        if(STRIPE_MODE == 'live'){
            return $this->getPaypalTest();
        } else {
            return $this->getPaypalTest();
        }
    }
    
    /**
     * 
     * @return type
     */
    public function getStripeTest(){
        return $this->find()->hydrate(false)->select(['client_id', 'secret_key'])->where(['is_deleted' => 0, 'is_active' => 1,'payment_gateway' => 'Stripe', 'is_live_credential' => 0])->first();
    }
    
    /**
     * 
     * @return type
     */
    public function getStripeLive(){
        return $this->find()->hydrate(false)->select(['client_id', 'secret_key'])->where(['is_deleted' => 0, 'is_active' => 1,'payment_gateway' => 'Stripe', 'is_live_credential' => 1])->first();
    }
    
    /**
     * 
     * @return type
     */
    public function getStripeCredential(){
        if(STRIPE_MODE == 'live'){
            return $this->getStripeLive();
        } else {
            return $this->getStripeTest();
        }
    }

   
}

?>
