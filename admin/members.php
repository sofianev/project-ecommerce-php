<?php


// manage page 
//youcan edit|delete|insert 



session_start();

if (isset($_SESSION['Username'])) {
  $pageTitle='members';


   include 'init.php';


	$do= isset($_GET['do']) ? $_GET['do'] : 'manage'  ; 

  if($do=='manage'){  //manage page
    $query='';
    if(isset($_GET['page'])&& $_GET['page']=='pending'){

      $query='AND register = 0';
    }

    //select users 
    $stmt=$con->prepare("SELECT * FROM  users WHERE GroupID!=1 $query");
    //excute the stmt
    $stmt->execute();
    //assign to variable
    $row=$stmt->fetchAll();

 ?>
   <h1 class="text-center">Manage Mmembers </h1>
       <div class="container"> 
      <div class ="table responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>#ID</td>
             <td>username</td>
              <td>Email</td>
               <td>full name</td>
                <td>register date </td>
                 <td>controle</td>
          </tr>

          <?php
           foreach ($row as $row ) {
            echo"<tr>";
            echo "<td>" . $row['ID']       . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email']    . "</td>";
            echo "<td>" . $row['fallName'] . "</td>";
            echo "<td>" . $row ['date']    . "</td>";
            echo "<td> 
                        <a href='members.php?do=Edit&userID=" . $row['ID'] . "'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                        <a href='members.php?do=Delete&userID=" . $row['ID'] ."' class='confirm btn btn-danger'><i class='fa fa-delete'></i>Delete</a>";
               
                if($row['register']== 0){
                 echo" <a href='members.php?do=activate&userID=" . $row['ID'] ."' class='confirm btn btn-info'><i class='fa fa-activate'></i>activate</a>";
                }

               echo "</td>";

           echo"</tr>";
         }

            
          ?>
         
        </table>






 
    <a href="members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New member </a>;
    </div>
  <?php 
}elseif($do=='Add'){ //ADD MEMBERS ?>
   
    
       <h1 class="text-center">Add New Member </h1>

       <div class="container">

        <!--  yadkhl hna  && send  to the page update with method post -->

          <form class="form-horizontal" action="?do=Insert" method="POST">
      
            <!--stat username field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">username</label>
              <div class="col-sm-10 col-md-4">
                <input type="text" name="username"   class="form-control" autocomplete="off" required="required" placeholder="username is the best"/>
              </div>
            </div>

          <!--stat password field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Password</label>
              <div class="col-sm-10 col-md-4">
                
                <input type="password" name="password" class="password form-control"  autocomplete="new-password" required="required" placeholder="must be chalange carachter and umber" />
                 <i class="show-pass fa fa-eye fa-2x"></i>
              </div>
            </div>
            <!--stat email field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Email</label>
              <div class="col-sm-10 col-md-4">
                <input type="email" name="email"   class="form-control" required="required"placeholder="email is the best" />
              </div>
            </div>
            <!--stat fulname field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">FullName</label> 
              <div class="col-sm-10 col-md-4">
                <input type="text" name="full"   class="form-control" requierd="requierd" placeholder="profile name" />
              </div>
            </div>
            <!--stat submit field  -->
            <div class="form-group ">
              
              <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Add Memebr" class="btn btn-primary btn-lg"/>
              </div>
            </div>
        </form>
       </div> 
    


  

 

  <?php 
  }elseif ($do=='Insert') { // Insert page 

   

  if($_SERVER['REQUEST_METHOD']=='POST'){
      
      echo " <h1 class='text-center'> Insert Mmembers </h1>";
      echo "<div class='container'>";
   // get variabable ffrom the form
   
    $userr    =$_POST['username']; 
    $pass     =$_POST['password'];
    $emaill   =$_POST['email']; 
    $name     =$_POST['full'];
    $hashpass=sha1($_POST['password']); 

   

     // validation the form

     $formEror=array();
     if(strlen($userr) < 4  ){

       $formEror[]= 'username can be mor <strong>4 caracter</strong> ';
     }
     if(strlen($userr) > 20  ){

       $formEror[]= 'username can be mor <strong>mor 20 caracter</strong> ';
     } 

     if(empty($userr)){

      $formEror[]= 'username cant be <strong>empty</strong> ';
       }
      if(empty($pass)){

      $formEror[]= 'password cant be <strong>empty</strong> ';
     }
     
     if(empty($emaill)){

      $formEror[]= 'email cant be <strong>empty</strong> ';
     }
     if(empty($name)){

     $formEror[]= 'fulname cant be <strong>empty</strong>' ;
     }

     foreach ($formEror as $error) {
       echo '<div class="alert alert-danger">' . $error . '</div>' ;
     }
     //if no error theack the pdate in data base
     if (empty($formEror)) {
      //cheak if user exist in data base 

          $cheak=cheakitem("username","users",$userr);
          if($cheak==1){

            $theMsg = "<div class='alert alert-danger'>sorry this user is exist </div>";
             redirecthome ($theMsg , 'back');



     }else{
       
     
    // insert  data base 
      $stmt=$con->prepare("INSERT INTO users (username, password, email, fallName,  register, date )VALUES (:zuser, :zpass, :zmail, :zname ,1 ,now())");
      $stmt->execute(array(
                             'zuser'=>$userr,
                             'zpass'=>$hashpass,
                             'zmail'=>$emaill,
                             'zname'=>$name
                            


        ));
          
        //echo succes message
         $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'required inserted</div>';
          redirecthome ($theMsg , 'back');

      }
      
      }

  }else{


    $theMsg= "you cant directory this page" ;
    redirecthome($theMsg);

  }
    echo "</div>";
    

  }elseif($do=='Edit'){ /* EDIT PAGE */	

    // chak if get request  userID s numerc && get the iteger value of it

    $user= isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) :  0;

       //select all data depend o this ID 

     
       $stmt = $con->prepare(" SELECT *  FROM  users WHERE  ID = ? LIMIT 1");

       //excute data 
    $stmt->execute(array($user));

      // fetch data  #jib nformation 
    $row = $stmt->fetch();

     // the row cont
    $count = $stmt->rowCount();

     // if there's ID show the form

     if ( $count > 0){     ?>


       <h1 class="text-center">Edit Mmembers </h1>

       <div class="container">

        <!--  yadkhl hna  && send  to the page udate with method post -->

       	  <form class="form-horizontal" action="?do=Update" method="POST">
            <input type="hidden" name="userid" value="<?php echo $user ?>"/>


       	  	<!--stat username field -->
       	  	<div class="form-group form-group-lg">
       	  		<label class="col-sm-2 control-label">username</label>
       	  		<div class="col-sm-10 col-md-4">
       	  			<input type="text" name="username"  value="<?php echo $row['username'] ?>" class="form-control" autocomplete="off" required="required" />
       	  		</div>
       	  	</div>

          <!--stat password field  -->
       	  	<div class="form-group form-group-lg">
       	  		<label class="col-sm-2 control-label">Password</label>
       	  		<div class="col-sm-10 col-md-4">
                <input type="hidden" name="oldpassword" value="<?php echo $row['password'] ?>" />
       	  			<input type="password" name="newpassword" class="password form-control"  autocomplete="new-password" required="required"  />
       	  		</div>
       	  	</div>
       	  	<!--stat email field  -->
       	  	<div class="form-group form-group-lg">
       	  		<label class="col-sm-2 control-label">Email</label>
       	  		<div class="col-sm-10 col-md-4">
       	  			<input type="email" name="email"  value="<?php echo $row['email'] ?>" class="form-control" required="required" />
       	  		</div>
       	  	</div>
       	  	<!--stat fulname field  -->
       	  	<div class="form-group form-group-lg">
       	  		<label class="col-sm-2 control-label">FullName</label> 
       	  		<div class="col-sm-10 col-md-4">
       	  			<input type="text" name="full"  value="<?php echo $row['fallName'] ?>" class="form-control" requierd="requierd" />
       	  		</div>
       	  	</div>
       	  	<!--stat submit field  -->
       	  	<div class="form-group ">
       	  		
       	  		<div class="col-sm-offset-2 col-sm-10 ">
       	  			<input type="submit" value="save" class="btn btn-primary btn-lg"/>
       	  		</div>
       	  	</div>
        </form>
       </div> 
    
       



 <?php
 // else show error message if there'sno id exist
    } else{
      echo "<div class='container'>";
      $theMsg= '<div class="alert alert-danger">thee is no id </div> ';
       redirecthome ($theMsg );
       echo "</div>";

    }

}elseif ($do=='Update') { // update page

  echo " <h1 class='text-center'> Update Mmembers </h1>";
  echo "<div class='container'>";

  if($_SERVER['REQUEST_METHOD']=='POST'){

   // get variabable ffrom the form
    $id      =$_POST['userid'];
    $userr    =$_POST['username']; 
    $emaill   =$_POST['email']; 
    $name   =$_POST['full']; 

    //paswoerd trck                                     true                false
     $pass= empty($_POST['newpassword']) ? $pass=$_POST['oldpassword'] : $pass=sha1($_POST['newpassword']);

     // validation the form

     $formEror=array();
     if(strlen($userr) < 4  ){

       $formEror[]= 'username can be mor <strong>4 caracter</strong> ';
     }

     if(empty($userr)){

      $formEror[]= 'username cant be <strong>empty</strong> ';
     }
     if(empty($emaill)){

      $formEror[]= 'email cant be <strong>empty</strong> ';
     }
     if(empty($name)){

     $formEror[]= 'fulname cant be <strong>empty</strong> ';
     }

     foreach ($formEror as $error) {
       echo '<div class="alert alert-danger">' . $error . '</div>' ;
     }
     //if no error theack the pdate in data base
     if (empty($formEror)) {
    // update data base 
        $stmt = $con->prepare(" UPDATE users SET username= ?,  email= ?,   fallName= ? ,password= ? WHERE ID=? ");
        $stmt->execute(array($userr ,$emaill , $name,$pass, $id));
        //echo succes message
         $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'required update</div>';
          redirecthome ($theMsg );

     }
      
      

  }else{


    $theMsg = "<div class='alert alert-danger'>you cant directory his page </div>" ;
    redirecthome ($theMsg );
    echo "</div>";
  }

}elseif ($do=='Delete') {  //delete page

    $user= isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) :  0;

       //select all data depend o this ID 

     
       //$stmt = $con->prepare(" SELECT *  FROM  users WHERE  ID = ? LIMIT 1");

        $cheak=cheakitem('ID', 'users', $user);

      

     // if there's ID show the form

     if ( $cheak > 0){     
      $stmt=$con->prepare("DELETE FROM users WHERE  ID=:zuser");
      $stmt->bindParam(":zuser", $user);
      $stmt->execute();

       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'required DELETE</div>';
       redirecthome ($theMsg );

  }else {echo"this id not exist";}

  } elseif ($do=='activate') {

    $user= isset($_GET['userID']) && is_numeric($_GET['userID']) ? intval($_GET['userID']) :  0;

       //select all data depend o this ID 

       //$stmt = $con->prepare(" SELECT *  FROM  users WHERE  ID = ? LIMIT 1");

        $cheak=cheakitem('ID', 'users', $user);

  
     // if there's ID show the form

     if ( $cheak > 0){     
      $stmt=$con->prepare("Update users SET register=1 WHERE  ID=?");
      
      $stmt->execute(array($user));

       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'required activated</div>';
       redirecthome ($theMsg );

  }else {echo"this id not exist";

}
}
   

 include $tpl .'footer.php';
} else {
	header('location: index.php');
	exit();
}
