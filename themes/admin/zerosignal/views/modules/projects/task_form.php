<div id="form_container">
	<div class="invoice-block">
		<div class="head-box">
			<h3 class="ttl ttl3"><?php echo __('tasks:'.$action) ?></h3>
		</div><!-- /head-box end -->
		<div class="form-holder">

			<?php echo form_open('admin/projects/tasks/'.($action == 'create' ? 'create/'.$project->id : 'edit/'.$task->id), array('id' => $action.'_form')); ?>
			<fieldset>

				<div id="invoice-type-block" class="row">

					<div class="row">
						<label for="name"><?php echo __('global:name') ?></label>
						<?php echo form_input('name', set_value('name'), 'class="txt"'); ?>
					</div>
					<div class="row">
						<label for="rate"><?php echo __('tasks:rate') ?> (<?php echo $project->currency_code ? $project->currency_code : Currency::symbol(); ?>)</label>
						<?php echo form_input('rate', set_value('rate', isset($project) ? $project->rate : ''), 'class="txt"'); ?>
					</div>
					<div class="row">
						<label for="due_date"><?php echo __('projects:due_date') ?></label>
						<?php echo form_input('due_date', set_value('due_date') ? format_date(set_value('due_date')) : '', 'id="due_date" class="datePicker txt"'); ?>
					</div>
					
					<?php if ( ! empty($milestone_id)): ?>
						<?php echo form_hidden('milestone_id', $milestone_id) ?>
					<?php else: ?>
					<div class="row">
						<label for="milestone_id"><?php echo __('milestones:milestone') ?></label>
						<div class="sel-item">
						<?php echo form_dropdown('milestone_id', $milestones_select, set_value('milestone_id')); ?>
						</div>
					</div>
					<?php endif; ?>
					
					<div class="row">
						<label for="notes"><?php echo __('global:notes') ?></label>
						<?php echo form_textarea('notes', set_value('notes'), 'id="notes" class="txt"'); ?>
					</div>
					<div class="row">
						<label for="is_viewable"><?php echo __('tasks:is_viewable'); ?></label>
						<?php echo form_checkbox(array(
							'name' => 'is_viewable',
							'name' => 'is_viewable',
							'value' => 1,
							'checked' => (isset($task) ? ($task->is_viewable == 1) : TRUE)
						)); ?>
					</div>
					<div class="row">
						<input type="hidden" name="project_id" value="<?php echo $project->id; ?>" />
						<a href="#" class="yellow-btn" onclick="$('#<?php echo $action ?>_form').submit(); return false;">
							<span><?php echo __('tasks:'.$action) ?></span>
						</a>
					</div>
				</div>
			</fieldset>
            <input type="submit" class="hidden-submit" />
			<?php echo form_close(); ?>
			
		</div>
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

	    if (typeof(data.error) != 'undefined')
		{
			$('#form_container').before('<div class="notification error">'+data.error+'</div>');
		}
		else
		{
			$('#form_container').html('<div class="notification success">'+data.success+'</div>');
			setTimeout("window.location.reload()", 2000);
		}
	}
</script>