
<div class="head-box">
	<h3 class="ttl ttl3"><?php echo __('contact:calling_title', array($client->company)); ?></h3>
</div><!-- /head-box end -->

<br style="clear:both" />

<?php if ( ! $client->phone && ! $client->mobile): ?>

	<p>How are you here? There is no record of any phone for this client.</p>
	
<?php else: ?>
	
	<p>
		p: <?php echo ($client->phone) ? $client->phone : __('global:unknown') ?><br />
		m: <?php echo ($client->mobile) ? $client->mobile : __('global:unknown') ?>
	</p>

<?php endif ?>

<div class="form-holder" style="clear:both">
	<?php echo form_open('ajax/save_client_call', array('id' => 'save-call'), array('client_id' => $client->id, 'phone_type' => $phone_type)); ?>

	<div class="row">
		<label for="subject"><?php echo lang('contact:subject') ?>:</label>
		<?php echo form_input('subject', set_value('subject'), 'id="subject" class="txt short"'); ?>
	</div>
	
	<div class="row">
		<label for="contact-content"><?php echo lang('contact:content') ?>:</label>
		<?php echo form_textarea(array(
			'name' => 'content',
			'id' => 'contact-content',
			'value' => set_value('content'),
			'rows' => 3,
			'cols' => 30
		)); ?>
	</div>

	<p><a href="#" class="yellow-btn" onclick="$('form#save-call').submit(); return false;"><span><?php echo lang('global:save'); ?>&rarr;</span></a></p>
	
    <input type="submit" class="hidden-submit" />

<?php echo form_close(); ?>
</div>


<script type="text/javascript">
jQuery(function($) {
	
	$('form#save-call').submit(function(e){
		e.preventDefault();
		
		$.ajax({
			url: baseURL+'ajax/save_client_call',
			data: $(this).serialize(), 
			success: function() {
				$.facebox.close();
			},
			error: function(data, foo) {
				alert($.parseJSON(data.responseText).error);
			},
			type: 'POST',
			dataType: 'json'
		});
	});
	
});
</script>
