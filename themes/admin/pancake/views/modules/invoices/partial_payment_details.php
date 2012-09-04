<div id="<?php echo $is_add_payment ? 'add_payment' : 'partial-payment-details'?>">
    <form class="invoice-block <?php echo $is_add_payment ? '': 'partial-payment-details';?>">
        <div class="row"><label><?php echo __('partial:paymentmethod');?></label><div class="sel-item"><?php echo form_dropdown('payment-gateway', Gateway::get_enabled_gateway_select_array(), $gateway, 'class="not-uniform"'); ?></div></div>
        <?php if (!$is_add_payment): ?>
            <div class="row"><label><?php echo __('partial:paymentstatus');?></label><div class="sel-item"><?php echo form_dropdown('payment-status', array('Completed' => __('gateways:completed'), 'Pending' => __('gateways:pending'), 'Refunded' => __('gateways:refunded'), '' => __('gateways:unpaid')), $status === '0' ? '' : $status, 'class="not-uniform"'); ?></div></div>
	<?php else: ?>
            <div class="row"><label><?php echo __('invoices:amount');?></label><input type="text" class="text txt" name="payment-amount" value=""></div>
        <?php endif;?>
        <div class="row"><label><?php echo __('partial:paymentdate');?></label><input type="text" class="text txt datePicker" name="payment-date" value="<?php echo $date;?>"></div>
	<div class="row"><label><?php echo __('partial:transactionfee');?></label><label for="fee" class="use-label"><?php echo $currency;?></label><input type="text" class="text txt" id="fee" name="transaction-fee" value="<?php echo $fee;?>"></div>
        <div class="row"><label><?php echo __('partial:transactionid');?></label><input type="text" name="payment-tid" class="text txt" value="<?php echo $tid;?>"></div>
        <div class="row"><label></label><a href="#" class="yellow-btn <?php echo $is_add_payment ? 'add_payment_button' : 'savepaymentdetails'?>"><span><?php echo __('partial:'.($is_add_payment ? 'add_payment' : 'savepaymentdetails'));?></span></a></div>  
        <input type="submit" class="hidden-submit" />
    </form>
</div>