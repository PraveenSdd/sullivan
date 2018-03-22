<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;

class DocumentsTable extends Table {

    public function initialize(array $config) {
        $this->setTable('documents');
        $this->hasOne('PermitDocuments', [
            'className' => 'PermitDocuments',
            'foreignKey' => 'document_id',
            'conditions' => ['PermitDocuments.is_active' => 1, 'PermitDocuments.is_deleted' => 0]
        ]);
    }

    public function validationAdd(Validator $validator) {
        $validator = new Validator();
        $validator->notEmpty('category_id', 'Please enter category id');
        return $validator;
    }

    /**
     * 
     * @param int $permitId
     * @param int $operationId
     * @return array list
     */
    public function getUnAssignedDocumentList($permitId) {
        $this->PermitDocuments = TableRegistry::get('PermitDocuments');
        $assignDocumentList = $this->PermitDocuments->getAssignedDocumentListByPermitId($permitId);
        $documentList = $this->find('list');
        if (!empty($assignDocumentList)) {
            $documentList->hydrate(false)->where(['Documents.is_deleted' => 0, 'Documents.is_active' => 1, 'NOT' => ['Documents.id IN' => $assignDocumentList]])->order(['Documents.name' => 'ASC']);
        } else {
            $documentList->hydrate(false)->where(['Documents.is_deleted' => 0, 'Documents.is_active' => 1])->order(['Documents.name' => 'ASC']);
        }
        return $documentList->toArray();
    }

    public function getAssignedDocumentList($assignDocumentList = null) {
        $documentList = [];
        if (!empty($assignDocumentList)) {
            $documentList = $this->find('list');
            $documentList->hydrate(false)->where(['Documents.id IN' => $assignDocumentList, 'Documents.is_deleted' => 0, 'Documents.is_active' => 1]);
            $documentList = $documentList->toArray();
        }
        return $documentList;
    }

}

?>
