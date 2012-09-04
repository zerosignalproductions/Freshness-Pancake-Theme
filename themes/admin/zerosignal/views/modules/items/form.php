<div class="invoice-block">
<ul class="btns-list">
	<li></li>
</ul><!-- /btns-list end -->

<div id="ajax_container"></div>

<div class="head-box">
	<h3 class="ttl ttl3"><?php echo lang('items:'.$action_type); ?></h3>
</div><!-- /head-box end -->


<div class="form-holder">
	<?php echo form_open('admin/items/'.$action, 'id="item-mod"'); ?>
	<fieldset class="add_item">

		<div id="invoice-type-block" class="row">
			
		<div class="row">	
			<label for="name" class="use-label"><?php echo lang('items:name') ?>:</label>
			<?php echo form_input('name', set_value('name'), 'id="name" class="txt"'); ?>
			
			<label for="qty" class="use-label"><?php echo lang('items:qty_hrs') ?></label>
			<?php echo form_input('qty', set_value('qty', 1), 'id="qty" class="txt numeric"'); ?>

			<label for="rate" class="use-label"><?php echo lang('items:rate') ?></label>
			<?php echo form_input('rate', set_value('rate', '0.00'), 'id="rate" class="txt numeric"'); ?>
		</div>
		
		<div class="row">
			<label for="description" class="use-label"><?php echo lang('global:description') ?>:</label>
			<?php echo form_textarea(array(
				'name' => 'description',
				'id' => 'description',
				'value' => set_value('description'),
				'rows' => 2,
				'cols' => 30
			)); ?>
		</div>
		
		<div class="row">
			<label for="tax_id"><?php echo lang('items:tax_rate') ?>:</label>
			<div class="sel-item">
				<?php echo form_dropdown('tax_id', Settings::tax_dropdown(), set_value('tax_id'), 'class="tax_id"'); ?>
			</div>
		</div>
	
	<p><a href="#" class="yellow-btn" onclick="$('#item-mod').submit(); return false;"><span><?php echo lang('items:'.$action_type); ?>&rarr;</span></a></p>
	</fieldset>
    <input type="submit" class="hidden-submit" />

<?php echo form_close(); ?>
</div>
</div>