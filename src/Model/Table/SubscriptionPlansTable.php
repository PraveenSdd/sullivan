<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubscriptionPlansTable extends Table {

    public function initialize(array $config) {
        $this->setTable('subscription_plans');

        $this->hasMany(
                'Attributes', [
            'className' => 'SubscriptionPlanAttributes',
            'foreignKey' => 'subscription_plan_id'
        ]);
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );
    }

    public function validationEdit(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('name', 'Please upload form');
        $validator->notEmpty('description', 'Please upload form');
        return $validator;
    }

    /**
     * 
     * @return type
     */
    public function getAllPlans() {
        return $this->find()->contain(['Attributes'])->hydrate(false)->select(['id', 'name', 'description', 'price'])->where(['is_deleted' => 0, 'is_active' => 1])->all();
    }

    /**
     * 
     * @param type $subscriptionPlanId
     * @return type
     */
    public function getPriceById($subscriptionPlanId) {
        $price = null;
        $data = $this->find()->hydrate(false)->select(['price'])->where(['id' => $subscriptionPlanId])->first();
        if ($data) {
            $price = $data['price'];
        }
        return $price;
    }

    /**
     * 
     * @param type $subscriptionPlanId
     * @return type
     */
    public function getStripeProductIdById($subscriptionPlanId) {
        $stripeProductId = null;
        $data = $this->find()->hydrate(false)->select(['stripe_test_product_id', 'stripe_live_product_id'])->where(['id' => $subscriptionPlanId])->first();
        if (STRIPE_MODE == 'live') {
            $stripeProductId = $data['stripe_live_product_id'];
        } else {
            $stripeProductId = $data['stripe_test_product_id'];
        }
        return $stripeProductId;
    }

}

?>
