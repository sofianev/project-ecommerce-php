<?php

session_start();

$pageTitle='login';
if (isset($_SESSION['Username'])) {

 header('location: dashboard.php');  //redirect to accuiel.php..
 //exit();
 }


include 'init.php';





  if ($_SERVER['REQUEST_METHOD']== 'POST'){

      $username = $_POST['user'];
       $password = $_POST['pass'];
       $hashedPass = sha1($password);
       // echo $username,$hashedPass;



       $stmt = $con->prepare("SELECT 
               ID, Username, Password 
                FROM 
                  users 
                WHERE 
                  username = ? 
                AND 
                  password = ? 
                AND 
                  GroupID = 1
                LIMIT 1");

    $stmt->execute(array($username, $hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();

               //cheack if the user exict
         
       if ($count > 0){
        	$_SESSION ['Username'] = $username; //regiser session name
          $_SESSION ['userID'] = $row['ID']; //        register session ID 
        header('location: dashboard.php'); //redirect to accuiel.php..
        exit();
        }

}

?>

  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="user" placeholder="Username" autocomplete="off" />
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password" />
    <input class="btn btn-primary btn-block" type="submit" value="Login" />
  </form>



<?php include $tpl .'footer.php' ;?>
