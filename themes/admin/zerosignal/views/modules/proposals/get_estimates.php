<div class="estimate-selector" data-inserting="<?php echo __('estimates:attachingtoproposal');?>">
    <h2><?php echo __('proposals:selected_attachments') ?></h2>
    <p class="estimate-select-description">Note: When you add an estimate to a proposal, you cannot use it again in another proposal, so it will stop appearing in this menu. You must create a duplicate of the estimate if you want to use it in another proposal.</p>
    <?php if (count($estimates) > 0) :?>
        <?php echo form_dropdown('estimate', $estimates, 0, 'id="estimate-picker"'); ?>
    <?php else: ?>
    <p><?php echo __('estimates:noestimatesforthisclient') ?></p>
    <?php endif;?>
    <div class="estimate-link-container">
        <?php if (count($estimates) > 0) :?>
        <a class="pickEstimate" href="#"><?php echo __('proposals:attach_selected_estimate');?></a> or 
        <?php endif;?>
        
		<?php if (group_has_role('invoices', 'create')): ?>
		<?php echo anchor('admin/estimates/create_estimate/iframe/'.$client_id, lang('estimates:createnew'), array('class'=>'createEstimate', 'rev'=>'iframe|700')) ?>
		<?php endif ?>
    </div>
</div>
<script>$('#estimate-picker').change(function() {
    $('.createEstimate').attr('href', '<?php echo site_url('admin/estimates/create_estimate/iframe');?>/'+$(this).val()).facebox();
}); $('.createEstimate').facebox();</script>