jQuery(document).ready(function($) {
	var vc_path, id, value;
	vc_path = video_checkmark_backend;

	$(".vc_checkbox").each(function() {
		$(this).on("click", function() {
			current_id = $(this).attr("name");
			current_value = $(this).attr("checked");	// Make sure don't replace it with val() since it will be checking whether or not the checkbox is checked. 
			$.post(vc_path, {id: current_id, value: current_value});
		});
	});
});