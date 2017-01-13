<?php
$page_title = 'User Login';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	require ('../mysqli_connect.php');
	require ('includes/login_functions.inc.php');
	
	if (isset($_POST['username'])) {
		$un = mysqli_real_escape_string($dbc, trim($_POST['username']));
	} else {
		$errors[] = 'Please enter your username.';
	}
	
	if (isset($_POST['password'])) {
		$p = mysqli_real_escape_string($dbc, trim($_POST['password']));
	} else {
		$errors[] = 'Please enter your password';
	}
	
	if (empty($errors)) {
	
		$q = "SELECT username, pass FROM users WHERE username = '$un' AND pass = SHA1('$p')";
		$r = mysqli_query($dbc, $q);
		
		if (mysqli_num_rows($r) == 1) {
		
			setcookie('user_name', $un);
			$q = "SELECT user_id FROM users WHERE username = '$un'";
			$r = mysqli_query($dbc, $q);
			$row = MYSQLI_FETCH_ROW($r);
			$id = $row[0];
			setcookie('user_id', $id);
			//echo '<h2 class="center">Hello ' . $un . '. You are now logged in.</h2>';
			redirect_user('index.php');
			
		} else {
			echo '<h2 class="center">Error. Incorrect username or password. Please try again.</h2>';
		}
	
	} else { // Errors found
		echo '<h2 class="center">The following errrors were detected:</h2><p class="error">';
		foreach($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo '</p><h2 class="center">Please try again.</h2>';
	}

}

// placeholder

?>

<div id="main">

<div id="form-box">
	<h1 class="center">User Login</h1>
	<form action="login.php" method="post">
	
		<p>Username: <input type="text" name="username" size="20" maxlength="30" /></p>
		<p>Password: <input type="password" name="password" size="20" maxlength="30" /></p>
		<p><input type="submit" name="submit" value="Submit" /></p>
	
	</form></div>

</div>

<?php include('includes/footer.html'); ?>