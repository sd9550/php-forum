<?php
include ('includes/header.html');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	require ('includes/login_functions.inc.php');

	// Validate the hidden thread ID
	if (isset($_POST['tid']) && filter_var($_POST['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
		$tid = $_POST['tid'];
	} else {
		$tid = FALSE;
	}
	
	// Display subject if there is no thread ID
	if (!$tid && empty($_POST['subject'])) {
		$subject = FALSE;
		echo '<p class="center">Please enter a subject for this post.</p>';
	} elseif (!$tid && !empty($_POST['subject'])) {
		$subject = htmlspecialchars(strip_tags($_POST['subject']));
	} else { // No need for subject if thread ID found
		$subject = TRUE;
	}
	
	// Body validate
	if (!empty($_POST['body'])) {
		$body = htmlentities($_POST['body']);
	} else {
		$body = FALSE;
		echo '<p class="center">Please enter a body for this post.</p>';
	}
	
	if ($subject && $body) { // Valid
	
		// Add message to the database
		if (!$tid) { // Create a thread
			$q = "INSERT INTO threads (user_id, subject)
			      VALUES ({$_COOKIE['user_id']}, '" . mysqli_real_escape_string($dbc, $subject) . "')";
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				$tid = mysqli_insert_id($dbc);
			} else {
				echo '<p>Your post could not be handled due to a system error.</p>';
			}
		} // No $tid
		
		if ($tid) { // Add to replies
			$q = "INSERT INTO posts (thread_id, user_id, message, posted_on)
				  VALUES ($tid, {$_COOKIE['user_id']}, '" . mysqli_real_escape_string($dbc, $body) . "', UTC_TIMESTAMP())";
			$r = mysqli_query($dbc, $q);
			if (mysqli_affected_rows($dbc) == 1) {
				//echo '<p>Your post has been entered.</p>';
				if ($tid) {
					redirect_user('thread.php?tid=' . $tid . '');
				} elseif (!$tid) {
					redirect_user('forum1.php');
				}
			} else {
				echo '<p>Your post could not be handled due to a system error.</p>';
			}
		} // Valid $tid
	
	} else {
		include ('includes/post_form.php');
	}

} else { // Display the form
	include ('includes/post_form.php');
}

include ('includes/footer.html');

// placeholder
?>