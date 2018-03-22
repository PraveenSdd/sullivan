<?php
/*
*	
*	Author: Varun Sharma
*/
define("ROOT_PATH",realpath(dirname(__FILE__)));
 
$download_config = array(
	'allowed' => array("pdf","doc","xls","ppt","gif","png","jpg","jpeg","mp3","wav","mpeg","mpg","mpe","mov","avi"),
	'denied' =>array("php","ini","zip","psd","log","htaccess","htpasswd","phps","fla","sh","phtml","js","css")
);
 
if(!isset($_REQUEST['path']) or !isset($_REQUEST['filename']) or empty($_REQUEST['path']) or empty($_REQUEST['filename']) ){
	 echo "<h1 align='center'><em>Invalid Parameter</em></h1>";
 }else{
 	
	$fullPath = ROOT_PATH."/".$_REQUEST['path'].'/'.$_REQUEST['filename'];
	
	if(!file_exists($fullPath)){
		echo "<h1 align='center'><em>File Not Exists</em></h1>";
	}else{
 
 		$fsize = filesize($fullPath);

		$path_parts = pathinfo($fullPath);
		
		$ext = strtolower($path_parts["extension"]);
		
		if(in_array($ext,$download_config['denied'])){
			echo "<h1 align='center'><em> Access Denied </em></h1>";
		}else{
 			if($fd = fopen ($fullPath, "r")) {
 				switch ($ext){
					case "pdf": $ctype="application/pdf"; break;
					case "bmp": $ctype="application/bmp"; break;
					case "zip": $ctype="application/zip"; break;
					case "doc": $ctype="application/msword"; break;
					case "docx": $ctype="application/msword"; break;
					case "xls":  $ctype="application/vnd.ms-excel"; break;
					case "xlsx": $ctype="application/vnd.ms-excel"; break;
					case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
					case "gif": $ctype="image/gif"; break;
					case "png": $ctype="image/png"; break;
					case "jpg": $ctype="image/jpg"; break;
					case "jpeg": $ctype="image/jpg"; break;
					case "txt": $ctype="text/plain"; break;
					case "mp4": $ctype="video/mp4"; break;
					case "psd": $ctype="image/psd"; break;
					case "rtf": $ctype="application/rtf"; break;
					default: $ctype="application/octet-stream";
				}
				header("Content-type: $ctype");
				header("Content-Disposition:attachment; filename=\"".$path_parts["basename"]."\"");
				header("Content-length: $fsize");
				header("Cache-control: private"); 
 				while(!feof($fd)) {
					$buffer = fread($fd,100000);
					echo $buffer;
				}
			}
 			fclose ($fd);
 		}
 		exit;
	}
}
