<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <title><?php echo __('kitchen:kitchen_name') ?> | <?php echo Settings::get('site_name'); ?></title>
    
    <!--favicon-->
    <link rel="shortcut icon" href="" />
    
    <!--metatags-->
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    
    <!-- CSS -->
    <?php echo asset::css('invoice_style.css', array('media' => 'all')); ?>
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700,600italic' rel='stylesheet' type='text/css'>        
    
    <?php if (Settings::get('frontend_css')): ?>
        <style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
    <?php endif; ?>
</head>

<body class="kitchen <?php echo is_admin() ? 'admin' : 'not-admin';?>">
	<div class="buttonBar">
		<div class="buttonHolders">
			
		<?php if (logged_in()): ?>
			<?php echo anchor('admin/', __('global:backtoadmin')); ?>
		<?php endif; ?>
		<?php if ($this->session->userdata('client_passphrase') != ''): ?>
		<?php if ($this->uri->segment(3) == ''): ?>
			<?php echo anchor(Settings::get('kitchen_route').'/'.$this->uri->segment(2), 'Dashboard', 'class="button active"'); ?>
		<?php endif; ?>
		<?php endif; ?>
		
		<?php if ($this->session->userdata('client_passphrase') != ''): ?>
			<?php echo anchor(Settings::get('kitchen_route').'/logout/'.$this->uri->segment(2), __('global:logout'), 'class="button"'); ?>
		<?php endif; ?>
		<?php if ($this->uri->segment(4) != ''): ?>
			<?php echo anchor(Settings::get('kitchen_route').'/'.$this->uri->segment(2), __('kitchen:backtodashboard')); ?>
		<?php endif; ?>
		
		<span class="button-bar-text "><?php echo Settings::get('site_name'); ?> - <?php echo __('kitchen:kitchen_name') ?></span>
		</div><!-- /buttonHolders -->
	</div><!-- /buttonBar -->
	
	<div id="wrapper">
        <?php //page titles are in the individual templates ?>
        <?php echo $template['body']; ?>
	</div><!-- /wrapper -->
</body>
</html>