<?php $action = isset($action) ? $action : 'create'; ?>
<div id="form_container">
    <div class="invoice-block">
        <div class="head-box">
            <h3 class="ttl ttl3"><?php echo __('milestones:' . ($action == 'create' ? 'add' : 'edit')) ?></h3>
        </div><!-- /head-box end -->
        <div class="form-holder">

            <?php echo form_open('admin/projects/milestones/' . $action . '/' . (isset($milestone) ? $milestone->id : $project->id), array('id' => $action . '_form')); ?>
            <fieldset>

                <div id="invoice-type-block" class="row">

                    <div class="row">
                        <label for="name"><?php echo __('global:name') ?></label>
                        <?php echo form_input('name', set_value('name', isset($milestone) ? $milestone->name : ''), 'class="txt"'); ?>
                    </div>
                    <div class="row">
                        <label for="description"><?php echo __('global:description') ?></label>
                        <?php echo form_textarea('description', set_value('description', isset($milestone) ? $milestone->description : '')); ?>
                    </div>
                    <div class="row">
                        <label for="target_date"><?php echo __('milestones:target_date') ?></label>
                        <?php echo form_input('target_date', set_value('target_date', isset($milestone) ? $milestone->target_date : '') ? format_date(set_value('due_date', isset($milestone) ? $milestone->target_date : '')) : '', 'id="target_date" class="datePicker txt"'); ?>
                    </div>
                    <div class="row">
                        <label for="color"><?php echo __('global:color') ?></label>
                        <?php echo form_input('color', set_value('color', isset($milestone) ? $milestone->color : ''), 'class="colorPicker txt"'); ?>
                    </div>
                    <div class="row">
                        <label for="assigned_user_id"><?php echo __('milestones:assigned_user') ?></label>
                        <div class="sel-item">
                            <?php echo form_dropdown('assigned_user_id', $users_select, set_value('assigned_user_id', isset($milestone) ? $milestone->assigned_user_id : ''), 'class="txt"'); ?>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="project_id" value="<?php echo $project->id; ?>" />
                        <a href="#" class="yellow-btn" onclick="$('#<?php echo $action; ?>_form').submit(); return false;"><span><?php echo __('milestones:' . ($action == 'create' ? 'add' : 'edit')) ?></span></a>
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