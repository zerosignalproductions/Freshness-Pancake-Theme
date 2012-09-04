<div class="invoice-block">
	
<div id="ajax_container"></div>

<?php if (empty($clients)): ?>
	
<div class="no_object_notification">
	<h4><?php echo lang('clients:noclienttitle') ?></h4>
	<p><?php echo lang('clients:noclientbody') ?></p>
	<p class="call_to_action"><a href="<?php echo site_url('admin/clients/create'); ?>" title="<?php echo lang('clients:add') ?>" class="yellow-btn"><span><?php echo lang('clients:add') ?></span></a></p>
</div><!-- /no_object_notification -->
</div><!-- /invoice-block -->
<?php else: ?>

<div id="project_container">

	<div class="table-area">
	<table class="pc-table" cellspacing="0">
		<thead>
			<tr>
				<th><?php echo lang('global:name') ?></th>
				<th><?php echo lang('global:contacts') ?></th>
				<th><?php echo lang('global:unpaid') ?></th>
				<th><?php echo lang('global:paid') ?></th>
                <th><?php echo lang('clients:health_check')?></th>
				<th><?php echo lang('global:actions') ?></th>
			</tr>
		</thead>
	<tbody>

	<?php foreach ($clients as $row): ?>
		<tr>
			<td>
				<a href="<?php echo site_url('admin/clients/view/'.$row->id); ?>"><?php echo $row->first_name;?> <?php echo $row->last_name;?></a><br />
				<?php echo $row->company;?>
			</td>
			<td>e: <?php echo mailto($row->email) ?></a>
				<br /><?php echo ( ! $row->phone && $row->mobile ? 'm: <a href="#" class="contact mobile" data-client="'.$row->id.'">'.$row->mobile : 'p: <a href="#" class="contact phone" data-client="'.$row->id.'">'.$row->phone).'</a>';?></td>
			<td><?php echo Currency::format($row->unpaid_total); ?></td>
			<td><?php echo Currency::format($row->paid_total); ?></td>
                        <td><div class="client-health-list">
	<div class="healthCheck">
		<span class="healthBar"><span class="paid" style="width:<?php echo $row->health['overall'];?>%"></span></span>
	</div><!-- /healthCheck -->
</div><!-- /invoice-block --></td>
			<td class="actions">
				
			<?php if (group_has_role('clients', 'edit')): ?>
			<?php echo anchor('admin/clients/edit/'.$row->id, __('global:edit'), array('class' => 'icon edit', 'title' => __('global:edit'))); ?> 
			<?php endif ?>
			
			<?php if (group_has_role('clients', 'delete')): ?>
			<?php echo anchor('admin/clients/delete/'.$row->id, lang('global:delete'), array('class' => 'icon delete', 'title' => __('global:delete'))); ?>
			<?php endif ?>
			</td>
		</tr>
	<?php endforeach; ?>

	</tbody>
	</table>
</div>
</div><!-- /invoice-block -->

<div class="pagination">
	<?php echo $this->pagination->create_links(); ?>
	</div>

</div>
<?php endif; ?>
