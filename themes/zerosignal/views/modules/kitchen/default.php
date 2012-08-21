<div id="content">
    <table class="invoice-contact">
        <tr class="row">
            <td id="company-info-holder">
                <ul class="info">
                    <li class="logo"><?php echo logo(false, false, 2);?></li>
                    <li class="address"><h5>Address:</h5> <?php echo nl2br(Settings::get('mailing_address')); ?></li>
                    <li class="phone"><h5>Phone:</h5> 512-552-1536</li>
                    <li class="email"><h5>Email:</h5> <?php echo nl2br(Settings::get('notify_email')); ?></li>
                    <li class="fax"><h5>Fax:</h5> </li>
                </ul>
            </td>

            <td id="invoice-details-holder">
                <div id="clientInfo">
                    <div id="billing-info">
                        <ul class="info">
                            <?php if($client->company): ?>
                                <li class="logo"><h2><?php echo $client->company;?></h2></li>
                            <?php endif; ?>
                            <li class="address"><h5>Address: </h5><?php echo nl2br($client->address);?></li>
                            <li><h5>Contact: </h5> <?php echo $client->first_name.' '.$client->last_name;?></li>
                            <li class="email"><h5>Email:</h5> <?php echo $client->email; ?></li>
                            <li class="phone"><h5>Phone:</h5> <?php echo $client->phone; ?></li>
                        </ul>
                    </div>
                </div><!-- /clientInfo -->
            </td>                        
        </tr>
    </table>    

<?php if (group_has_role('invoices', 'view') or !logged_in()) : ?>

	<?php if (count($invoices)): ?>
	
    <div class="header">
        <div class="envelope">
            <h2><span>Invoices</span></h2>
        </div>
    </div>
	
	<table class="data-table invoices" cellpadding="0" cellspacing="0">
		<thead>
            <tr>
                <th class="desc"><?php echo lang('invoices:number') ?></th>
                <th class="due"><?php echo lang('invoices:due') ?></th>
                <th class="total"><?php echo lang('invoices:amount') ?></th>
                <th class="paid"><?php echo lang('invoices:is_paid') ?></th>
                <th class="view"><?php echo lang('invoices:view') ?></th>
                <th class="notes"><?php echo lang('global:notes') ?></th>
            </tr>
		</thead>
		<?php foreach ($invoices as $invoice): ?>
        <tbody>
            <tr class="items-desc-row <?php echo ($invoice->paid ? 'paid' : 'unpaid'); ?>-invoice">
                <td><?php echo $invoice->invoice_number; ?></td>
                <td><?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>n/a</em>';?></td>
                <td><?php echo Currency::format($invoice->amount); ?></td>
                <td class="status_<?php echo ($invoice->paid ? 'paid' : 'unpaid'); ?>"><?php echo ($invoice->paid ? 'Paid' : 'Unpaid'); ?></td>
                <td>
                    <?php echo anchor($invoice->unique_id, lang('invoices:view')); ?>
                </td>
                <td>
                    <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$invoice->id, 'Comments ('.$invoice->total_comments.')'); ?>
                </td>
            </tr>
        </tbody>
		<?php endforeach ?>
	</table>

	
	<?php endif; //END INVOICE COUNT ?>


	<?php if (count($estimates) or !logged_in()): ?>

    <div class="header">
        <div class="envelope">
            <h2><span>Estimates</span></h2>
        </div>
    </div>
    
	<table class="data-table estimates" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th class="desc"><?php echo lang('invoices:amount') ?></th>
			<th class="view"><?php echo lang('estimates:view') ?></th>
			<th class="notes"><?php echo lang('global:notes') ?></th>
		</tr>
		</thead>
		<?php foreach ($estimates as $estimate): ?>
			<tr class="items-desc-row">
			<td><?php echo Currency::format($estimate->amount); ?></td>
			<td>
				<?php echo anchor($estimate->unique_id, lang('estimates:view')); ?>
			</td>
			<td>
				<?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/invoice/'.$estimate->id, 'Comments ('.$estimate->total_comments.')'); ?>
			</td>
		</tr>
		<tr class="border-bottom">
			<td colspan="3">
				<div id="border-holder-bottom">
				</div><!-- /border-holder-bottom -->
			</td>
		</tr>
		<?php endforeach ?>
	</table>
	<?php endif //END ESTIMATE COUNT ?>

<?php endif; // END CAN VIEW INVOICES ?>



<?php if (group_has_role('projects', 'view') or !logged_in()) : ?>
	<?php if ($projects): ?>
	
    <div class="header">
        <div class="envelope">
            <h2><span>Projects</span></h2>
        </div>
    </div>
    

	<?php $prev_milestone = null; ?>
	<?php foreach ($projects as $project): ?>
		
		<div id="project-<?php echo $project->id; ?>-holder" class="project">

		
		<h4><?php echo $project->name; ?></h4>
		<p style="font-size:12px; color:#ccc"><?php echo lang('projects:due_date') ?>: <?php echo format_date($project->due_date); ?><br>
		<?php echo lang('projects:is_completed') ?>: <?php echo ($project->completed ? 'Yes' : 'No'); ?><br>
		<?php echo anchor('clients/'.$client->unique_id.'/comments/project/'.$project->id, 'Comments ('.$project->total_comments.')'); ?></p>

		<div id="project-details-holder">
		<table class="data-table projects" cellpadding="0" cellspacing="0">
			<?php foreach ($project->tasks as $task): ?>
				<?php if ($task['milestone_name'] !== $prev_milestone): ?>
                    <thead>
					<tr class="milestone-title">
						<th class="desc">
							
							<?php if (!empty($task['milestone_name'])): ?>
								<div class="milestone-icon" style="background-color: <?php echo $task['milestone_color'] ?>"></div>
							<?php endif; ?>
							
							<?php echo (!empty($task['milestone_name']) ?  $task['milestone_name'] :  lang('tasks:no_milestones')); ?> </th>
						<th class="total"><?php echo lang('tasks:hours') ?></th>
						<th class="due"><?php echo lang('tasks:due_date') ?></th>
						<th class="view"><?php  echo __('global:status') ?></th>
						<th class="notes"><?php  echo __('global:notes') ?></th>
					</tr>
                    </thead>                    
					<?php $prev_milestone = $task['milestone_name']; ?>
				<?php else: ?>
                    <thead>
					<tr class="milestone-title">
						<th class="desc">
							
							<?php if (!empty($task['milestone_name'])): ?>
								<div class="milestone-icon" style="background-color: <?php echo $task['milestone_color'] ?>"></div>
							<?php endif; ?>
							
							<?php echo (!empty($task['milestone_name']) ?  $task['milestone_name'] :  lang('tasks:no_milestones')); ?> </th>
						<th class="total"><?php echo lang('tasks:hours') ?></th>
						<th class="due"><?php echo lang('tasks:due_date') ?></th>
						<th class="view"><?php  echo __('global:status') ?></th>
						<th class="notes"><?php  echo __('global:notes') ?></th>
					</tr>
                    </thead>                 
                <?php endif; ?>
				
                <tbody>
                    <tr class="border-top">
                    <tr class="items-desc-row">
                        <td>
                            <?php if ($task['completed'] == '1'): ?>
                                <strike><?php echo $task['name']; ?></strike>
                            <?php else: ?>
                                <?php echo $task['name']; ?>
                            <?php endif ?>
                            
                            </td>
                        <td><?php echo format_hours($task['tracked_hours']); ?></td>
                        <td><?php echo $task['due_date'] ? format_date($task['due_date']) : 'N/A'; ?></td>
                        <td>
                                <div class="status_indicator <?php echo ($task['completed'] ? 'green' : 'red'); ?>">
                                    <?php echo ($task['completed'] ? 'Completed' : 'Inprogress'); ?>
                                </div><!-- /status_indicator -->
                            </td>
                        <td>
                            <?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/task/'.$task['id'], 'Comments ('.$task['total_comments'].')'); ?>
                        </td>
                    </tr>
                    <tr class="item-notes">
                        <td colspan="5"><?php echo auto_typography($task['notes']);?></td>
                    </tr>
                </tbody>
	
			<?php endforeach ?>
		</table><!-- /kitchen-table-->
		</div><!-- /project-details-holder -->
		
		</div><!-- /project-<?php echo $project->id; ?>-holder -->
	<?php endforeach ?>

	<?php endif ?>
<?php endif; //END CAN VIEW PROJECTS ?>



<?php if (group_has_role('proposals', 'view') or !logged_in()) : ?>
	<?php if (count($proposals)): ?>
	
    <div class="header">
        <div class="envelope">
            <h2><span><?php echo __('proposals:proposal') ?></span></h2>
        </div>
    </div>

	<table class="data-table proposals" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
			<th><?php echo lang('proposals:number') ?></th>
			<th><?php echo lang('proposals:proposal') ?></th>
			<th><?php echo lang('proposals:estimate') ?></th>
			<th><?php echo lang('proposals:status') ?></th>
			<th><?php  echo __('global:notes') ?></th>
		</tr>
		</thead>
		<?php foreach ($proposals as $proposal): ?>
			<tr class="items-desc-row">
			<td><?php echo $proposal->proposal_number; ?></td>
			<td><?php echo $proposal->title; ?></td>
			<td><?php echo ($proposal->amount > 0 ? Currency::format($proposal->amount) : lang('proposals:na')); ?></td>
			<td><?php echo __('proposals:' . (!empty($proposal->status) ? strtolower($proposal->status) : 'noanswer'), array(format_date($proposal->last_status_change))); ?></td>
			<td>
				<?php echo anchor('proposal/'.$proposal->unique_id, lang('proposals:view')); ?>
				<?php echo anchor(Settings::get('kitchen_route').'/'.$client->unique_id.'/comments/proposal/'.$proposal->id, 'Comments ('.$proposal->total_comments.')'); ?>
			</td>
		</tr>
		<tr class="border-bottom">
			<td colspan="5">
				<div id="border-holder-bottom">
				</div><!-- /border-holder-bottom -->
			</td>
		</tr>
		<?php endforeach ?>
	</table>

	<?php endif ?>
<?php endif; // END CAN VIEW PROPOSALS ?>


</div><!-- /projects -->