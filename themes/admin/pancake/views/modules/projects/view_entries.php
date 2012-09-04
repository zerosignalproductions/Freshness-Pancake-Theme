<div class="height_transition">
    <h2 class="ttl ttl3"><?php echo __('tasks:entries') ?></h2>
    <div style="clear:both;"></div>
    <div class="view_entries_table">
        <table id="view-entries" class="listtable pc-table table-activity" style="margin: 10px 0 0 0">
            <thead>
            <th class="cell1"><?php echo __('timesheet:date') ?></th>
            <th class="cell2"><?php echo __('timesheet:starttime') ?></th>
            <th class="cell3"><?php echo __('timesheet:endtime') ?></th>
            <th class="cell4"><?php echo __('timesheet:duration') ?></th>
            <th class="cell5"><?php echo __('global:actions') ?></th>
            </thead>

            <tbody>
                <?php foreach ($entries as $entry): ?>
                    <tr data-id="<?php echo $entry->id ?>">
                        <td class="cell1 date">
                            <span><?php echo format_date($entry->date); ?></span>
                            <?php echo form_input('date', format_date($entry->date), 'id="date-' . $entry->id . '" class="datePicker txt" style="display:none; width:100px;"') ?>
                        </td>
                        <td class="cell2 start_time">
                            <span><?php echo $entry->start_time; ?></span>
                            <?php echo form_input('start_time', $entry->start_time, 'style="display:none; width:50px;"') ?>
                        </td>
                        <td class="cell3 end_time">
                            <span><?php echo $entry->end_time; ?></span>
                            <?php echo form_input('end_time', $entry->end_time, 'style="display:none; width:50px;"') ?>
                        </td>
                        <td class="cell4 duration"><?php echo format_seconds($entry->minutes * 60); ?></td>
                        <td>
                            <a href="#" class="edit-entry icon edit" onclick="start_edit_time(<?php echo $entry->id; ?>); return false;" title="Edit">Edit</a>
                            <a href="#" class="delete-entry icon delete" title="Delete">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div id="form_container" class='invoice-block'>
        <?php foreach ($entries as $time): ?>
            <div class="edit-entry edit-entry-<?php echo $time->id; ?>">
                <?php echo form_open('admin/projects/times/create/' . $time->id, array('class' => 'edit_time')); ?>
                <fieldset>

                    <div id="invoice-type-block" class="row add-time">

                        <div class="row">
                            <label for="start_time"><?php echo lang('times.label.start_time'); ?></label>
                            <?php echo form_input('start_time', set_value('start_time', isset($time) ? $time->start_time : ''), 'id="start_time" class="start_time_input txt"'); ?>
                            <span class="time"></span>
                        </div>
                        <div class="row">
                            <label for="end_time"><?php echo lang('times.label.end_time'); ?></label>
                            <?php echo form_input('end_time', set_value('end_time', isset($time) ? $time->end_time : date('H:i')), 'id="end_time" class="end_time_input txt"'); ?>
                            <span class="time"></span>
                        </div>
                        <div class="row">
                            <label for="date"><?php echo lang('times.label.date'); ?></label>
                            <?php echo form_input('date-' . $time->id, ($date = set_value('date-' . $time->id, isset($time) ? $time->date : time())) ? format_date($date) : '', 'id="date-' . $time->id . '" class="datePicker txt"'); ?>
                        </div>
                        <div class="row">
                            <label for="task_id"><?php echo lang('times.label.task_id'); ?></label>

                            <?php $this->load->view('projects/task_select', array(
                                                    'project_id' => $project_id,
                                                    'task_id' => isset($time) ? $time->task_id : 0
                                                )); ?>
                        </div>
                        <div class="row">
                            <label for="note"><?php echo lang('times.label.notes'); ?></label>
                            <?php echo form_textarea('note', set_value('note', (isset($time) ? $time->note : '')), 'class="txt add-time-note"'); ?>
                        </div>
                        <div class="row no-margin">
                            <input type="hidden" name="project_id" value="<?php echo $project_id; ?>" />
                            <a href="#" class="yellow-btn" onclick="submit_edit_time(<?php echo $time->id; ?>); return false;"><span><?php echo __('tasks:edit_entry'); ?></span></a>
                        </div>
                    </div>
                </fieldset>
                <input type="submit" class="hidden-submit" />
                <?php echo form_close(); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script>
    
    function start_edit_time(id) {
        $('.view_entries_table').fadeOut(function() {
            $('.edit-entry-'+id).show();
            $('#facebox .invoice-block').fadeIn();
        });
    }
        
    function submit_edit_time(id) {
        
        var visible = $('.edit-entry-'+id);
            
        if (visible.find('.undefined').length > 0) {
            visible.find('.undefined').siblings('input').focus();
            return false;
        } else {
            var startTime = visible.find('.start_time_input').val();
            if(!isNaN(startTime)) startTime += ':00';
            startTime = Date.parse(startTime).toString('HH:mm');

            var endTime = visible.find('.end_time_input').val();
            if(!isNaN(endTime)) endTime += ':00';
            endTime = (Date.parse(endTime).toString('HH:mm'));
        }
        
        var date = $('[name=date-'+id+']').val();
        var note = visible.find('[name=note]').val();
        var task_id = visible.find('[name=task_id]').val();
        $.post('<?php echo site_url('admin/projects/times/ajax_set_entry') ?>', {
                'id' : id,
                'start_time' : startTime,
                'end_time' : endTime,
                'date' : date,
                'note': note,
                'task_id': task_id
            });
        
        jQuery(document).trigger('close.facebox');
    }
    
    jQuery(function($) {
        
        $('.start_time_input, .end_time_input').each(function () {
	    
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
	
	$('.start_time_input, .end_time_input').keyup(function (e) {
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

        $('.start_time span, .end_time span, .date span').live('click', function() {		
            $(this).hide().siblings('input').show();
        });
	
        $('.start_time input, .end_time input, .date input').live('blur change', function(e) {
  
            var input = this;
            var row = $(this).closest('tr');

            $.post('<?php echo site_url('admin/projects/times/ajax_set_entry') ?>', {
                'id' : row.data('id'),
                'start_time' : $('.start_time input', row).val(),
                'end_time' : $('.end_time input', row).val(),
                'date' : $('.date input', row).datepicker( "getDate" ).getTime()
            }, function(data) {
			
                $(input).hide().siblings('span').text(input.value).show();

                $('.duration', row).text(data.new_duration);
			
            }, 'json');
	
        });
	
        $('.delete-entry').click(function() {
		
            var row = $(this).closest('tr');
            var id = row.data('id');
		
            $.post(baseURL +'admin/projects/times/ajax_delete_entry', {
                'id' : row.data('id'),
            }, function() {
                row.slideUp('slow');
            });
                
            return false;
        });
    })
</script>

<style>
    #facebox .content {width: 600px !important;padding:0 !important;}
    .height_transition {padding: 30px;}
    #view-entries {
        width: 540px;
    }
    
    #facebox .add-time-note {
width: 320px;
}
    
    #facebox #form_container label {
width: 6em !important;
}
    
    #facebox input {width: 150px;}

    .view_entries_table {text-align:center;}

    div.edit-entry {display:none;}

    #view-entries td, #view-entries th  {
        width: 17%;
        text-align: center;
    }

    #facebox .invoice-block {
        padding: 40px 40px 0px 40px !important;
    }
    
    #facebox .row.no-margin {margin:0 !important;}
    #facebox .invoice-block {display:none;}
    #facebox .content {padding: 30px;}
    #facebox .ttl {margin: 0 0 20px 0;}
</style>