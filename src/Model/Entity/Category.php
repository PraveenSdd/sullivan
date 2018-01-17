<?php
// src/Model/Entity/User.php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Category extends Entity
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
     protected function _setAddress1($address1)
    {
        if (strlen($address1) > 0) {
            return (trim($address1));
        }
    }
   protected function _setAddress2($address2)
    {
        if (strlen($address2) > 0) {
            return (trim($address2));
        }
    }
   protected function _setCity($city)
    {
        if (strlen($city) > 0) {
            return (ucfirst(trim($city)));
        }
    }
   protected function _setZipcode($zipcode)
    {
        if (strlen($zipcode) > 0) {
            return (trim($zipcode));
        }
    }
    

    // ...
}


?>