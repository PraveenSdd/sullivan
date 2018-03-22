<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Inflector;

class UploadComponent extends Component {
    /*
     * Function:uploadUserForm()
     * Description: use for Upload form from frontend user or company
     * @param type $file
     * @param type $userName
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 20th Nov. 2017
     */
    
    

    public function uploadUserForm($file = null, $userName = null) {

        if (isset($file['file']) && $file['file']["error"] == 0) {
            $allowed = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg', 'doc', 'docx', 'pdf', 'xls', 'xlsx', 'jpg', 'png', 'gif', 'jpeg');
            $filename = $file['file']['name'];
            $filetype = $file['file']["type"];
            $filesize = $file['file']["size"];

            /* get file extension */
            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            if (!in_array($ext, $allowed)) {
                $this->Flash->error(__('Error: Please select a valid file format.'));
                return $this->redirect(['controller' => 'Assets', 'action' => 'add']);
            }
            /* Verify of the file extension */

            if (in_array($filetype, $allowed)) {
                $date = date("Ymdhis-");
                $folderName = $userName;
                $path = WWW_ROOT . "files/project_documents/" . $folderName;
                if (!is_dir($path)) {
                    mkdir($path);
                    chmod($path, 0777);
                }

                $documentname = $date . $file['file']["name"];
                move_uploaded_file($file['file']["tmp_name"], $path . '/' . $documentname);
                return "files/project_documents/" . $folderName . '/' . $documentname;
            } else {
                $this->Flash->error(__('Error: There was a problem uploading your file. Please try again.'));
                return FALSE;
            }
        } else {
            return false;
        }
    }

    /*
     * Function:uploadOtherFile()
     * Description: use for Upload Image of home backend Admin
      * @param type $file
     * @param type $path
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 24th Nov. 2017
     */

   
    public function uploadOtherFile($file = null, $path = null) {
        if (isset($file) && $file["error"] == 0) {

            $allowed = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg', 'doc', 'docx', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/pdf', 'pdf', 'xls', 'xlsx', 'jpg', 'png', 'gif', 'jpeg','application/vnd.ms-excel','application/msword','doc', 'docx');
            $filename = $file['name'];
            $filetype = $file["type"];
            $filesize = $file["size"];
            /* Verify file extension */
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            //if (!in_array($ext, $allowed)) { 
            if (false) {
                return false;
            }
            /* Verify MYME type of the file */
            //if (in_array($filetype, $allowed)) { 
            if (true) {
                $date = date("Ymdhis");
                $documentname = $date . Inflector::slug($file["name"], '') . '.' . $ext;
                $newpath = WWW_ROOT . $path . "/" . $documentname;
                move_uploaded_file($file["tmp_name"], $newpath);
                return $path . "/" . $documentname;
            } else {
                return FALSE;
            }
        } else {
            return false;
        }
    }

     public function checkFileUpload($files){
       
       if($files["PermitForm"]["error"]["file"] == 0){
            $allowedExts = array("pdf"); 
            $tmp = explode('.', $files["PermitForm"]["name"]["file"]);
            $extension = $tmp[1];
            
            $mimeArray = array('application/pdf');
            $mime = mime_content_type($files["PermitForm"]["tmp_name"]["file"]);
            if ( ( in_array($extension, $allowedExts) ) 
                && 
                ( $files["PermitForm"]["size"]["file"] < 200000 )
                &&
                ( in_array($mime, $mimeArray) )
               )
            {      
              return 'Success';
            }
            else
            {
              return 'Error';
            }return 'Error';
        }return 'Error';

    }


     public function checksaveRelatedDocument($files){
        if($files["PermitDocument"]["error"]["file"] == 0)
        {
            $allowedExts = array("pdf", "doc", "docx","xla","xlc","xlm","xls","ppt"); 
            $tmp = explode('.', $files["PermitDocument"]["name"]["file"]);
            $extension = $tmp[1];
            // link https://www.thoughtco.com/file-extensions-and-mime-types-3469109
            $mimeArray = array('application/pdf','application/msword','application/vnd.ms-excel','application/msexcel','application/x-msexcel','application/x-ms-excel','application/x-excel','application/x-dos_ms_excel','application/xls','application/x-xls','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-powerpoint','application/vnd.ms-office');
            $mime = mime_content_type($files["PermitDocument"]["tmp_name"]["file"]);
            if ( ( in_array($extension, $allowedExts) ) 
                && 
                ( $files["PermitDocument"]["size"]["file"] < 200000 )
                &&
                ( in_array($mime, $mimeArray) )
               )
            {      
              return 'Success';
            }
            else
            {
              return 'Error';
            }return 'Error';
        }return 'Error';
    }



    /*
     * Function:uploadOtherFile()
     * Description: use for Upload Image of home backend Admin
     * @param type $file
     * @param type $path
     * @return boolean
     * By @Ahsan Ahamad
     * Date : 24th Nov. 2017
     */

 
    public function uploadImage($file = null, $path = null) {
        if (isset($file) && $file["error"] == 0) {
            $allowed = array('image/gif', 'image/png', 'image/jpg', 'image/jpeg', 'jpg', 'png', 'gif', 'jpeg');
            $filename = $file['name'];
            $filetype =$file["type"];
            $filesize = $file["size"];
            /* Verify file extension */
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            if (!in_array($ext, $allowed)) {
                $this->Flash->error(__('Error: Please select a valid file format.'));
                return $this->redirect(['controller' => 'Assets', 'action' => 'add']);
            }
            /* Verify MYME type of the file */

            if (in_array($filetype, $allowed)) {
                $date = date('Ymd');
                $documentname = $date . $filename;
                $newpath = WWW_ROOT . $path . "/" . $documentname;
                move_uploaded_file($file["tmp_name"], $newpath);
                
                return $path . "/" . $documentname;
            } else {
                $this->Flash->error(__('Error: There was a problem uploading your file. Please try again.'));
                return FALSE;
            }
        } else {
            return false;
        }
    }

}

?>