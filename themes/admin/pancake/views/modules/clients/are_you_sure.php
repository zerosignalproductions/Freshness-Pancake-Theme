<div class="no_object_notification super-warning">

<h4><?php echo lang('clients:delete_title'); ?></h4>
<?php echo form_open('admin/clients/delete/'.$client_id, 'id="delete-client-form"', array('unique_id' => $client_id, 'action_hash' => $action_hash)); ?>

<p><?php echo lang('clients:delete_message')?> <span class="bad-news"><?php echo lang('global:confirm_emphisised')?></span></p>
<p class="confirm-btn"><a href="#" class="yellow-btn" onclick="$('#delete-client-form').submit();"><span>&nbsp;&nbsp;<?php echo lang('global:yesdelete') ?>&nbsp;&nbsp;</span></a></p>
<?php echo form_close(); ?>

</div><!-- /no_object_notification delete-warning-->