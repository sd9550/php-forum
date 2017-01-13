<?php
$page_title = 'User Registration';
include('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('../mysqli_connect.php');
	
	$errors = array(); // Error array
	
	// Check for a username
	if (empty($_POST['username'])) {
		$errors[] = 'Please enter a valid username.';
	} else {
		$un = mysqli_real_escape_string($dbc, trim($_POST['username']));
	}
	
	// Check for an email
	if (empty($_POST['email'])) {
		$errors[] = 'Please enter a valid e-mail.';
	} else {
		$e = mysqli_real_escape_string($dbc, trim($_POST['email']));
	}
	
	// Check for a password and match the confirmed password
	if (!empty($_POST['password1'])) {
		if ($_POST['password1'] != $_POST['password2']) {
			$errors[] = 'Your password did not match the confirmed password.';
		} else {
			$p = mysqli_real_escape_string($dbc, trim($_POST['password1']));
		}
	} else {
		$errors[] = 'Please enter a password';
	}
	
	if (empty($errors)) { // No errors detected
	
		$q = "SELECT email, username FROM users WHERE email = '$e' OR username = '$un'";
		$r = @mysqli_query($dbc, $q);
		
		if (mysqli_num_rows($r) == 0) { // Valid username/email combo
		
			$q = "INSERT INTO users (username, pass, email) VALUES
		    ('$un', SHA1('$p'), '$e')";
			$r = @mysqli_query($dbc, $q);
			
			if ($r) {
				echo '<h2 class="center">You have been registered. Thank you!</h2>';
			} else {
				echo '<h2 class="center">You have not been registered due to a system error. Sorry.</h2>';
			}
		
		} else {
			echo '<p>Sorry, the username or email you entered is already registered.</p>';
		}
		
		//mysqli_close($dbc); // Close the database connection
		
		// Include the footer and quit the script:
		
		exit();
	
	} else {
		echo '<h2 class="center">The following errors occured:</h2><p class="error">';
		foreach($errors as $msg) {
			echo " - $msg<br />\n";
		}
		echo '</p><h2 class="center">Please try again.</h2>';
	}
	
	mysqli_close($dbc); // Close the database connection

}

// placeholder

?>

<div id="main">

<div id="form-box">
<h1 class="center">User Registration</h1>
<form action="register.php" method="post">

	<p>Username: <input type="text" name="username" size="20" maxlength="30" /></p>
	<p>E-mail: <input type="text" name="email" size="20" maxlength="30" /></p>
	<p>Password: <input type="password" name="password1" size="20" maxlength="30" /></p>
	<p>Confirm Password: <input type="password" name="password2" size="20" maxlength="30" /></p>
	<p><input type="submit" name="submit" value="Submit" /></p>

</form>
</div>

</div>

<?php include('includes/footer.html'); ?>