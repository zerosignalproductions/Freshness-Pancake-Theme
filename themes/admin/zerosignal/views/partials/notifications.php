

<?php if ($message = $this->session->flashdata('success')): ?>

    <?php $referrer = $_SERVER['HTTP_REFERER']; ?>
    <?php $referrer = parse_url($referrer, PHP_URL_PATH); ?>

    <?php /* Check if we're coming from the login page, <p> tags are only added there for some reason */ ?>
    <?php if (strpos($referrer, "login") != FALSE ): ?>
        <div class="notification success fadeable"><?php echo $message; ?></div>
    <?php else: ?>
        <div class="notification success fadeable"><p><?php echo $message; ?></p></div>
        
    <?php endif; ?>
<?php endif; ?>
<?php if (isset($messages['success'])): ?>
	<div class="notification success fadeable"><p><?php echo $messages['success']; ?></p></div>
<?php endif; ?>

<?php if ( $message = $this->session->flashdata('error')): ?>
	<div class="notification error"><b><?php echo __('global:error');?>:</b> <?php echo $message; ?></div>
<?php endif; ?>
<?php if (isset($messages['error'])): ?>
	<div class="notification error"><b><?php echo __('global:error');?>:</b> <?php echo $messages['error']; ?></div>
<?php endif; ?>
<?php if ($errors = validation_errors('<p>', '</p>')): ?>
	<div class="notification error"><?php echo $errors; ?></div>
<?php endif; ?>