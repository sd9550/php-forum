<?php

function redirect_user ($page = 'index.php') {

	$url = $page;
	
	// Redirect the user:
	header("Location: $url");
	exit(); // Quit the script

} // End of redirect_user() function

?>