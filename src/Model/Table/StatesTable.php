<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class StatesTable extends Table {
    public function initialize(array $config)
    {
        $this->setTable('states');
        
    }

}

?>
