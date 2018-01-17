<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitOperationsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_operations');
        
        $this->hasMany('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id'
        ]);
        $this->hasMany('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id'
        ]);
        $this->belongsTo('Forms', [
            'className' => 'Forms',
            'foreignKey' => 'permit_id'
        ]);
        $this->belongsTo('Operations', [
            'className' => 'Operations',
            'foreignKey' => 'operation_id'
        ]);
    }

  
}

?>
