<div class="promo-block">
	<div class="top">
            <?php if (group_has_role('invoices', 'create')) : ?>
		<ul class="btns-list">
			<li><a class="yellow-btn" href="<?php echo site_url('admin/invoices/create'); ?>"><span><?php echo lang('invoices:newinvoice') ?></span></a></li>
			<li><a class="yellow-btn" href="<?php echo site_url('admin/estimates/create_estimate'); ?>"><span><?php echo lang('estimates:createnew') ?></span></a></li>
		</ul><!-- /btns-list end -->
                <?php endif; ?>
		<br class="clear" />
		<h2 class="ttl ttl1"><?php echo random_element(lang('global:greetings')).' '.$current_user->first_name; ?></h2>
		
	</div><!-- /top end -->
	<?php if (group_has_role('invoices', 'view')) : ?>
	<ul class="counters">
		<li class="collect">
			<div class="head-box">
				<strong class="cell"><?php echo lang('dashboard:collected') ?>:</strong>
				<strong class="count"><span><?php echo anchor('admin/invoices/paid', $paid['count']); ?></span></strong>
			</div><!-- /head-box end -->
			<strong class="box"><?php echo anchor('admin/invoices/paid', Currency::format($paid['total'])); ?></strong>
		</li>
		<li class="outstanding">
			<div class="head-box">
				<strong class="cell"><?php echo lang('dashboard:outstanding') ?>:</strong>
				<strong class="count"><span><?php echo anchor('admin/invoices/unpaid', $unpaid['count']); ?></span></strong>
			</div><!-- /head-box end -->
			<strong class="box"><?php echo anchor('admin/invoices/unpaid', Currency::format($unpaid['total'])); ?></strong>
		</li>
	</ul><!-- /counters end -->
        <?php endif;?>
</div><!-- /promo-block end -->

<?php if ($thirty_days): ?>
	<div class="table-area thirty-days">
		<div class="head-box">
			<h3 class="ttl ttl2"><?php echo __('dashboard:latest_activity') ?></h3>
			<strong class="date"><?php echo date("l, F j, Y"); ?></strong>
		</div><!-- /head-box end -->
		<?php $this->load->view('reports/table', array('rows' => $thirty_days));?>
	</div>
<?php endif?>

    <?php if ($tasks !== false and count($tasks) and group_has_role('projects', 'view')): ?>
		<div class="table-area">
			<div class="head-box">
				<h3 class="ttl ttl2"><?php echo __('dashboard:upcoming_tasks') ?></h3>
			</div><!-- /head-box end -->
    <table id="paidRequestTable" class="listtable pc-table table-activity" cellspacing="0">
    	<thead>
    		<tr>
    		    <th class="cell1"><?php echo __('tasks:task') ?></th>
    		    <th class="cel12"><?php echo __('projects:project') ?></th>
    		    <th class="cel14"><?php echo __('milestones:milestone') ?></th>
    		    <th class="cel12"><?php echo __('tasks:hours') ?></th>
    		    <th class="cel13"><?php echo __('tasks:rate') ?></th>
    		    <th class="cel15"><?php echo __('global:is_completed') ?></th>
                <th class="cell6"><?php echo __('projects:due_date') ?></th>
    		</tr>
    	</thead>
    	<tbody>
		<?php if ( ! empty($tasks)): ?>
    	<?php foreach ($tasks as $task): ?>
    	<tr id="task-row-<?php echo $task['id']; ?>">
		   	<td class="cell1" <?php echo ((bool)$task['completed']) ? 'style="text-decoration:line-through"' : ''; ?>><span class="status-icon <?php echo ((bool)$task['completed']) ? 'green' : 'red'; ?>"><?php echo $task['name']; ?></span></td>
			<td class="cell2"><?php echo anchor('admin/projects/view/'.$task['project_id'], $task['project_name']) ?></td>
			<td class="cell3">
				<?php if ($task['milestone_id']): ?>
				<div class="milestone-icon" style="background-color: <?php echo $task['milestone_color'] ?>">
				</div>
				<?php echo anchor('admin/projects/milestones/view/'.$task['milestone_id'], $task['milestone_name']) ?>
				<?php else: ?>
				<em>n/a</em>
				<?php endif; ?>
			</td>
		   	<td class="cell4">
				<span class="hours"><?php echo $task['hours']; ?></span>
			</td>
			<td class="cell5"><?php echo ($task['rate']) ? Currency::format($task['rate']) : '<em>n/a</em>'; ?></td>
			<td class="cell6"><?php echo ((bool)$task['completed']) ? 'Yes' : 'No'; ?></td>
			<td class="cell7"><?php echo ($task['due_date']) ? format_date($task['due_date']) : '<em>n/a</em>'; ?></td>
    	</tr>
    	<?php endforeach; ?>
		<?php endif; ?>
    	</tbody>
    </table>
</div>
<?php endif; ?>

<script type="text/javascript">
$(function() { 
	$(".sortable").sortable();
});
</script>