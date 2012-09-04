<div class="invoice-block">
<ul class="btns-list" style="height:30px">
	<li>&nbsp;</li>
</ul><!-- /btns-list end -->

<div id="ajax_container"></div>

<div class="head-box">
	<h3 class="ttl ttl3">Create User</h3>
</div><!-- /head-box end -->


<?php echo form_open("admin/users/create", 'id="user-form"');?>

<fieldset>

	<div id="invoice-type-block" class="row">
		
		<div class="row">
			<p>Please enter the users information below.</p>
		</div>
		
		<div class="row">
		<label for="username">Username:</label>
		<?php echo form_input(array(
			'name'	=> 'username',
			'id'	=> 'username',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> set_value('username'),
		));?>
		</div>

		<div class="row">
		<label for="email">Email:</label>
		<?php echo form_input(array(
			'name'	=> 'email',
			'id'	=> 'email',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> set_value('email'),
		)); ?>
		</div>
		
		<div class="row">
		<label for="first_name">First Name:</label>
		<?php echo form_input(array(
			'name'	=> 'first_name',
			'id'	=> 'first_name',
			'type'	=> 'text',
			'value'	=> set_value('first_name'),
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
			'value'	=> set_value('last_name'),
		));?>
		</div>

		<div class="row">
		<label for="company">Company:</label>
		<?php echo form_input(array(
			'name'	=> 'company',
			'id'	=> 'company',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> set_value('company'),
		));?>
		</div>

		<div class="row">
		<label for="phone1">Phone:</label>
		<?php echo form_input(array(
			'name'	=> 'phone',
			'id'	=> 'phone',
			'type'	=> 'text',
			'class'	=>	'txt',
			'value'	=> set_value('phone'),
		));?>
		</div>

		<div class="row">
		<label for="password">Password:</label>
		<?php echo form_password(array(
			'name'	=> 'password',
			'id'	=> 'password',
			'type'	=> 'password',
			'class'	=>	'txt',
			'value'	=> set_value('password'),
		));?>
		</div>

		<div class="row">
		<label for="password_confirm">Confirm Password:</label>
		<?php echo form_password(array(
			'name'	=> 'password_confirm',
			'id'	=> 'password_confirm',
			'type'	=> 'password',
			'class'	=>	'txt',
			'value'	=> set_value('password_confirm'),
		));?>
		</div>

		<div class="row">
		<label for="group">Group:</label>
		<div class="sel-item">
		<?php echo form_dropdown('group', $groups, set_value('group'), '');?>
		</div>
		</div>


		<div class="row">
		<a href="#" onclick="$('#user-form').submit()" class="yellow-btn"><span>Create User</span></a>
		</div>
            <input type="submit" class="hidden-submit" />
<?php echo form_close();?>
</div>