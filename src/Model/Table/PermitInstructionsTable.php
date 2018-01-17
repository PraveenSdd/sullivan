<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitInstructionsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_instructions');
    }

    public function validationDefault(Validator $validator) {
        $validator
                ->notEmpty('title', 'Please enter title');
        return $validator;
    }

}

?>
