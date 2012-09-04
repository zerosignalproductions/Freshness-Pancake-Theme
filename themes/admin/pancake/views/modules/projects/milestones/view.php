<div class="invoice-block">
	
	
	<div class="head-box" style="margin:20px 0 20px 0">
		<div class="milestone-icon" style="background-color: <?php echo $milestone->color ?>; margin: 7px 0pt 0pt 0px;"></div>
	   <h3 class="ttl-narrow"><?php echo __('milestones:milestone') ?>: <?php echo $milestone->name ?></h3>
		<p class="details"><?php echo __('projects:project') ?>: <?php echo anchor('admin/projects/view/'.$project->id, $project->name); ?> | <?php echo __('global:client') ?>: <?php echo $project->first_name; ?> <?php echo $project->last_name; ?> - <?php echo $project->company; ?> | <?php echo __('milestones:target_date') ?>: <?php echo format_date($milestone->target_date); ?> | <?php echo __('tasks:default_rate') ?>: <?php echo Currency::format($project->rate); ?></p>
			
    </div>


	    <ul class="btns-list" style="float:left!important; padding-left:30px; margin-bottom:20px">
			<li><a href="<?php echo site_url('admin/projects/tasks/create/'.$project->id.'/'.$milestone->id); ?>" class="yellow-btn fire-ajax"><span><?php echo __('tasks:create') ?></span></a></li>	
                        <li><a href="<?php echo site_url('admin/projects/milestones/edit/'.$milestone->id); ?>" class="yellow-btn "><span><?php echo __('milestones:edit') ?></span></a></li>
			<li><a href="<?php echo site_url('admin/projects/milestones/delete/'.$milestone->id); ?>" class="yellow-btn "><span><?php echo __('milestones:delete') ?></span></a></li>
	    </ul><!-- /btns-list end -->


		<div id="head-box">
			
			<h3 class="ttl" style="margin-left:-30px"></h3>

		</div><!-- /head-box -->

	<br style="clear: both;" />
	
    <div id="ajax_container"></div>


</div>

<?php if (count($tasks)): ?>

<div class="table-area">
			
	<table id="paidRequestTable" class="listtable pc-table table-activity" cellspacing="0">
    	<thead>
    		<tr>
    		    <th class="cell1"><?php echo __('tasks:task') ?></th>
				<th class="cel12"><?php echo __('tasks:timer') ?></th>
    		    <th class="cel12"><?php echo __('tasks:hours') ?></th>
    		    <th class="cel12"><?php echo __('tasks:rate') ?></th>
    		    <th class="cel13"><?php echo __('global:is_completed') ?></th>
    			<th class="cell5"><?php echo __('global:actions') ?></th>
    		</tr>
    	</thead>
    	<tbody>
	
		<?php foreach ($tasks as $task): ?>
	
    	<tr id="task-row-<?php echo $task['id']; ?>">
            <?php echo $this->load->view('_task_row', array('task' => $task)); ?>
    	</tr>

    	<?php endforeach; ?>

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