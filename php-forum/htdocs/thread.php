<?php
include ('includes/header.html');
$page_title = 'Forum Thread';
?>

<div id="main">
<div id="message-list">
<?php

// Thread ID
$tid = FALSE;
if (isset($_GET['tid']) && filter_var($_GET['tid'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {

	require ('../mysqli_connect.php');

	$tid = $_GET['tid'];
	
	$q = "SELECT t.subject, p.message, username, DATE_FORMAT(p.posted_on, '%b-%e-%y %1:%i %p') AS posted
		  FROM threads AS t
		  LEFT JOIN posts AS p 
		  USING (thread_id)
		  INNER JOIN users AS u ON
		  p.user_id = u.user_id
		  WHERE t.thread_id = $tid
		  ORDER BY p.posted_on ASC";
	$r = mysqli_query($dbc, $q);
	if (!(mysqli_num_rows($r) > 0)) {
		$tid = FALSE;
	}

}

if ($tid) {

	$printed = FALSE;
	
	echo '<table id="thread-message" border="1">';
	
	while ($messages = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
	
		if(!$printed) {
			echo "<tr><td class=\"header\" colspan=\"2\"><h2>{$messages['subject']}</h2>\n</td></tr>";
			$printed = TRUE;
		}
		
		echo "<tr><td width=\"20%\"><p><span class=\"blue\">{$messages['username']}</span><br />{$messages['posted']}<br /></p></td><td width=\"80%\"><p><br />{$messages['message']}</p><br />\n</td></tr>";
	
	}
	
	echo '</table><br />';
	
	include ('includes/post_form.php');

} else { // Invalid thread ID
	echo '<p>This page has been accessed in error!</p>';
}

// placeholder

?>
</div>
</div>

<?php include ('includes/footer.html'); ?>