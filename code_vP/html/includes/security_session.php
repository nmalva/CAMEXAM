<?php 
if($_SESSION["use_id"]==NULL){
   $string.="Session Out of Time </br>";
   $string.="<a href='login_form.php'>return to login</a>";
   echo $string;
   exit();
}

?>