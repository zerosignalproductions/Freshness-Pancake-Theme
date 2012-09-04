<?php
$key = isset($key) ? $key : 1;
$id = $key > 1 ? $key : '';
$amount = isset($amount) ? $amount : '100';
$default_due_date = Settings::get('default_invoice_due_date');
$default_due_date = $default_due_date === '' ? '' : format_date(strtotime('+'.$default_due_date.' days'));
$due_date_input = isset($due_date_input) ? $due_date_input : $default_due_date;
$is_percentage = isset($is_percentage) ? $is_percentage : true;
$notes = isset($notes) ? $notes : '';
$is_paid = isset($is_paid) ? $is_paid : false;
$currency_code = isset($currency_code) ? $currency_code : 0;
?>
<div class="partial-inputs">
    <?php echo form_input('partial-amount['.$key.']', set_value('partial-amount['.$key.']', $amount), 'class="txt partial-amount" id="partial-amount'.$id.'"'); ?>
    <div class="partial-percentage"><?php echo form_dropdown('partial-is_percentage['.$key.']', array(Currency::symbol($currency_code), '%'), set_value('partial-is_percentage['.$key.']', $is_percentage), 'id="partial-percentage'.$id.'"'); ?></div>
    <?php echo form_input('partial-due_date['.$key.']', set_value('partial-due_date['.$key.']', $due_date_input), 'class="txt datePicker partial-due_date" id="partial-due_date'.$id.'"'); ?>
    <?php echo form_input('partial-notes['.$key.']', set_value('partial-notes['.$key.']', $notes), 'class="txt partial-notes" id="partial-notes'.$id.'"'); ?>
    <?php if ($action == 'edit'): ?>
        <a href="#" data-details="<?php echo $key;?>" class="yellow-btn partial-payment-details key_<?php echo $key;?>"><span><?php echo lang('partial:'.($is_paid ? 'paymentdetails' : 'markaspaid')); ?></span></a>
    <?php endif;?>
	<a href="#" data-details="<?php echo $key;?>" class="yellow-btn partial-payment-delete key_<?php echo $key;?>"><span>&times;</span></a> 
</div>