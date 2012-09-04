<div class="invoice-block">

<div id="ajax_container"></div>

<div class="head-box">
	<h3 class="ttl ttl3">Edit User</h3>
</div><!-- /head-box end -->


<?php echo form_open("admin/users/edit/".$member->id, 'id="user-form"');?>

<fieldset>

	<div id="invoice-type-block" class="row">

		<div class="row">
		<label for="username">Username:</label>
		<?php echo form_input(array(
			'name'	=> 'username',
			'id'	=> 'username',
			'type'	=> 'text',
			'class'	=>	'txt',
			'disabled' => true,
			'value'	=> $member->username,
		));?>
		</div>

		<div class="row">
		<label for="email">Email:</label>
		<?php echo form_input(array(
			'name'	=> 'email',
			'id'	=> 'email',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> $member->email,
		)); ?>
		</div>
		
		<div class="row">
		<label for="first_name">First Name:</label>
		<?php echo form_input(array(
			'name'	=> 'first_name',
			'id'	=> 'first_name',
			'type'	=> 'text',
			'value'	=> $member->first_name,
			'class'	=>	'txt',
		)); ?>
		</div>

		<div class="row">
		<label for="last_name">Last Name:</label>
		<?php echo form_input(array(
			'name'	=> 'last_name',
			'id'	=> 'last_name',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> $member->last_name,
		));?>
		</div>

		<div class="row">
		<label for="company">Company:</label>
		<?php echo form_input(array(
			'name'	=> 'company',
			'id'	=> 'company',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> $member->company,
		));?>
		</div>

		<div class="row">
		<label for="phone1">Phone:</label>
		<?php echo form_input(array(
			'name'	=> 'phone',
			'id'	=> 'phone',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> $member->phone ? $member->phone : '',
		));?>
		</div>

		<?php if (PANCAKE_DEMO): ?>
			
		<p><?php echo __('global:disabled_in_demo') ?></p>
			
		<div class="row">
			<label for="password">Password:</label>
			<?php echo form_password(array(
				'name'	=> 'password',
				'id'	=> 'password',
				'type'	=> 'password',
				'class'	=>	'txt',
				'disabled' => 'disabled',
			));?>
			</div>

			<div class="row">
				<label for="password_confirm">Confirm Password:</label>
				<?php echo form_password(array(
					'name'	=> 'password_confirm',
					'id'	=> 'password_confirm',
					'type'	=> 'password',
					'class'	=>	'txt',
					'disabled' => 'disabled',
				));?>
			</div>
		
			<div class="row">
				<label for="group_id">Group:</label>
				<div class="sel-item">
				<?php echo form_dropdown('group_id', $groups, $member->group_id, 'disabled="disabled"');?>
			</div>
		</div>
		
		<?php else: ?>
			
		<div class="row">
		<label for="password">Password:</label>
		<?php echo form_password(array(
			'name'	=> 'password',
			'id'	=> 'password',
			'type'	=> 'password',
			'class'	=>	'txt',
			'disabled'
		));?>
		</div>

		<div class="row">
		<label for="password_confirm">Confirm Password:</label>
		<?php echo form_password(array(
			'name'	=> 'password_confirm',
			'id'	=> 'password_confirm',
			'type'	=> 'password',
			'class'	=>	'txt',
		));?>
		</div>

		<div class="row">
		<label for="group_id">Group:</label>
		<div class="sel-item">
		<?php echo form_dropdown('group_id', $groups, $member->group_id);?>
		</div>
		</div>

		<?php endif ?>

		<div class="row">
		<a href="#" onclick="$('#user-form').submit()" class="yellow-btn"><span><?php echo lang('global:save') ?></span></a>
		</div>
            <input type="submit" class="hidden-submit" />
<?php echo form_close();?>
</div>