<?php
// src/Model/Entity/User.php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Alert extends Entity
{

    // Make all fields mass assignable except for primary key field "id".
    protected $_accessible = [
        '*' => true,
        'id' => false
    ];

    // ...

   protected function _setTitle($title)
    {
        if (strlen($title) > 0) {
            return (ucfirst(trim($title)));
        }
    }
   protected function _setNotes($notes)
    {
        if (strlen($notes) > 0) {
            return (trim($notes));
        }
    }
    

    // ...
}


?>
