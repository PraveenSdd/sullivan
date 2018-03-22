<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PermitFormsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_forms');

        $this->belongsTo('Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id',
        ]);

        $this->hasMany('PermitFormSamples', [
            'className' => 'PermitFormSamples',
            'foreignKey' => 'permit_form_id',
            'conditions' => ['PermitFormSamples.is_active' => 1, 'PermitFormSamples.is_deleted' => 0]
        ]);
        $this->hasOne('UserPermitForms', [
            'className' => 'UserPermitForms',
            'foreignKey' => 'permit_form_id',
            'order' => ['id' => 'Desc']
        ]);
    }

    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getDataByPermitId($permitId) {
        return $this->find()->contain(['PermitFormSamples'])->where(['PermitForms.permit_id' => $permitId, 'PermitForms.is_active' => 1, 'PermitForms.is_deleted' => 0])->all();
    }

    public function getAssignedPermitFormList($permitId) {
        $formList = $this->find('list');
        $formList->hydrate(false)->where(['PermitForms.permit_id' => $permitId, 'PermitForms.is_deleted' => 0, 'PermitForms.is_active' => 1]);
        $formList = $formList->toArray();
        return $formList;
    }

}

?>
