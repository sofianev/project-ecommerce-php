<?php 

$tpl   ='include/template/';// temlate directory
$lang  ='include/languages/';  //langages directory
$func  ='include/functions/';  //functions directory 
$css   ='layout/css/';//  css directory 
$js    ='layout/js/'; // js directory






  //include the important file 
include 'connect.php';
include $func .'functions.php';
include  $lang . 'english.php';

include $tpl . 'header.php'; 



//include nevbar in all page expect the one with $nevbar 

if (!isset($nonevbar)) {include $tpl . 'navbar.php'; }




 



?>
