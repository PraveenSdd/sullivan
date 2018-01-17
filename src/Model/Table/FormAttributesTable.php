<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class FormAttributesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('form_attributes');
        
         $this->belongsTo(
            'Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id'
            ]);
         
           $this->belongsTo(
            'Industries', [
            'className' => 'Industries',
            'foreignKey' => 'industry_id'
            ]);
    }

   
}

?>
