<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Network\Email\Email;
use Cake\ORM\TableRegistry;

class CustomComponent extends Component {
    
    /*Function: token()
     * @Description: function use for generate token function    
     * By @Ahsan Ahamad
     * Date : 9th Nov. 2017
     */

    public function token() {
        $timeStr = date('YmdHis');
        $str = substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1, 10))), 1, 10);
        $token = (new DefaultPasswordHasher)->hash($str);
        $token = str_replace('/', '-', $token);
        return $token;
    }

    /* @Function: sendEmail()
     * @Description: function use for common send email
     * @param type $data
     * @param type $to
     * @param type $template
     * @param type $subject
     * @return boolean     
     * @By @Ahsan Ahamad
     * @Date : 9th Nov. 2017
     */

    

    public function sendEmail($data, $to, $template, $subject) {

        $Email = new Email();
        $Email->transport('gmail3');
        $Email->viewVars(array("data" => $data));
        $Email->to($to);
        $Email->subject($subject);
        // $Email->from($from);
        $Email->template($template);
        $Email->emailFormat('html');
        if ($Email->send()) {
            return true;
        } else {
            return false;
        }
    }
    
    /* @Function: sendEmail()
     * @Description: function use for common send email function
     * @param type $emails
     * @param type $template
     * @param type $subject
     * @param type $data
     * @return boolean    
     * @By @Ahsan Ahamad
     * @Date : 9th Nov. 2017
     */

 
    public function sendMultipleEmail($emails= null, $template = null,$subject=null, $data = null) {
        $Email = new Email();
        $Email->transport('gmail3');
        foreach($emails as $email) {
            $Email->to($email);
            $Email->viewVars(array("data" => $data));
            $Email->subject($subject);
            $Email->template($template);
            $Email->emailFormat('html');
            $Email->send();
            }
             return true;
            
        
    }
    

    /* @Function: multipleFlash()
    * @Description: function use for common flash messages 
    * @param type $errorArray
    * @return string 
    * By @Ahsan Ahamad
    * Date : 9th Nov. 2017
     */

    public function multipleFlash($errorArray = array()) {
        $errorString = '';
        if ($errorArray) {
            $errorString = "<ul class='ul-flash'>";
            foreach ($errorArray as $key=> $errors) {
                if (is_array($errors)) {
                    foreach ($errors as $error) {
                        $errorString .= "<li class='li-flash'>". ucwords($key).": ".$error."</li>";
                    }
                } else {
                    $errorString .= "<li class='li-flash'>". ucwords($key).": ".$error."</li>";
                }
            }            
            $errorString .= "</ul>";
        }
        return $errorString;
    }
    
    
    /* @Function: checkUniqueCompany()
     * @Description: function use for check Unique user unique company name
     * @param type $company
     * @param type $userId
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 9th Nov. 2017
     */  
    
    
     public function checkUniqueCompany($company = null, $userId = null) {
        $responseFlag = false;
        print($company);exit;
        $conditions = array('Users.company' => $company, 'Users.is_deleted' => 0); 
        if ($userId) {
            $conditions['Users.id !='] = $userId;
        }
        $user = $this->find()->select(['company','id'])->where($conditions)->first();
    
        if ($user) {
            $responseFlag =  false;
        } else {
            $responseFlag =  true;
        }
        return $responseFlag;
    }
    
    /* @Function: superAdminInfo()
     * @Description: function use for get super admin details
     * @return type
     * By @Ahsan Ahamad
     * Date : 9th Nov. 2017
     */     
    
   
    public function superAdminInfo(){
         $usersTable = TableRegistry::get('Users');
         $admin = $usersTable->find()->where(['is_deleted' => 0,'role_id' => 1])->first();
        return $admin;
    }
    
     /* @Function: getFormAttachments()
     * @Description: function use for get user attechment form
      * @param type $formId
     * @return type
     * By @Ahsan Ahamad
     * Date : 9th Nov. 2017
     */  
    
    public function getFormAttachments($formId = null){
        $formAttachmentsTable = TableRegistry::get('FormAttachments');
        $formAttachments = $formAttachmentsTable->find()->contain(['FormAttachmentSamples'])->where(['FormAttachments.form_id ' => $formId])->all();
    return $formAttachments;
        
    }

}

?>