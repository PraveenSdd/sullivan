<?php

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\RulesChecker;
use Cake\ORM\Rule\IsUnique;

class CategoriesTable extends Table {

    function initialize(array $config) {
        parent::initialize($config);

        $this->setTable('categories');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        
        $this->hasOne('Addresses', [
            'className' => 'Addresses',
            'foreignKey' => 'agency_id'
        ]);
        

        $this->hasMany('AgenyIndustries', [
            'className' => 'AgenyIndustries',
            'foreignKey' => 'category_id'
        ]);
    }

    /*
 * validationAdd() use for check validation agency/category
 * By @Ahsan Ahamad
 * Date : 13th Jan. 2018
 */
    
    public function validationAdd(Validator $validator) {

        $validator
                ->notEmpty('name', 'Agency name cannot be empty');
                
                return $validator;
    }
    
/*
 * buildRules() use for check Unique agency/category
 * By @Ahsan Ahamad
 * Date : 13th Jan. 2018
 */
    
    
 public function buildRules(RulesChecker $rules){

        $rules->add($rules->isUnique(['name'], 'Agencies name already exits'));

        return $rules;
    }
    
/*
 * Function:checkCategoryUniqueName()
 * Description: use for check Unique agency/category by ajax
 * By @Ahsan Ahamad
 * Date : 13th Jan. 2018
 */
    

    public function checkAgencyUniqueName($categoryName = null, $categoryId = null, $parentId = null) {
        $responseFlag = false;
        $conditions = array('LOWER(Categories.name)' => strtolower($categoryName), 'Categories.is_deleted' => 0);
        if ($categoryId) {
            $conditions['Categories.id !='] = $categoryId;
        }
        
        $category = $this->find()->select(['name', 'id'])->where($conditions)->first();

        if ($category) {
            $responseFlag = false;
        } else {
            $responseFlag = true;
        }
        return $responseFlag;
    }

}

?>
