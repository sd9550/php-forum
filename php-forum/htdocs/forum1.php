<?php
$page_title = 'Main Programming Form';
include ('includes/header.html')
?>

<div id="main">

<?php

	if (isset($_COOKIE['user_name'])) {
		echo '<p class="center"><a href="newthread.php" class="new-thread">New Thread</a></p>';
	} else {
		echo '<p class="center">You must <a href="register.php" class="new-thread">register</a> to create threads</p>';
	}
	
	echo '<table id="thread-list">
		 <tr>
			<td class="header">Thread Name</td>
			<td class="header">Thread Creator</td>
			<td class="header">Date Created</td>
			<td class="header">Replies</td>
		</tr>';
	$q = "SELECT u.username, t.subject, t.thread_id, DATE_FORMAT(p.posted_on, '%b-%e-%y %1:%i %p') AS posted, count(post_id) - 1 AS responses
			FROM threads AS t
			INNER JOIN posts AS p 
			USING (thread_id)
			INNER JOIN users AS u ON
			t.user_id = u.user_id
			GROUP BY p.thread_id
		ORDER BY t.thread_id DESC";
	$r = mysqli_query($dbc, $q);
	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
		echo '<tr>
		<td><p><a href="thread.php?tid=' . $row['thread_id'] . '">' . $row['subject'] . '</a></p></td>
		<td><p>' . $row['username'] . '</p></td>
		<td><p>' . $row['posted'] . '</p></td>
		<td><p>' . $row['responses'] . '</p></td>
		</tr>';
	}
	echo '</table>';

?>

</div>

<?php include ('includes/footer.html'); ?>