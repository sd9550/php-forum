<?php
// Form for message posting
// It is also used for creating new threads

if (isset($_COOKIE['user_id'])) {

	echo '<div id="new-thread"><form action="post.php" method="post" accept-charset="utf-8">';
	
	if (isset($tid) && $tid) { // If on thread.php
	
		echo '<h3>Post a Reply</h3>';
		
		echo '<input name="tid" type="hidden" value="' . $tid . '" />';
	
	} else { // New thread
	
		echo '<h3>New Thread</h3>';
		
		echo '<p>Subject: <input type="text" name="subject" size="60" maxlength="100" ';
		if (isset($subject)) {
			echo "value=\"\" ";
		}
		
		echo '/></p>';
	
	}
	
	echo '<p>Body: <textarea name="body" rows="10" cols="60">';
	
	if (isset($body)) {
		echo $body;
	}
	
	echo '</textarea></p>';
	
	echo '<input type="submit" name="submit" value="Submit" />
		  </form>';

} else {
	echo '<br /><p class="center">You must be logged in to post messages.</p><br />';
}

echo '</div>';

?>