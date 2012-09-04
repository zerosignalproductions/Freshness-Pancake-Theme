<div class="invoice-block">

	<div class="head-box" style="margin:20px 0 20px 0">
	   <h3 class="ttl ttl3"><?php echo __('projects:project') ?>: <?php echo $project->name; ?> </h3>
		<p class="details">
			<?php echo __('global:client') ?>: <?php echo $project->first_name; ?> <?php echo $project->last_name; ?> - <?php echo $project->company; ?> | 
			<?php echo __('invoices:due') ?>: <?php echo format_date($project->due_date); ?> | 
			<?php echo __('tasks:default_rate') ?>: <?php echo Currency::format($project->rate, $project->currency_id); ?> | 
			<?php echo __('tasks:hours') ?>: <?php echo $totals['hours']; ?> | 
			<?php echo __('items:cost') ?>: <?php echo Currency::format($totals['cost'], $project->currency_id); ?> |
			<?php echo __('kitchen:comments') ?>: <?php echo anchor(Settings::get('kitchen_route').'/'.get_client_unique_id_by_id($project->client_id).'/comments/project/'.$project->id, 'Comments ('.get_count('project_comments', $project->id).')') ?>  
		</p>
    </div>

    <ul class="btns-list" style="float:left!important; padding-left:30px">
		
		<?php if (group_has_role('projects', 'add_milestone')): ?>
		<li><a href="<?php echo site_url('admin/projects/milestones/create/'.$project->id); ?>" class="yellow-btn fire-ajax"><span><?php echo __('milestones:add') ?></span></a></li>
		<?php endif ?>
		
		<?php if (group_has_role('projects', 'add_task')): ?>
		<li><a href="<?php echo site_url('admin/projects/tasks/create/'.$project->id); ?>" class="yellow-btn fire-ajax"><span><?php echo __('tasks:create') ?></span></a></li>
		<?php endif ?>
		
		<?php if (group_has_role('projects', 'track_time')): ?>
		<li><a href="<?php echo site_url('admin/projects/times/create/'.$project->id); ?>" class="yellow-btn fire-ajax"><span><?php echo __('projects:add_time') ?></span></a></li>
		<?php endif ?>
                
                <?php if (group_has_role('projects', 'track_time')): ?>
		<li><a href="#" class="yellow-btn" id="add_hours"><span><?php echo __('projects:add_hours') ?></span></a></li>
		<?php endif ?>
		
		<?php if (count($tasks)): ?>
			
			<?php if (group_has_role('invoices', 'create')): ?>
		<li><a href="<?php echo site_url('admin/invoices/create/'.$project->id); ?>" class="yellow-btn"><span><?php echo __('projects:generate_invoice') ?></span></a></li>
			<?php endif ?>
			
		<?php endif ?>
        
		<li><a href="<?php echo site_url('timesheet/'.$project->unique_id); ?>" class="yellow-btn"><span><?php echo __('timesheet:view_pdf') ?></span></a></li>
		
		<?php if (group_has_role('projects', 'edit')): ?>
		<li><a href="<?php echo site_url('admin/projects/edit/'.$project->id); ?>" class="yellow-btn fire-ajax"><span><?php echo __('global:edit') ?></span></a></li>
		
		<?php endif ?>
		
		<?php if (group_has_role('projects', 'create')): ?>
		<li><a href="<?php echo site_url('admin/projects/delete/'.$project->id); ?>" class="yellow-btn fire-ajax"><span><?php echo __('global:delete') ?></span></a></li>
		<?php endif ?>
    </ul><!-- /btns-list end -->

	<br style="clear: both;" />
	
    <div id="ajax_container"></div>
    
    <div id="add_hours_container">
        <div class="invoice-block" data-project-id="<?php echo $project->id;?>">
            <div class="row hours">
                <label><?php echo __('projects:hours_worked'); ?></label>
                <input type="text" name="hours" class="txt" />
            </div>
            <div class="row">
                <label><?php echo lang('timesheet:date'); ?></label>
                <?php echo form_input('add_hours_date', format_date(time()), 'class="txt"'); ?>
            </div>
            <div class="row">
                <label><?php echo __('global:task'); ?></label>
                <?php $this->load->view('projects/task_select', array(
                                                    'project_id' => $project->id,
                                                    'task_id' => 0,
                                                    'not_uniform' => true,
                                                )); ?>
            </div>
            <div class="row">
                <label><?php echo __('global:notes'); ?></label>
                <?php echo form_textarea('note', '', 'class="txt add-time-note"'); ?>
            </div>
            <div class="row"><label>&nbsp;</label><a href="#" class="submit_hours yellow-btn"><span>Save hours</span></a></div>
        </div>
    </div>

</div>


<?php if (count($linked_invoices)): ?>

<div class="table-area">
    						
	<div class="head-box" style="margin: 30px 0 0 0">
		<h4 class="ttl-small" style="margin-left:0px"><?php echo __('global:invoices') ?></h4>
	</div>
	
	<table id="linked-invoice-table" class="listtable pc-table" cellspacing="0">
    	<thead>
    		<tr>
    		    <th class="cell1"><?php echo Settings::get('default_invoice_title') ?></th>
				<th class="cel12"><?php echo __('global:description') ?></th>
				<th class="cel12"><?php echo __('invoices:amount') ?></th>
				<th class="cel12"><?php echo __('invoices:is_sent') ?></th>
    		    <th class="cel12"><?php echo __('invoices:is_paid') ?></th>
				<th class="cel12"><?php echo __('global:actions') ?></th>
    		</tr>
    	</thead>
    	<tbody>

		<?php foreach ($linked_invoices as $invoice): ?>
    	<tr>
			<td><?php echo anchor($invoice->unique_id, '#'.$invoice->invoice_number) ?></td>
			<td><?php echo word_limiter($invoice->description, 30) ?></td>
			<td><?php echo Currency::format($invoice->amount, $invoice->currency_code) ?></td>
			<td><?php echo $invoice->last_sent ? __('invoices:senton', array(format_date($invoice->last_sent))) : __('global:no') ?></td>
			<td><?php echo $invoice->is_paid ? __('invoices:paidon', array(format_date($invoice->payment_date))) : __('global:no') ?></td>
			<td class="cell5 actions">
				
				<?php if (group_has_role('invoices', 'view')): ?>
                <?php echo anchor($invoice->unique_id, __('global:view'), array('class' => 'icon view', 'title' => __('global:view'))); ?>
				<?php endif ?>

				<?php if (group_has_role('invoices', 'send')): ?>
                <?php echo anchor('admin/invoices/created/'.$invoice->unique_id, __('global:send_to_client'), array('class' => 'icon mail', 'title' => __('global:send_to_client'))); ?>
				<?php endif ?>
				
				<?php if (group_has_role('invoices', 'edit')): ?>
                <?php echo anchor('admin/invoices/edit/'.$invoice->unique_id, __('global:edit'), array('class' => 'icon edit', 'title' => __('global:edit'))); ?>
				<?php endif ?>
				
				<?php if (group_has_role('invoices', 'delete')): ?>
                <?php echo anchor('admin/invoices/delete/'.$invoice->unique_id, __('global:delete'), array('class' => 'icon delete', 'title' => __('global:delete'))); ?>
				<?php endif ?>
            </td>
    	</tr>
  		<?php endforeach; ?>

    	</tbody>
    </table>
</div>

<?php endif; ?>
<?php if (count($tasks)): $milestone = false; ?>

<div class="table-area">
    	
    	<?php foreach ($tasks as $task): ?>
	
		<?php if ($milestone !== $task['milestone_id']): ?>
			
			<?php if ($milestone !== false): ?>	
					</tbody>
			    </table>
			<?php endif; ?>
					
			<div class="head-box" style="margin: 30px 0 0 0">
			<?php if ($task['milestone_id'] > 0): ?>
				<div class="milestone-icon" style="background-color: <?php echo $task['milestone_color'] ?>; margin: 7px 0pt 0pt 40px;">
				</div>
				<h4 class="ttl-small" style="margin-left:-30px"><?php echo __('milestones:milestone') ?>: 
				<?php echo anchor('admin/projects/milestones/view/'.$task['milestone_id'], $task['milestone_name']) ?></h4>
				
			<?php else: ?>
				<h4 class="ttl-small" style="margin-left:0px"><?php echo __('milestones:no_milestone') ?></h4>
			<?php endif; ?>
			</div>
			
			<table id="paidRequestTable" class="listtable pc-table table-activity" cellspacing="0">
		    	<thead>
		    		<tr>
		    		    <th class="cell1"><?php echo __('tasks:task') ?></th>
		
						<?php if (group_has_role('projects', 'track_time')): ?>
						<th class="cel12"><?php echo __('tasks:timer') ?></th>
						<?php endif ?>
						
		    		    <th class="cel12"><?php echo __('tasks:hours') ?></th>
		    		    <th class="cel12"><?php echo __('tasks:rate') ?></th>
		    		    <th class="cel13"><?php echo __('invoices:due') ?></th>
		    			<th class="cell5"><?php echo __('global:actions') ?></th>
		    		</tr>
		    	</thead>
		    	<tbody>
		<?php endif; ?>
	
    	<tr id="task-row-<?php echo $task['id']; ?>">
            <?php echo $this->load->view('_task_row', array('task' => $task)); ?>
    	</tr>

    	<?php $milestone = $task['milestone_id']; endforeach; ?>

    	</tbody>
    </table>
</div>

<div class="pagination">
	<?php echo $this->pagination->create_links(); ?>
</div>

<?php else: ?>

<div class="invoice-block">
	<div class="reminder_notification">
		<h4><?php echo __('tasks:no_task_title') ?></h4>
		<p><?php echo __('tasks:no_task_message') ?></p>
	</div>
</div>    	

<?php endif; ?>

<?php if ($project->description): ?>

<div class="invoice-block">
	<div id="project-notes">
		<div class="head-box">
		   <h3 class="ttl ttl3"><?php echo __('global:notes') ?></h3>
	    </div>
		<?php echo auto_typography($project->description); ?>
	</div><!-- /project-notes -->
</div>
<?php endif; ?>

<script type="text/javascript">
	$(".fire-ajax").click(function (e) {
		$('#ajax_container').hide();
		e.preventDefault();
		$.get($(this).attr('href'), function (data) {
			$('#ajax_container').html(data).slideDown();
		});
	});
</script>