<?php
// src/Model/Entity/User.php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class AgencyContact extends Entity
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
            return (ucfirst(trim($name)));
        }
    }
    
    protected function _setPosition($position)
    {
        if (strlen($position) > 0) {
            return (ucfirst(trim($position)));
        }
    }
    protected function _setEmail($email)
    {
        if (strlen($email) > 0) {
            return (ucfirst(trim($email)));
        }
    }
    
}


?>
