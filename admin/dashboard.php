<?php

ob_start();  // output buffering start

session_start();

if (isset($_SESSION['Username'])) {

	$pageTitle='dashbourd';
	include 'init.php';

	//start dashboard page 
   $latestusers=5;  
   $thelatest=getlatest("*","users","ID",$latestusers);

     
	  ?>
	  <div class ="container home-stats text-center"> 
	    <h1> Dashboard </h1>
	    <div class="row">
	       <div class="col-md-3">
	       	<div class="stat st-members">
	       		Total members
	       		<span><a href='members.php'><?php echo countitem('ID', 'users') ?></a></span>
	       	 </div>
         </div>
	    <div class="col-md-3">
	       	<div class="stat st-pending">
	       		Pending members
	       		<span><a href='members.php?do=manage&&page=pendingss'>
	       		  <?php echo cheakitem("register","users",0) ?></a></span>
	       	 </div>
        </div>
	    <div class="col-md-3">
	       	<div class="stat st-items">
	       		Total Item
	       		<span><a href='item.php'><?php echo countitem('item_ID', 'item') ?></a></span></span>
	       	 </div> 
	    </div>

	    <div class="col-md-3">
	       	<div class="stat st-comments">
	       		Total comments
	       		<span>200</span>
	       	 </div>
	    </div>
      </div>
      </div>

      <div class="container latest">
      	<div class="row">
      		<div class="col-sm-6">
      			<div class="panel panel-default">
      				
      			<div class="panel-heading">

      				<i class="fa fa-users"></i>last <?php echo $latestusers ?> register user
      			</div>
      			<div class="panel-body"> 
              <ul class="list-unstyled latest-users">
      				 <?php
                   
                   foreach ($thelatest as $user ) {
                     
                     echo '<li>' . $user['username'] ;
                     echo '<a href="members.php?do=Edit&userID=' . $user['ID'] .'">' ;
                     echo '<span class="btn btn-success pull-right">';
                     echo '<i class="fa fa-edit"></i>Edit';
                     if($user['register']== 0){
                 echo" <a href='members.php?do=activate&userID=" . $user['ID'] ."' class='confirm btn btn-info pull-right'><i class='fa fa-activae'></i>activate</a>";
                }
                     echo'</span>';
                     echo'</a>' ;
                      echo'</li>';
                 
                   }
                  ?>
                </ul>
                </div>
      			</div>
      		</div>

      		<div class="col-sm-6">
      			<div class="panel panel-default">
      				
      			<div class="panel-heading">
      				<i class="fa fa-tag"></i>last register Items
      			</div>
      			<div class="panel-body"> 
                 
                </div>
      			</div>
      		</div>
        </div>
      </div>


     <?php
	//end dashboard page
	

// if (!isset($nonevbar)) {include $tpl . 'nevbar.php'; }
 include $tpl .'footer.php';
} else {
	header('location: index.php');
	exit();
}
ob_end_flush();
?>
