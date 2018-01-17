<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class UserIndustriesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('user_industries');
        
        $this->hasOne('UserLocations', [
          'className' => 'UserLocations',
          'foreignKey' => 'user_location_id',
        ]);
        
        $this->belongsTo('Industries', [
          'className' => 'Industries',
          'foreignKey' => 'industry_id',
        ]);
    }


}

?>
