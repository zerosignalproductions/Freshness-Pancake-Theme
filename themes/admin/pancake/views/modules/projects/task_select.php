<?php
$task_id = (isset($task_id) and $task_id > 0) ? $task_id : '';
$not_uniform = isset($not_uniform) ? $not_uniform : '';
$not_uniform = $not_uniform ? 'not-uniform' : '';
$tasks = $this->project_task_m->get_task_select_array($project_id);
$show_optgroups = count($tasks['complete']) > 0 and count($tasks['incomplete']) > 0;
?>
<div class="sel-item">
    <select name="task_id" class="<?php echo $not_uniform;?>">
        <option value="" <?php echo ($task_id == 0) ? 'selected="selected"' : ''; ?>><?php echo __('tasks:not_related_to_a_task'); ?></option>
        <?php if ($show_optgroups): ?>
            <optgroup label="<?php echo __('global:incomplete_tasks'); ?>">
            <?php endif; ?>
            <?php foreach ($tasks['incomplete'] as $id => $name): ?>
                <option value="<?php echo $id; ?>" <?php echo $id == $task_id ? 'selected="selected"' : ''; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
            <?php if ($show_optgroups): ?>
            </optgroup>
        <?php endif; ?>
        <?php if ($show_optgroups): ?>
            <optgroup label="<?php echo __('global:completed_tasks'); ?>">
            <?php endif; ?>
            <?php foreach ($tasks['complete'] as $id => $name): ?>
                <option value="<?php echo $id; ?>" <?php echo $id == $task_id ? 'selected="selected"' : ''; ?>><?php echo $name; ?></option>
            <?php endforeach; ?>
            <?php if ($show_optgroups): ?>
            </optgroup>
        <?php endif; ?>
    </select>
</div>