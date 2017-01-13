<?php 
$page_title = 'Programming Forum - Main Page';
include('includes/header.html'); 
?>

<div id="main">

	<table id="forum-list">
		<tr>
			<td class="header">Forum Name</td>
			<td class="header">Last Topic Created</td>
			<td class="header">Date Created</td>
		</tr>
		<tr>
			<td><p><a href="forum1.php">Main Programming Forum</a></p></td>
			<?php
				$q = "SELECT t.subject, DATE_FORMAT(p.posted_on, '%b-%e-%y %1:%i %p') AS posted
					FROM threads AS t
					INNER JOIN posts AS p ON
					t.thread_id = p.thread_id
					ORDER BY t.thread_id DESC
					LIMIT 1;";
				$r = mysqli_query($dbc, $q);
				while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<td><p>' . $row['subject'] . '</p></td>
						<td><p>' . $row['posted'] . '</p></td>';
				}
			?>
		</tr>
		<tr>
			<td><p><a href="#">Placeholder</a></p></td>
		</tr>
		<tr>
			<td><p><a href="#">Placeholder</a></p></td>
		</tr>
		<tr>
			<td><p><a href="#">Placeholder</a></p></td>
		</tr>
	</table>

</div><!-- main ends here -->

<?php include('includes/footer.html'); ?>