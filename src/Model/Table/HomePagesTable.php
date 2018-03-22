<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class HomePagesTable extends Table {

    public function initialize(array $config) {
        $this->setTable('home_pages');

        $this->hasMany(
                'SubHomePage', [
            'className' => 'Homepages',
            'foreignKey' => 'home_page_id'
        ]);
        $this->belongsTo(
                'Users', [
            'className' => 'Users',
            'foreignKey' => 'modified_by'
                ]
        );
    }

    public function validationEdit(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('title', 'Please upload form');
        $validator->notEmpty('description', 'Please upload form');
        return $validator;
    }

}

?>
