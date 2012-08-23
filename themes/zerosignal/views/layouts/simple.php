<!DOCTYPE html>
<html>

<head>

<title><?php echo stripslashes(Settings::get('site_name')); ?> - Payments</title>

<!--metatags-->
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<!-- CSS -->
<?php echo asset::css('request_style.css', array('media' => 'all')); ?>
 
<?php if (Settings::get('frontend_css')): ?>
	<style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
<?php endif; ?>

</head>

<body class="simple-invoice <?php echo is_admin() ? 'admin' : 'not-admin';?>">

	<div id="wrapper">
    <div id="logo"></div>

		<div id="headerInvoice">

		</div><!-- /headerInvoice -->
        
            <?php echo $template['body']; ?>
		
        <div id="footer">
			<?php if (is_admin()): ?>
				<?php echo anchor('admin', __('global:backtoadmin')); ?>
			<?php endif; ?>
		</div><!-- /footer -->
	</div><!-- /wrapper -->
</body>
</html>