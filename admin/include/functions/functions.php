<?php


//tite functions    gettitle 

  function getTtle(){

   global $pageTitle;
   if(isset($pageTitle)){


   	echo $pageTitle ;


   }else{

   	echo'default';
   }


  }
  /* v2
  redirect to home page after 3 seconds  
  $temsg  | eror|success|worning

  */
  function redirecthome( $theMsg, $url=null , $seconds=3){

    if($url==null){

        $url='index.php';

    }else{

      $url= isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' ? $url= $_SERVER['HTTP_REFERER'] : $url= 'index.php';
       $link='priveus page' ;
     
    }

  echo $theMsg;

  echo "<div class='alert alert-info'>you will direct in  $url after $seconds seconds</div>";
  header("refresh:$seconds ; url=$url");
  exit();
  }

  /* 
  ** ceak item fnction
  ** fnction to cheak item in data base
  **$seect= the item to select
  **$from=the table  to select
  **$value= the value of select
  */
  function cheakitem($select,$from,$value){

     global $con;

     $statment=$con->prepare("SELECT $select FROM $from WHERE $select=?");
     $statment->execute(array($value));
     $count=$statment->rowCount();
     return $count;

  }

  /*
  **count number of item function v1
  **function to count number of item row
  **item = item to count
  ** table = table to choose from
  */
  function countitem($item, $table){

    global $con;

    $stmt2=$con->prepare("SELECT COUNT($item) FROM $table");

    $stmt2->execute();

    return $stmt2->fetchColumn();

  }

  /*
 ** get latest record v1.0
 ** function to get latest item from data base (users , item , comment)
 **
 **
  */
  function getlatest($select, $table, $order, $limit=5){

    global $con ;

    $getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

    $getstmt->execute();
 
    $rows = $getstmt->fetchAll();

    return $rows ;

   
  }