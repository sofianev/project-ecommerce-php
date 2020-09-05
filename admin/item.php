<?php






ob_start();



session_start();

$pageTitle='Item';


if (isset($_SESSION['Username'])) {
 
   include 'init.php';


$do= isset($_GET['do']) ? $_GET['do'] : 'manage'  ; 


  if($do=='manage'){  //manage page
   

    //select users 
    $stmt=$con->prepare("SELECT * FROM item");
    //excute the stmt
    $stmt->execute();
    //assign to variable
    $items=$stmt->fetchAll();

 ?>
   <h1 class="text-center">Manage Items </h1>
       <div class="container"> 
      <div class ="table responsive">
        <table class="main-table text-center table table-bordered">
          <tr>
            <td>#ID</td>
             <td>name</td>
              <td>description</td>
               <td>price </td>
                <td>adding date </td>
                 <td>category </td>
                  <td>username </td>
                 <td>controle</td>
          </tr>

          <?php
           foreach ($items as $item ) {
            echo"<tr>";
            echo "<td>" . $item['item_ID']       . "</td>";
            echo "<td>" . $item['Name'] . "</td>";
            echo "<td>" . $item['Description']    . "</td>";
            echo "<td>" . $item['Price'] . "</td>";
            echo "<td>" . $item ['Add_date']    . "</td>";
            echo "<td>" . $item['cat_id'] . "</td>";
            echo "<td>" . $item['user_id'] . "</td>";
            echo "<td> 
                        <a href='item.php?do=Edit&userID=" . $item['item_ID'] . "'class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                        <a href='item.php?do=Delete&userID=" . $item['item_ID'] ."' class='confirm btn btn-danger'><i class='fa fa-delete'></i>Delete</a>";
               
               

               echo "</td>";

           echo"</tr>";
         }

            
          ?>
         
        </table>






 
    <a href="item.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Item </a>
    </div>
  <?php 


	

}elseif ($do=='Add'){ ?>

  <h1 class="text-center">Add New Item </h1>

       <div class="container">

        <!--  yadkhl hna  && send  to the page update with method post -->

          <form class="form-horizontal" action="?do=Insert" method="POST">
      
            <!--stat name field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10 col-md-6">
                <input type="text"
                 name="name"   
                 class="form-control"
                 requierd="requierd"
                 placeholder="name of the item"/>
              </div>
            </div>
            <!--stat description field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10 col-md-6">
               <input type="text"
                name="desc"
                requierd="requierd"
                class="form-control" 
                placeholder="description of the item "/>
              </div>
            </div>

            <!--stat price field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Price</label>
              <div class="col-sm-10 col-md-6">
                <input type="text"
                 name="price" 
                 requierd="requierd"
                 class="form-control"
                 placeholder="price of the item"/>
              </div>
            </div>

             <!-- stat country  field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Country</label>
              <div class="col-sm-10 col-md-6">
                <input type="text"
                 name="country" 
                 requierd="requierd"
                 class="form-control"
                 placeholder="country of the item"/>
              </div>
            </div>
             <!--stat status field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Status</label>
              <div class="col-sm-10 col-md-6">
                <select  name="status">
                	<option value="0">...</option>
                	<option value="2">new</option>
                	<option value="3">like new</option>
                	<option value="4">used</option>
                	<option value="5">old</option>
                </select>

              </div>
            </div>
             <!--stat members field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">member</label>
              <div class="col-sm-10 col-md-6">
                <select  name="member">
                  <option value="0">...</option>
                  <?php  
                  $stmt=$con->prepare("SELECT * FROM users");
                  $stmt->execute();
                  $users=$stmt->fetchAll();
                  foreach ($users as $user) {
                    echo "<option value='" . $user['ID'] ." '> " . $user['username'] . "</option>";
                  }

                  ?>
                </select>
              </div>
            </div>
             <!--stat categories field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">category</label>
              <div class="col-sm-10 col-md-6">
                <select  name="category">
                  <option value="0">...</option>
                  <?php  
                  $stmt2=$con->prepare("SELECT * FROM categores");
                  $stmt2->execute();
                  $cats=$stmt2->fetchAll();
                  foreach ($cats as $cat) {
                    echo "<option value='" . $cat['ID_cat'] ." '> " . $cat['Name'] . "</option>";
                  }

                  ?>
                </select>
              </div>
            </div>
                <!--stat submit field  -->
            <div class="form-group ">
              
              <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Add Item" class="btn btn-primary btn-sm"/>
              </div>
            </div>
        </form>
       </div> 
    




    <?php

	

}elseif  ($do=='Insert'){


  if($_SERVER['REQUEST_METHOD']=='POST'){
      
      echo " <h1 class='text-center'> Insert Item </h1>";
      echo "<div class='container'>";
   // get variabable ffrom the form
   
    $name          =$_POST['name']; 
    $desc          =$_POST['desc'];
    $price         =$_POST['price']; 
    $country       =$_POST['country'];
    $status        =$_POST['status'];
    $member        = $_POST['member'];
    $category      = $_POST['category'];
    
   
   
   

     // validation the form

     $formEror=array();
     if(empty($name)){

       $formEror[]= 'name can/t be  <strong>empty</strong> ';
     }
     if(empty($desc)){

       $formEror[]= 'description can/t be  <strong>empty</strong> ';
     } 

     if(empty($price)){

      $formEror[]= 'price can/t be  <strong>empty</strong> ';
       }
      if(empty($country)){

      $formEror[]= 'country can/t be  <strong>empty</strong> ';
     }
     
     if($status==0){

      $formEror[]= 'you must chose the  <strong>status</strong> ';
     }
     if($member==0){

      $formEror[]= 'you must chose the  <strong>member</strong> ';
     }
     if($category==0){

      $formEror[]= 'you must chose the  <strong>category</strong> ';
     }
     

    

     foreach ($formEror as $error) {
       echo '<div class="alert alert-danger">' . $error . '</div>' ;
     }
     //if no error theack the pdate in data base
     if (empty($formEror)) {
      
     
    // insert  data base 
      $stmt=$con->prepare("INSERT INTO 

                              item(Name, Description, Price, Country, Status, Add_date, cat_id, user_id)

                              VALUES (:zname, :zdesc, :zprice, :zcountry ,:zstatus, now(), :zcat, :zmember)");
      $stmt->execute(array(
                             'zname'    => $name,
                             'zdesc'    => $desc,
                             'zprice'   => $price,
                             'zcountry' => $country,
                             'zstatus'  => $status,
                             'zcat'     => $category,                               
                             'zmember'  => $member


        ));
          
        //echo succes message
         $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'required inserted</div>';
          redirecthome ($theMsg , 'back');

  
      
      }

  }else{


    $theMsg= "you cant directory this page" ;
    redirecthome($theMsg);

  }
    echo "</div>";
    


  

}elseif  ($do=='update'){

   echo'welcome youare in add categorie page' ;

 }elseif  ($do=='Delete') {

 echo'welcome youare in add categorie page' ;

 }elseif  ($do=='approve') {

 echo'welcome youare in add categorie page' ;

 }  else {

echo'error page' ;
}
}


?>