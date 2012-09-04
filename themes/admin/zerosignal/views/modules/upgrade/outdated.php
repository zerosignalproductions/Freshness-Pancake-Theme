<div class="update-notification" id="update">
    <h2><?php echo __('settings:newversionavailable', array($to)) ?></h2>

    <?php if (!empty($changelog)) :?>
    <div class="changelog-container">
	<h3><?php echo __('update:whatschanged', array($to))?></h3>
	<div class="changelog">
	    <?php echo $changelog; ?>
	</div>
    </div>

    <div class="cf">
	<a class="yellow-btn update" href="<?php echo site_url('admin/upgrade/update_if_no_conflicts');?>"><span><?php echo __('settings:updatenow');?></span></a>
	<a class="yellow-btn hide"><span><?php echo __('global:dontshowagain');?></span></a>
    </div>
    <?php else: ?>
    <div class="error-download">
	<h3><?php echo __('update:errordownloading'); ?></h3>
	<p>If you're seeing this, then something is wrong. Please let us know by emailing support@pancakeapp.com.</p>
    </div>
    <?php hide_notification('outdated_'.str_ireplace('.', '_', $to));?>
    <?php endif;?>
</div>
<script>
$('.update-notification .hide').click(function() {
    hide_notification('outdated_<?php echo str_ireplace('.', '_', $to);?>');
    $.facebox.close();
})
</script>