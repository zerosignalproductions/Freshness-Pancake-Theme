<div class="notification warning">
	<h2><?php echo __('projects:areyousuredeletetask'); ?></h2>

	<div id="form_container">
	<?php echo form_open('admin/projects/tasks/delete/'.$task_id, array('id' => 'create_form')); ?>
		<input type="hidden" name="id" value="<?php echo $task_id; ?>" />

		<p class="confirm-btn"><a href="#" class="yellow-btn" onclick="$('#create_form').submit();"><span>&nbsp;&nbsp;<?php echo __('global:yesdelete') ?>&nbsp;&nbsp;</span></a></p>
	<?php echo form_close(); ?>
	</div>
</div>
<br style="clear: both;" />
<?php echo asset::js('jquery.ajaxform.js'); ?>
<script type="text/javascript">

	var task_id = <?php echo $task_id;?>;

	$('#create_form').ajaxForm({
		dataType: 'json',
		success: showResponse
	});
	
	function showResponse(data)  {
            $('#task-row-' + task_id).fadeOut(function()
            {
                $(this).remove();
            }); 
	    
	    $('#ajax_container').slideUp();
	}
</script>