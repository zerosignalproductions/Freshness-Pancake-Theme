<div id="form_container">
	<div class="invoice-block">
		<div class="head-box">
			<h3 class="ttl ttl3"><?php echo lang('times.create.title'); ?></h3>
		</div><!-- /head-box end -->
		<div class="form-holder">

			<?php echo form_open('admin/projects/times/create/' . $project->id, array('id' => 'add_time')); ?>
			<fieldset>

				<div id="invoice-type-block" class="row add-time">

					<div class="row">
						<label for="start_time"><?php echo lang('times.label.start_time'); ?></label>
						<?php echo form_input('start_time', set_value('start_time', isset($time) ? $time->start_time : ''), 'id="start_time" class="txt"'); ?>
						<span class="time"></span>
					</div>
					<div class="row">
						<label for="end_time"><?php echo lang('times.label.end_time'); ?></label>
						<?php echo form_input('end_time', set_value('end_time', isset($time) ? $time->end_time : date('H:i')), 'id="end_time" class="txt"'); ?>
						<span class="time"></span>
					</div>
					<div class="row">
						<label for="date"><?php echo lang('times.label.date'); ?></label>
						<?php echo form_input('date', ($date = set_value('date', isset($time) ? $time->date : time())) ? format_date($date) : '', 'id="date" class="datePicker txt"'); ?>
					</div>
					<div class="row">
						<label for="task_id"><?php echo lang('times.label.task_id'); ?></label>

                                                <?php $this->load->view('projects/task_select', array(
                                                    'project_id' => $project->id,
                                                    'task_id' => isset($time) ? $time->task_id : 0
                                                )); ?>
                                                
					</div>
					<div class="row">
						<label for="note"><?php echo lang('times.label.notes'); ?></label>
						<?php echo form_textarea('note', set_value('note'), 'class="txt add-time-note"'); ?>
					</div>
					<div class="row">
						<input type="hidden" name="project_id" value="<?php echo $project->id; ?>" />
						<a href="#" class="yellow-btn" onclick="$('#add_time').submit(); return false;"><span><?php echo lang('times.create.title'); ?></span></a>
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
	$('#add_time').submit(function() {
	    if ($('#add_time .undefined').length > 0) {
			$('#add_time .undefined').siblings('input').focus();
			return false;
	    } else {
		    var startTime = $('#start_time').val();
		    if(!isNaN(startTime)) startTime += ':00';
			$('#start_time').val(Date.parse(startTime).toString('HH:mm'));

			var endTime = $('#end_time').val();
		    if(!isNaN(endTime)) endTime += ':00';
			$('#end_time').val(Date.parse(endTime).toString('HH:mm'));

			$(this).ajaxSubmit({
			    dataType: 'json',
			    success: function (data) {
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
			});
			return false;
	    }
	});
	
	$('#start_time, #end_time').each(function () {
	    
	    var val = $(this).val();
	    if (!isNaN(val))
		// add minutes to numeric value otherwise it will be interpreted as a date
		val = val + ':00'; 
	    var dt = Date.parse(val);
	    if (dt !== null) { 
		$(this).siblings('.time').removeClass('undefined');
	    } else {
		$(this).siblings('.time').addClass('undefined');
	    }
	    dt = (dt !== null) ? dt.toString('hh:mm tt') : 'not a valid time';
	    $(this).siblings('.time').html(dt);
	});
	
	$('#start_time, #end_time').keyup(function (e) {
	    var val = $(this).val();
	    if (!isNaN(val))
		// add minutes to numeric value otherwise it will be interpreted as a date
		val = val + ':00'; 
	    var dt = Date.parse(val);
	    if (dt !== null) { 
		$(this).siblings('.time').removeClass('undefined');
	    } else {
		$(this).siblings('.time').addClass('undefined');
	    }
	    dt = (dt !== null) ? dt.toString('hh:mm tt') : 'not a valid time';
	    $(this).siblings('.time').html(dt);
	});
	
</script>
