<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class HowItWorksTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );

    }

    public function validationDefault(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('title', 'Please enter title')
                ->notEmpty('description', 'Please enter description');

        return $validator;
    }

    
}

?>
