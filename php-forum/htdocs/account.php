<?php
include ('includes/header.html');
$page_title = 'Account Settings';

if (!isset($_COOKIE['user_name'])) {

	require ('includes/login_functions.inc.php');
	redirect_user('index.php');

}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$errors = array();
	
	if (empty($_POST['username'])) {
		$errors[] = 'Please confirm your username.';
	} else {
		$un = mysqli_real_escape_string($dbc, trim($_POST['username']));
	}
	
	if (!empty($_POST['password1'])) {
		if ($_POST['password1'] != $_POST['password2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		}
	} else {
		$errors[] = 'Please enter a password.';
	}
	
	if (empty($_POST['newpassword'])) {
		$errors[] = 'Please enter a new password.';
	} else {
		$np = mysqli_real_escape_string($dbc, trim($_POST['newpassword']));
	}
	
	if (empty($errors)) {
	
		$q = "SELECT username, pass FROM users WHERE username = '$un' 
		AND pass = SHA1('$p')";
		$r = mysqli_query($dbc, $q);
		
		if (mysqli_num_rows($r) == 1) {
		
			$q = "UPDATE users SET pass = SHA1('$np')
			      WHERE username = '$un'";
			$r = mysqli_query($dbc, $q);
			
			if (mysqli_affected_rows($dbc) == 1) {
				echo '<p class="center">Your password has been changed.</p>';
			} else {
				echo '<p class="center">Your password was not changed due to a system error.</p>';
			}
		
		} else {
			echo '<p class="center">The username and/or password you entered did not match. Please try again.</p>';
		}
	
	} else {
		echo '<h2 class="center">The following errors were detected:</h2><p class="error">';
		foreach($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo '</p><h2 class="center">Please try again.</h2>';
	}

}

?>

<div id="main">
<div id="form-box">
<h2>Account settings</h2>
	<p>Password Change</p>

<form action="account.php" method="post">

	<p>Username: <input type="text" size="20" maxlength="30" name="username" /></p>
	<p>Password: <input type="password" size="20" maxlength="30" name="password1" /></p>
	<p>Confirm Password: <input type="password" size="20" maxlength="30" name="password2" /></p>
	<p>New Password: <input type="password" size="20" maxlength="30" name="newpassword" /></p>
	<p><input type="submit" name="submit" value="Submit" /></p>

</form>
</div>
</div>

<?php include ('includes/footer.html'); ?>