<?php 
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\ORM\TableRegistry;

class EncryptionHelper extends Helper
{

     
        
   public $skey= "SuPer";
   
  /* @Function: encode()
     * @Description: function use for encode id
     * @param type $value
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 9th Oct. 2017
     */

    public function encode($value) {

        if (!$value) {
            return false;
        }
        $crypttext = $value;
        return trim($this->safe_b64encode($crypttext));
    }

    /* @Function: encode()
     * @Description: function use for decode id
     * @param type $value
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 9th Oct. 2017
     */

    public function decode($value) {

        if (!$value) {
            return false;
        }
        $decrypttext = $this->safe_b64decode($value);
        return trim($decrypttext);
    }

    /* @Function: encode()
     * @Description: function use for safe_b64encode string
     * @param type $string
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 9th Oct. 2017
     */

    public function safe_b64encode($string) {

        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    /* @Function: encode()
     * @Description: function use for safe_b64decode string
     * @param type $string
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 9th Oct. 2017
     */

    public function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }
    
    
    
}
?>