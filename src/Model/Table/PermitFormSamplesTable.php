<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PermitFormSamplesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_form_samples');
        
        $this->belongsTo('Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id',
        ]);

        $this->belongsTo('PermitForms', [
            'className' => 'PermitForms',
            'foreignKey' => 'permit_form_id',
        ]);
    }

}

?>
