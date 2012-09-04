<div class="invoice-block">
<ul class="btns-list">
	<li></li>
</ul><!-- /btns-list end -->

<div id="ajax_container"></div>

<div class="head-box">
	<h3 class="ttl ttl3"><?php echo lang('clients:'.$action_type); ?></h3>
</div><!-- /head-box end -->


<div class="form-holder">
	<?php echo form_open('admin/clients/'.$action, 'id="client-mod"'); ?>
	<fieldset class="add_client">

		<div id="invoice-type-block" class="row">

		<div class="row">	
			<label for="title" class="use-label"><?php echo lang('global:title') ?>:</label>
			<?php echo form_input('title', set_value('title'), 'id="title" class="txt short"'); ?>
			
			<label for="first_name" class="use-label"><?php echo lang('global:first_name') ?></label>
			<?php echo form_input('first_name', set_value('first_name'), 'id="first_name" class="txt"'); ?>

			<label for="last_name" class="use-label"><?php echo lang('global:last_name') ?></label>
			<?php echo form_input('last_name', set_value('last_name'), 'id="last_name" class="txt"'); ?>
		</div>
		
		<div class="row">
			<label for="company" class="use-label"><?php echo lang('global:company') ?>:</label>
			<?php echo form_input('company', set_value('company'), 'id="company" class="txt"'); ?>
		</div>
		
		<div class="row">
			<label for="address" class="use-label"><?php echo lang('global:address') ?>:</label>
			<?php echo form_textarea(array(
				'name' => 'address',
				'id' => 'address',
				'value' => set_value('address'),
				'rows' => 3,
				'cols' => 30
			)); ?>
		</div>

		
		<div class="row">
			<label for="email" class="use-label"><?php echo lang('global:email') ?>:</label>
			<?php echo form_input('email', set_value('email'), 'id="email" class="txt"'); ?>
			
			<label for="website" class="use-label"><?php echo lang('global:website') ?>:</label>
			<?php echo form_input('website', set_value('website'), 'id="website" class="txt"'); ?>


		</div>



		<div class="row">
			<label for="phone" class="use-label"><?php echo lang('global:phone') ?>:</label>
			<?php echo form_input('phone', set_value('phone'), 'id="phone" class="txt"'); ?>
			
			<label for="mobile" class="use-label"><?php echo lang('global:mobile') ?>:</label>
			<?php echo form_input('mobile', set_value('mobile'), 'id="mobile" class="txt"'); ?>
			
				<label for="fax" class="use-label"><?php echo lang('global:fax') ?>:</label>
				<?php echo form_input('fax', set_value('fax'), 'id="fax" class="txt"'); ?>
		</div>


		<div class="row">
			<label for="profile" class="use-label"><?php echo lang('global:notes') ?>:</label>
			<?php echo form_textarea(array(
				'name' => 'profile',
				'id' => 'profile',
				'value' => set_value('profile'),
				'rows' => 6,
				'cols' => 60
			)); ?>
		</div>


		<div class="row">
			<label for="passphrase" class="use-label"><?php echo lang('clients:passphrase') ?>:</label>
			<?php echo form_input('passphrase', set_value('passphrase'), 'id="passphrase" class="txt"'); ?>
		</div>

	<p><a href="#" class="yellow-btn" onclick="$('#client-mod').submit();"><span><?php echo lang('clients:'.$action_type); ?>&rarr;</span></a></p>
	</fieldset>
    <input type="submit" class="hidden-submit" />

<?php echo form_close(); ?>
</div>
</div>