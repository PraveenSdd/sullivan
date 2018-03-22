<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class EmailTemplatesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('email_templates');
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );
    }

    public function getEmailTemplateById($id = null) {
        return $this->find()->where(['id' => $id])->first();
    }

}

?>
