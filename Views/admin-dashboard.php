<?php 

 if($_SESSION["loggedUser"]['role'] != "admin"){
     require_once(VIEWS_PATH."index.php");
 } else {
    require_once(VIEWS_PATH."nav.php");
?>
asdffasfdsa 
<?php
 }
 ?>