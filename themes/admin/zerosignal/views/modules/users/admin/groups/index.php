<div class="table-area thirty-days">
	<?php if ($groups): ?>
		<table cellspacing="0" class="pc-table">
			<thead>
				<tr>
					<th class="cell1"><?php echo lang('groups:name');?></th>
					<th class="cell5"><?php echo lang('groups:short_name');?></th>
					<th class="cell5"><?php echo __('global:actions') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($groups as $group):?>
				<tr>
					<td><?php echo $group->description; ?></td>
					<td><?php echo $group->name; ?></td>
					<td class="cell5 actions">
					<?php echo anchor('admin/users/groups/edit/'.$group->id, lang('global:edit'), 'class="icon edit"'); ?>
					<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
						<?php echo anchor('admin/users/groups/delete/'.$group->id, lang('global:delete'), 'class="confirm icon delete"'); ?>
					<?php endif; ?>
					</td>
				</tr>
			<?php endforeach;?>
			</tbody>
		</table>
		

	
	<?php else: ?>
		<div class="title">
			<p><?php echo lang('groups:no_groups');?></p>
		</div><!-- /title -->
	<?php endif;?>


</div><!-- /table-area -->