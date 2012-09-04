<div class="no_object_notification super-warning">
	
<h4><?php echo lang(((isset($estimate) and $estimate) ? 'estimates' : 'invoices').':delete_title'); ?></h4>
<?php echo form_open('admin/estimates/delete/'.$unique_id, 'id="delete-invoice-form"', array('unique_id' => $unique_id, 'action_hash' => $action_hash)); ?>

<p><?php echo lang(((isset($estimate) and $estimate) ? 'estimates' : 'invoices').':delete_message'); ?></p>
<p class="confirm-btn"><a href="#" class="yellow-btn" onclick="$('#delete-invoice-form').submit();"><span>&nbsp;&nbsp;<?php echo lang('global:yesdelete') ?>&nbsp;&nbsp;</span></a></p>

<?php echo form_close(); ?>

</div><!-- /no_object_notification warning-->