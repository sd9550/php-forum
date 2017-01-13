<?php

require ('includes/login_functions.inc.php');

if (!isset($_COOKIE['user_name'])) {
	
	redirect_user('index.php');
	
} else {
	setcookie('user_name', '');
	setcookie('user_id', '');
	redirect_user('index.php');
}

$page_title = 'User Logout';
include ('includes/header.html');

// placeholder

?>

<div id="main">

</div>

<?php include ('includes/footer.html'); ?>