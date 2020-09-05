
<?php

 /*
$host='localhost';
$username='root';
$password='';
$dbase='shop';

$con = mysqli_connect($host,$username,$password,$dbase);

if($con){
    //echo "Successfully connected to server";
}
else{
    echo "Failed";
}

*/




	$dsn = 'mysql:host=localhost;dbname=shop';
	$user = 'root';
	$pass = '';
	$option = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	);

	try {
		$con = new PDO($dsn, $user, $pass, $option);
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	catch(PDOException $e) {
		echo 'Failed To Connect' . $e->getMessage();
	}
    /*if($con){
    echo "Successfully connected to server";
}
else{
    echo "Failed";
}
*/

?>

  
