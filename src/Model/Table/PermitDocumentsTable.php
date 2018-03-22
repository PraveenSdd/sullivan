<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class PermitDocumentsTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('permit_documents');
                
        $this->belongsTo('Permits', [
            'className' => 'Permits',
            'foreignKey' => 'permit_id',
        ]);
        $this->belongsTo('Documents', [
            'className' => 'Documents',
            'foreignKey' => 'document_id',
        ]);
        $this->hasOne('UserPermitDocuments', [
            'className' => 'UserPermitDocuments',
            'foreignKey' => 'permit_document_id',
            'order'=> ['id'=>'Desc']
        ]);
       
    }
    
    public function validationDefault(Validator $validator) {
        $validator
                ->notEmpty('name', 'Please enter name');
        return $validator;
    }
    
    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getDataByPermitId($permitId){
        return $this->find()->contain(['Documents'])->where(['PermitDocuments.permit_id' => $permitId, 'PermitDocuments.is_active' => 1, 'PermitDocuments.is_deleted' => 0])->all();
    }


    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function getAssignedDocumentListByPermitId($permitId) {
        $documentList = $this->find('list', ['keyField' => 'document_id', 'valueField' => 'document_id']);
        $documentList->hydrate(false)->where(['PermitDocuments.permit_id' => $permitId,'PermitDocuments.is_deleted' => 0, 'PermitDocuments.is_active' => 1]);
        return $documentList->toArray();
    }

    /**
     * 
     * @param type $permitId
     * @return type
     */
    public function checkPermitAndDocumentExistOrNot($permitId,$documentId){
        return $this->find()->where(['PermitDocuments.document_id' => $documentId,'PermitDocuments.permit_id' => $permitId, 'PermitDocuments.is_active' => 1, 'PermitDocuments.is_deleted' => 0])->count();
    }
            

}

?>
