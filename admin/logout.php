<?php

session_start();  //start the session 
session_unset();   //unset the sesstion
session_destroy();   //destroy th session  acctualisation 

header('location: index.php');