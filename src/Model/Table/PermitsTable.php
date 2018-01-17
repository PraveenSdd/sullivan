<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permits');
        
        $this->belongsTo('UserLocations', [
          'className' => 'UserLocations',
          'foreignKey' => 'user_location_id',
        ]);
        $this->belongsTo('Industries', [
          'className' => 'Industries',
          'foreignKey' => 'industry_id',
        ]);
        $this->belongsTo('Forms', [
          'className' => 'Forms',
          'foreignKey' => 'form_id',
        ]);
        $this->belongsTo('Categories', [
            'className' => 'Categories',
            'foreignKey' => 'category_id'
        ]);
    }

    
    

}

?>
