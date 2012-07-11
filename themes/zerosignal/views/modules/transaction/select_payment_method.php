<div id="content">
	<h2><?php echo __('gateways:selectpaymentmethod');?></h2>
        <?php foreach ($gateways as $gateway) : ?>
        <p style="margin-top: 2.5em;"><?php echo anchor($payment_url.'/'.$gateway['gateway'], $gateway['frontend_title'], 'class="simple-button"'); ?></p>
        <?php endforeach; ?>
</div>