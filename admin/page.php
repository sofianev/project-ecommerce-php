<?php

ob_start();



session_start();


$pageTitle='categores';


if (isset($_SESSION['Username'])) {
 
   include 'init.php';

$do= isset($_GET['do']) ? $_GET['do'] : 'manage'  ; 

if ($do=='manage'){

	echo'welcome you are in manage categorie page' ;

}elseif ($do=='Edit'){

	echo'welcome youare in add categorie page' ;

}elseif  ($do=='Insert'){

   echo'welcome youare in add categorie page' ;

 }elseif  ($do=='Delete') {

 echo'welcome youare in add categorie page' ;

 }  else {

echo'error page' ;
}


ob_end_flush();	

?>
