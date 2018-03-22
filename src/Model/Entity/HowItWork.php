<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class HowItWork extends Entity {

       protected $_accessible = [
        '*' => true,
        'id' => false
    ];


     protected function _setTitle($title)
    {
        if (strlen($title) > 0) {
            return (trim($title));
        }
    }
     protected function _setDescription($description)
    {
        if (strlen($description) > 0) {
            return (trim($description));
        }
    }

    
}

?>
