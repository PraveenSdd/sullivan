<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class PermitStatusTable extends Table {
    public function initialize(array $config)
    {
        $this->setTable('permit_status');
        
    }

}

?>
