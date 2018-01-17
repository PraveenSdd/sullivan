<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermissionAccessTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permission_access');
        
       
    }

    
    public function validationFaq(Validator $validator) {
        $validator
                ->notEmpty('permission_id', 'Name cannot be empty')
                ->notEmpty('permission_menu_id', 'Name cannot be empty');
        return $validator;
    }

}

?>
