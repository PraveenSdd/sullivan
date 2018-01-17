<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class ProfessionalAssistancesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('professional_assistances');
    }

    public function validationAdd(Validator $validator) {
        $validator
                ->notEmpty('name', 'Name cannot be empty')
                ->notEmpty('email', 'Email cannot be empty');
        return $validator;
    }

}

?>
