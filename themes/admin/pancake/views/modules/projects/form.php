<div id="form_container">
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl3"><?php echo lang('projects.'.$action.'.title'); ?></h3>
	</div><!-- /head-box end -->
	<div class="form-holder">

<?php echo form_open('admin/projects/'.$action, array('id' => 'create_form')); ?>
<fieldset>

	<div id="invoice-type-block" class="row">
		
		<div class="row">
			<label for="name"><?php echo lang('projects.label.name'); ?></label>
			<?php echo form_input('name', set_value('name', isset($project) ? $project->name : ''), 'class="txt"'); ?>
		</div>
		<div class="row">
			<label for="client_id"><?php echo lang('projects.label.client'); ?></label>
			<div class="sel-item">
			<?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', isset($project) ? $project->client_id : 0)); ?>
			</div>
			<?php echo anchor('admin/clients/create', '<span>Add a Client</span>', 'class="yellow-btn"'); ?>
		</div>
		
		<div class="row">
			<label for="due_date">Currency</label>

			<?php if ($action == 'create'): ?>

				<div class="sel-item">
					<?php echo form_dropdown('currency', $currencies, set_value('currency',  isset($project) ? $project->currency_code : ''), 'id="currency"'); ?>
				</div>
			
			<?php else: ?>
				<?php echo $project->currency_code ? $project->currency_code : Currency::code(); ?>
			<?php endif; ?>
			
		</div>

		<div class="row">
			<label for="rate"><?php echo lang('projects.label.rate'); ?></label>
			<?php echo form_input('rate', set_value('rate', isset($project) ? $project->rate : '0.00'), 'id="rate" class="txt"'); ?>
		</div>
		<div class="row">
			<label for="due_date"><?php echo lang('projects.label.due_date'); ?></label>
			<?php echo form_input('due_date', format_date(set_value('due_date', isset($project) ? $project->due_date : time())), 'id="due_date" class="datePicker txt"'); ?>
		</div>
		<div class="row">
			<label for="description"><?php echo lang('projects.label.description'); ?></label>
			<?php echo form_textarea(array(
				'name' => 'description',
				'id' => 'description',
				'value' => set_value('description', isset($project) ? $project->description : ''),
				'rows' => 4,
				'cols' => 50
			)); ?>
		</div>
		<div class="row">
			<label for="is_viewable"><?php echo lang('projects.label.is_viewable'); ?></label>
			<?php echo form_checkbox(array(
				'name' => 'is_viewable',
				'name' => 'is_viewable',
				'value' => 1,
				'checked' => (isset($project) ? ($project->is_viewable == 1) : TRUE)
			)); ?>
		</div>
		<br />
            <?php if (isset($project)): ?>
            <input type="hidden" name="id" value="<?php echo $project->id; ?>" />
            <?php endif; ?>
			<a href="#" class="yellow-btn" onclick="return $('#create_form').submit();"><span><?php echo lang('projects.button.'.$action); ?></span></a>
	</div>
</fieldset>
</form>
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
			return false;
		}
		else
		{
			$('#form_container').html('<div class="notification success">'+data.success+'</div>');
			
			if ($('#project_container').length)
			{
				$.get('<?php echo site_url('admin/projects'); ?>', function (data) {
					$('#project_container').html(data);
				});
				setTimeout("$('#form_container').hide()", 2000);
			}
			else
			{
				setTimeout("window.location.reload()", 2000);
			}
		}
	}
</script>
