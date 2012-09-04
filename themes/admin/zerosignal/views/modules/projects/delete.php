<div class="notification warning">
	<h2><?php echo lang('projects.delete.title'); ?></h2>

	<div id="form_container">
		<?php echo form_open('admin/projects/delete/', array('id' => 'create_form')); ?>
			<input type="hidden" name="id" value="<?php echo $project->id; ?>" />
			
			<p class="confirm-btn"><a<a href="#" class="yellow-btn" onclick="$('#create_form').submit();"><span>&nbsp;&nbsp;<?php echo __('global:yesdelete') ?>&nbsp;&nbsp;</span></a></p>
		
		<?php echo form_close(); ?>
	</div>
</div>

<br style="clear: both;" />

<?php echo asset::js('jquery.ajaxform.js'); ?>

<script type="text/javascript">

	$('#create_form').ajaxForm({
		dataType: 'json',
		success: showResponse
	});
	
	function showResponse(data)  {
		$('.notification').remove();
		
	    if (typeof(data.error) != 'undefined') {
			$('#form_container').before('<div class="notification error">'+data.error+'</div>');
		}
		else
		{
            window.location.href = Pancake.site_url+'admin/projects';
		}
	}
</script>