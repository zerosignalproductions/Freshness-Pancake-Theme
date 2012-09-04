		<div class="table-area thirty-days">
			<table cellspacing="0" class="pc-table">
				<thead>
				<tr>
					<th class="cell1">Name</th>
					<th class="cell3">Email</th>
					<th class="cell5">Group</th>
					<th class="cell5">Status</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($users as $user): ?>
					<tr>
						<td><?php echo anchor('admin/users/edit/'.$user['id'], $user['first_name'].' '.$user['last_name']) ?></td>
						<td><?php echo mailto($user['email']) ?></td>
						
						<?php if (is_admin()): ?>
						<td><?php echo anchor('admin/users/groups/edit/'.$user['group_id'], $user['group_description']) ?></td>
						<?php else: ?>
						<td><?php echo $user['group_description'] ?></td>
						<?php endif ?>
						
						<td>
							<?php if ( ! PANCAKE_DEMO and group_has_role('users', 'change_status')): ?>
							<?php echo ($user['active']) ? anchor("admin/users/deactivate/".$user['id'], 'Active') : anchor("admin/users/activate/". $user['id'], 'Inactive'); ?>
							<?php else: ?>
							<?php echo $user['active'] ? 'Active' : 'Inactive'; ?>
							<?php endif ?>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
		</div><!-- /table-area -->
		
	



