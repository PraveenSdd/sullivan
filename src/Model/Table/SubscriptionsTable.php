<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SubscriptionsTable extends Table {
    
public function initialize(array $config)
    {
        $this->setTable('subscriptions');
    }

    /**
     * Check payment is made or not on registration time
     * @param type $userId
     * @return type
     */
    public function checkRegistrationByUserId($userId){        
        return $this->exists(['user_id' => $userId, 'is_registration' => 1]);
    }
    
 
    

}

?>
