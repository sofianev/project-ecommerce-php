<?php

/*-------------
------------------------
---------categores page------
*********************
*/
 
ob_start();



session_start();

 $pageTitle='categores';


if (isset($_SESSION['Username'])) {
 
   include 'init.php';


	$do= isset($_GET['do']) ? $_GET['do'] : 'manage'  ; 

  if($do=='manage'){  

    $sort = 'ASC';

    $sort_array = array('ASC', 'DESC');

    if (isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

      $sort = $_GET['sort'];

    }


       $stmt2=$con->prepare("SELECT * FROM categores ORDER BY ordering $sort");

       $stmt2->execute();

       $cats=$stmt2->fetchAll(); ?>

       <h1 class="text-center">manage categores </h1>
         <div class="container categories">
           <div class="panel panel-default">
             <div class="panel-heading">
              <i class="fa fa-edit"></i> manage categores
              <div class="option pull-right">
               <i class="fa fa-sort"></i> ordering [
                <a class="<?php if ($sort =='ASC'){echo 'active';}?>" href="?sort=ASC">Asc</a>
                <a class="<?php if ($sort =='DESC'){echo 'active';}?>" href="?sort=DESC">Desc</a>]
                <i class="fa fa-eye"></i> view [
                <span class='active'>full</span>
                 <span>classic</span>]
               </div>
              
             </div>
              <di class="panel-body">
              <?php
              foreach ($cats as $cat ) {
                echo "<div class='cat'>";
                echo "<div class='hidden-buttons'>";
                echo "<a href='categores.php?do=Edit&catid=" .$cat['ID_cat'] ."' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                echo "<a href='categores.php?do=Delete&catid=" .$cat['ID_cat'] ."' class='confirm btn btn-xs btn-danger'><i class='fa fa-close'></i>Delete</a>";
                echo "</div>";

                echo  "<h3>" . $cat['Name'] . "</h3>";
                echo "<div class='full-view'>";
                 echo "<p>"; if ($cat['Description']==''){echo 'this cateores has no description';}else{ echo $cat['Description'] ;} echo "<p>" ;
                 
                   if($cat['Visibality']==1){ echo '<span class="visibilty"><i class="fa fa-eye"></i> hidden</span>' ;}
                    if($cat['Allow_comment']==1){ echo '<span class="commenting"><i class="fa fa-close"></i> Comment Disible</span>' ;} 
                     if($cat['Allow_ads']==1){ echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disible</span>' ;} 

                     echo "</dv>";
                     echo "</dv>";
                     echo "<hr>";
              }
              ?>
              </div>
               </div>
               <a class="btn btn-primary" href="categores.php?do=Add"><i class="fa fa-plus"></i> Add New Categories </a>
                </div>
                <?php


  }elseif($do=='Insert'){

     if($_SERVER['REQUEST_METHOD']=='POST'){
      
      echo " <h1 class='text-center'> Insert categores </h1>";
      echo "<div class='container'>";
   // get variabable ffrom the form
   
    $name         =$_POST['name']; 
    $desc         =$_POST['description'];
    $order        =$_POST['ordering']; 
    $visible      =$_POST['visible'];
    $comment      =$_POST['commenting']; 
    $ads          =$_POST['ads']; 
   

 

    
     
      //cheak if user exist in data base 

          $cheak=cheakitem("Name","categores",$name);
          if($cheak==1){

            $theMsg = "<div class='alert alert-danger'>sorry this categores is exist </div>";
             redirecthome ($theMsg , 'back');



     }else{
       
     
    // insert  data base 
      $stmt=$con->prepare("INSERT INTO categores 

      	                               (Name, Description, Ordering, Visibality,Allow_comment,Allow_ads) 

      	                                VALUES (:zname, :zdesc, :zorder, :zvisible , :zcomment , :zads )");
      $stmt->execute(array(
                             'zname'     =>$name,
                             'zdesc'     =>$desc,
                             'zorder'    =>$order ,
                             'zvisible'  =>$visible ,
                             'zcomment'  =>$comment ,
                             'zads'      =>$ads 
                            


        ));
          
        //echo succes message
         $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'required inserted</div>';
          redirecthome ($theMsg , 'back');

      }
      
     

  }else{


    $theMsg= "you cant directory this page" ;
    redirecthome($theMsg , 'back');

  }
    echo "</div>";
    

   }elseif($do=='Add'){ ?>
     
     <h1 class="text-center">Add New categores </h1>

       <div class="container">

        <!--  yadkhl hna  && send  to the page update with method post -->

          <form class="form-horizontal" action="?do=Insert" method="POST">
      
            <!--stat name field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="name"   class="form-control" autocomplete="off" required="required" placeholder="name is the best"/>
              </div>
            </div>

          <!--stat description field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10 col-md-6">
                
                <input type="text" name="description" class="form-control"   placeholder="add descrip categores" />
                 
              </div>
            </div>

            <!--stat orederig field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Orederig</label>
              <div class="col-sm-10 col-md-6">
                
                <input type="text" name="ordering" class="form-control"   placeholder="number to advange categores" />
                 
              </div>
            </div>

            <!--stat visiillty field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Visible</label>
              <div class="col-sm-10 col-md-6">
              	<div>
              	 <input id="vis-yes" type="radio" name="visible" value="0" checked />
              	 <label for="vis-yes">yes</label>
              	</div>
              	<div>
              	 <input id="vis-no" type="radio" name="visible" value="1" />
              	 <label for="vis-no">no</label>
              	</div>
               

              </div>
            </div>
            <!--stat commenting field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Allow Commenting</label>
              <div class="col-sm-10 col-md-6">
              	<div>
              	 <input id="com-yes" type="radio" name="commenting" value="0" checked />
              	 <label for="com-yes">yes</label>
              	</div>
              	<div>
              	 <input id="com-no" type="radio" name="commenting" value="1" />
              	 <label for="com-no">no</label>
              	</div>
               

              </div>
            </div>

            <!--stat ads field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Ads</label>
              <div class="col-sm-10 col-md-6">
              	<div>
              	 <input id="ads-yes" type="radio" name="ads" value="0" checked />
              	 <label for="ads-yes">yes</label>
              	</div>
              	<div>
              	 <input id="ads-no" type="radio" name="ads" value="1" />
              	 <label for="ads-no">no</label>
              	</div>
               

              </div>
            </div>
            <!--stat submit field  -->
            <div class="form-group ">
              
              <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Add categores" class="btn btn-primary btn-lg"/>
              </div>
            </div>
        </form>
       </div> 
    




    <?php
   }elseif($do=='Edit'){

    // chak if get request  userID s numerc && get the iteger value of it

    $catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;

       //select all data depend o this ID 

     
       $stmt = $con->prepare(" SELECT *  FROM  categores WHERE  ID_cat = ? ");

       //excute data 
    $stmt->execute(array($catid));

      // fetch data  #jib nformation 
    $cat = $stmt->fetch();

     // the row cont
    $count = $stmt->rowCount();

     // if there's ID show the form

     if ( $count > 0){     ?>

     <h1 class="text-center">Edit  Categores </h1>

       <div class="container">

        <!--  yadkhl hna  && send  to the page update with method post -->

          <form class="form-horizontal" action="?do=Update" method="POST">
             <input type="hidden" name="catid" value="<?php echo $catid ?>"/>
      
            <!--stat name field -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Name</label>
              <div class="col-sm-10 col-md-6">
                <input type="text" name="name"   class="form-control"   placeholder="name is the best" value="<?php echo $cat['Name'] ?>" />
              </div>
            </div>

          <!--stat description field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Description</label>
              <div class="col-sm-10 col-md-6">
                
                <input type="text" name="description" class="form-control"   placeholder="add descrip categores" value="<?php echo $cat['Description'] ?>" />
                 
              </div>
            </div>

            <!--stat orederig field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Orederig</label>
              <div class="col-sm-10 col-md-6">
                
                <input type="text" name="ordering" class="form-control"   placeholder="number to advange categores" value="<?php echo $cat['Ordering'] ?>" />
                 
              </div>
            </div>

            <!--stat visiillty field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Visible</label>
              <div class="col-sm-10 col-md-6">
                <div>
                 <input id="vis-yes" type="radio" name="visible" value="0" 
                 <?php if ($cat['Visibality'] == 0){ echo 'checked';} ?> />

                 <label for="vis-yes">yes</label>
                </div>
                <div>
                 <input id="vis-no" type="radio" name="visible" value="1"
                  <?php if ($cat['Visibality'] == 1){ echo'checked';} ?> />
                 <label for="vis-no">no</label>
                </div>
               

              </div>
            </div>
            <!--stat commenting field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Allow Commenting</label>
              <div class="col-sm-10 col-md-6">
                <div>
                 <input id="com-yes" type="radio" name="commenting" value="0" 
                  <?php if ($cat['Allow_comment'] == 0){ echo'checked';} ?> />

                 <label for="com-yes">yes</label>
                </div>
                <div>
                 <input id="com-no" type="radio" name="commenting" value="1" 
                  <?php if ($cat['Allow_comment'] == 1){ echo'checked';} ?> />

                 <label for="com-no">no</label>
                </div>
               

              </div>
            </div>

            <!--stat ads field  -->
            <div class="form-group form-group-lg">
              <label class="col-sm-2 control-label">Ads</label>
              <div class="col-sm-10 col-md-6">
                <div>
                 <input id="ads-yes" type="radio" name="ads" value="0"
                   <?php if ($cat['Allow_ads']==0){echo'checked';} ?>/>

                 <label for="ads-yes">yes</label>
                </div>
                <div>
                 <input id="ads-no" type="radio" name="ads" value="1" 
                  <?php if ($cat['Allow_ads']==1){echo'checked';} ?> />
                 <label for="ads-no">no</label>
                </div>
               

              </div>
            </div>
            <!--stat submit field  -->
            <div class="form-group ">
              
              <div class="col-sm-offset-2 col-sm-10 ">
                <input type="submit" value="Save Categores" class="btn btn-primary btn-lg"/>
              </div>
            </div>
        </form>


       



 <?php
 // else show error message if there'sno id exist
    } else{
      echo "<div class='container'>";
      $theMsg= '<div class="alert alert-danger">thee is no id </div> ';
       redirecthome ($theMsg );
       echo "</div>";

    }

   

    }elseif($do=='Update'){

      echo " <h1 class='text-center'> Update Categores </h1>";
       echo "<div class='container'>";

      if($_SERVER['REQUEST_METHOD']=='POST'){

   // get variabable ffrom the form
    $id          =$_POST['catid'];
    $name        =$_POST['name'];
    $desc        =$_POST['description']; 
    $order       =$_POST['ordering']; 
    $visible     =$_POST['visible']; 
    $comment     =$_POST['commenting'];
    $ads         =$_POST['ads'];

    

     
     //if no error theack the pdate in data base
     if (empty($formEror)) {
    // update data base 
        $stmt = $con->prepare(" UPDATE categores
                                       SET 
                                       Name= ?,  Description= ?,   Ordering= ? ,Visibality= ? ,
                                        Allow_comment= ? , Allow_ads= ?
                                         WHERE ID_cat=? ");


        $stmt->execute(array($name ,$desc , $order , $visible, $comment, $ads, $id));
        //echo succes message
         $theMsg= "<div class='alert alert-success'>" . $stmt->rowCount() . 'required update</div>';
          redirecthome ($theMsg );

     }
      
      

  }else{


    $theMsg = "<div class='alert alert-danger'>you cant directory his page </div>" ;
    redirecthome ($theMsg );
    echo "</div>";
  }


     }elseif($do=='Delete'){	

      $catid= isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) :  0;

       //select all data depend o this ID 

     
       //$stmt = $con->prepare(" SELECT *  FROM  users WHERE  ID = ? LIMIT 1");

        $cheak=cheakitem('ID_cat', 'categores', $catid);

      

     // if there's ID show the form

     if ( $cheak > 0){     
      $stmt=$con->prepare("DELETE FROM categores WHERE  ID_cat=:zid");
      $stmt->bindParam(":zid", $catid);
      $stmt->execute();

       $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . 'required DELETE</div>';
       redirecthome ($theMsg ,'back' );

  }else {echo"this id not exist";}

     }


     include $tpl .'footer.php';
} else {
	header('location: index.php');
	exit();
}


  ob_end_flush();	
  ?>