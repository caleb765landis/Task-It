<?php

	if (!isset($_SESSION['username'])) Header ("Location:logout.php") ;

	//session time out 1 minutes after login. The timeout variable is set in the login page
	//keep refreshing the process.php page to see the behavior
	/*
	if(!isset($_SESSION['timeout']))  Header ("Location:logout.php") ;
  	else
		if ($_SESSION['timeout'] + 1 * 60 < time())
				 Header ("Location:logout.php") ;
		else {	$_SESSION['timeout'] = time();

		}
	*/

?>
