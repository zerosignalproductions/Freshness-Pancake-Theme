<div class="update-notification" id="update">
    <h2>Pancake was upgraded from <?php echo $from; ?> to <?php echo $to; ?>!</h2>

    <?php if (!empty($changelog)) :?>
    <div class="changelog-container">
	<h3><?php echo __('update:whatschanged', array($to))?></h3>
	<div class="changelog">
	    <?php echo $changelog; ?>
	</div>
    </div>
    <?php else: ?>
	<div class="error-download">
	    <h3><?php echo __('update:errordownloading'); ?></h3>
	<p>If you're seeing this, then something is wrong. Please let us know by emailing support@pancakeapp.com.</p>
	</div>
    <?php endif;?>
</div>