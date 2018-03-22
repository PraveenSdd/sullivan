<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

class UserPermitDeadlinesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
        $this->setTable('user_permit_deadlines');
        
        $this->belongsTo(
                'Deadlines', [
            'className' => 'Deadlines',
            'foreignKey' => 'deadline_id'
                ]
        );
        
        $this->belongsTo('Documents', [
            'className' => 'Documents',
            'foreignKey' => 'document_id'
        ]); 
        $this->belongsTo('PermitForms', [
            'className' => 'PermitForms',
            'foreignKey' => 'permit_form_id'
        ]);
    }
    
    public function getAllDataByPermitId($userPermitId){        
        return $this->find()->contain([
            'Documents'=>function($q){
                return $q                        
                        ->select(['id','name']);
            }, 
            'PermitForms'=>function($q){
                return $q                        
                        ->select(['id','name']);
            }, 
            'Deadlines'=>function($q){
                return $q                        
                        ->select(['id','deadline_type_id', 'date','time']);
            }, 
            'Deadlines.DeadlineTypes'=>function($q){
                return $q                        
                        ->select(['name']);
            },         
        ])->where(['UserPermitDeadlines.user_permit_id' => $userPermitId, 'UserPermitDeadlines.is_active' => 1, 'UserPermitDeadlines.is_deleted' => 0])->all();
    }

    /**
     * 
     * @return array list
     */

}

?>
