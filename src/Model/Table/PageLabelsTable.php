<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;

class PageLabelsTable extends Table {

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
        $validator->add(
                'value', ['unique' => [
                'rule' => 'validateUnique',
                'provider' => 'table',
                'message' => 'Not unique']
                ]
        );

        return $validator;
    }

}

?>
