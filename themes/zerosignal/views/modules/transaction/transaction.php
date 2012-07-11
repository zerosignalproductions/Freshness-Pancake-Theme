<div style="text-align: center;">

	<?php if (empty($fee)): ?>
		
	<h2><?php echo __('transactions:orderbeingprocessed', array($gateway));?></h2>
    <p><?php echo __('transactions:ifyouarenotredirected', array($gateway));?></p>
	<?php else: ?>
	<p><?php echo __('transactions:fee_applied', array($gateway, $fee));?></p>
	<?php endif ?>
	
    <?php echo $form; ?>
</div>