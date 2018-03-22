<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class SecurityTypesTable extends Table {    
    function initialize(array $config) {
        parent::initialize($config);        
        $this->setTable('security_types');
        
         $this->hasOne('PermitForms', [
            'className' => 'PermitForms',
            'foreignKey' => 'permit_form_id'
        ]);
         
        $this->hasOne('PermitDocuments', [
            'className' => 'PermitDocuments',
            'foreignKey' => 'permit_document_id'
        ]); 
    }
    
    /**
     * 
     * @return array list
     */
    public function getList() {
        $stateList = $this->find('list', ['keyField' => 'id','valueField' => 'name']);
        $stateList->hydrate(false)->select(['id','name'])->where(['SecurityTypes.is_deleted' => 0, 'SecurityTypes.is_active' => 1]);
        return $stateList->toArray();
    }
    
}

?>
