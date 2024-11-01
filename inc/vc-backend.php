<?php
	require_once "sqlite.class.php";
	$sqlite = new video_checkmark_sqlite("video_checkmark");
	if (!empty($_POST['id'])):
		foreach ($_POST as $name=>$value):
			$$name = $value;
		endforeach;
		$sqlite->update_option($id, $value);
	endif;
?>