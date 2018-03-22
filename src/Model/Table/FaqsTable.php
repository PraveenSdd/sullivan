<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FaqsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('faqs');
    }

    public function validationFaq(Validator $validator) {
        $validator
                ->notEmpty('question', 'Question cannot be empty')
                ->notEmpty('answer', 'Answer cannot be empty');
        return $validator;
    }

}

?>
