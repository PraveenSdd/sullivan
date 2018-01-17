<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FormIndustriesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('form_industries');
        
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
            'foreignKey' => 'form_id'
        ]);
    }

  
}

?>
