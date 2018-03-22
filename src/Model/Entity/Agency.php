<?php
// src/Model/Entity/User.php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Agency extends Entity
{

    // Make all fields mass assignable except for primary key field "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    // ...

   protected function _setName($name)
    {
        if (strlen($name) > 0) {            
            return $this->setUcWords($name);
        }
    }
    
    protected function _setSlug($slug)
    {
        if (strlen($slug) > 0) {            
            return $this->generateSlug($slug);
        }
    }
    
    
}


?>
