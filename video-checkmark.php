<?php
/*
Plugin Name: Video Checkmark
Plugin URI: http://blog.robbychen.com
Description: Adds a new "Video" column to the posts table for easier track which posts contain video
Author: Robby Chen
Author URI: http://blog.robbychen.com
Version: 1.0
*/

require_once "inc/sqlite.class.php";

class video_checkmark {

	var $vc_data;

	function __construct() {
		$this->vc_data = new video_checkmark_sqlite("video_checkmark");
		add_filter('manage_post_posts_columns', array($this, "add_video_column"));
		add_action('manage_posts_custom_column', array($this, 'video_column_content'), 10, 2);

		add_action("admin_enqueue_scripts", array($this, "vc_scripts"));
		add_action("admin_head", array($this, "js_variables"));
 	}

 	function add_video_column($columns) {
    $columns['vc_video'] = 'Video';
    return $columns;
 	}

 	function vc_scripts() {
 		if (!strstr($_SERVER['REQUEST_URI'], "edit.php")):
 			return false;
 		endif;

		$scripts = array("vc_style"=>"css/main.css", "vc_script"=>"js/main-min.js");
 		foreach ($scripts as $name=>$file):
 			if (strstr($file, "css")):
 				wp_enqueue_style($name, plugin_dir_url(__FILE__) . $file);
 			else:
 				wp_enqueue_script($name, plugin_dir_url(__FILE__) . $file, array("jquery"));
 			endif;
 		endforeach;
 	}

 	function js_variables() {
 		if (!strstr($_SERVER['REQUEST_URI'], "edit.php")):
 			return false;
 		endif;
 	?>
		<script>
			var video_checkmark_backend = "<?php echo plugin_dir_url(__FILE__) . 'inc/vc-backend.php';?>";
		</script>
 	<?php
 	}
 
	function video_column_content($column_name, $id) {
		if ($column_name == "vc_video"):
			$checked = ($this->vc_data->get_option("vc_" . $id) == "checked") ? "checked" : "";
?>
			<input type='checkbox' class='vc_checkbox' name="vc_<?php echo $id; ?>" <?php echo $checked; ?> />
<?php
		endif;
	}
}

$video_checkmark = new video_checkmark();

?>