<td class="cell1 task-name" <?php echo ((bool) $task['completed']) ? 'style="text-decoration:line-through"' : ''; ?>>
    <span class="status-icon <?php echo ((bool) $task['completed']) ? 'green' : 'red'; ?>">
        <?php if (!isset($task['not_a_task'])) : ?>
		<?php echo anchor('admin/projects/tasks/edit/'.$task['id'], $task['name']); ?>
        <?php else:?>
                <?php echo $task['name'];?>
        <?php endif;?>
	</span>
    <?php /* <a href="<?php echo site_url('admin/projects/view_times/'.$project->id.'/'.$task['id'])?>" class="task-expand" >View Time Entries</a> */ ?>
</td>
	
<?php if (isset($task['not_a_task'])) : ?>
<td class="cell1 not-a-task">
	<em>n/a</em>	
<?php else: ?>
		
		<?php if (group_has_role('projects', 'track_time')): ?>
<td class="cell1 timer-td">
	<div class="timer" data-task-id="<?php echo $task['id'];?>" data-project-id="<?php echo $project->id ?>" data-time-start="<?php echo $task['entry_started'] ? strtotime(date('Y-m-d', $task['entry_started_date']).' '.$task['entry_started_time']).'000' : '' ?>">
		<span class="timer-time">00:00:00</span>
		<span class="timer-button <?php echo $task['entry_started'] ? 'running' : '' ?>" data-start="<?php echo __('global:start') ?>" data-stop="<?php echo __('global:stop') ?>">
			
			<?php echo $task['entry_started'] ? __('global:stop') : __('global:start') ?>
		
		</span>
	</div>
		<?php endif ?>
	
<?php endif; ?>
</td>
<td class="cell1">
    <span class="tracked-hours" data-task-id="<?php echo $task['id'];?>"><?php echo $task['processed_tracked_hours'];?></span>
</td>

<td class="cell1"><?php echo ($task['rate']) ? Currency::format($task['rate']) : '<em>n/a</em>'; ?></td>
<?php if (isset($task['not_a_task'])) : ?>
    <td class="cell1 not-a-task"><em>n/a</em></td>
	<td class="cell1">
		<?php echo anchor('admin/projects/times/view_entries/project/'.$project->id, __('tasks:view_entries'), array('class' => 'modal')) ?>
	</td>
<?php else: ?>
    <td class="cell1 <?php echo ($task['due_date']) ? '' : 'not-a-task';?>"><?php echo ($task['due_date']) ? format_date($task['due_date']) : '<em>n/a</em>'; ?></td>
    <td class="cell1 actions-td">
        <?php echo anchor(Settings::get('kitchen_route').'/'.get_client_unique_id_by_id($project->client_id).'/comments/task/'.$task['id'], 'Comments ('.get_count('task_comments', $task['id']).')') ?> |
		<?php echo anchor('admin/projects/times/view_entries/task/'.$task['id'], __('tasks:view_entries'), array('class' => 'modal')) ?>
		<br />
                    <?php if (group_has_role('projects', 'delete_task')): ?>
		<?php echo anchor('admin/projects/tasks/get_delete_form/'.$task['id'], __('global:delete'), array('class' => 'remove fire-ajax')) ?>
	 |
		<?php endif ?>
		
		<?php if (group_has_role('projects', 'edit_task')): ?>
        <a href="#" class="add" onclick="Tasks.toggleStatus('<?php echo $task['id']; ?>');return false;"><?php echo (!(bool) $task['completed']) ? 'Complete' : 'Un-complete'; ?></a>
		<?php endif ?>
    </td>

<?php endif; ?>

<?php if ($task['notes']): ?>
	
</tr>
<tr>
	<td colspan="6" class="notes_row">
		<?php echo ($task['notes']) ?>
	</td>
<?php endif; ?>
