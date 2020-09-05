<?php

function lang ($phrase){

static $lang =array (
 

           //NAVBAR LINK
	 'HOME_ADMIN' => 'Home ',
	 'Categories' => 'Categories',
	 'ITMES'      => 'Items',
	 'MEMBERS'    => 'members',
	 'STATISTICS' => 'statistics',
	 'LOGS'       => 'logs'


);



return $lang[$phrase];

}