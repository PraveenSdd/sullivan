<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermissionMenusTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permission_menus');
    }

    public function validationFaq(Validator $validator) {
        $validator
                ->notEmpty('name', 'Name cannot be empty');
        return $validator;
    }

}

?>
