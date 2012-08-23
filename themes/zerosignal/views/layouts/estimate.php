<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
    <title><?php echo __('estimates:estimatenumber', array($invoice['invoice_number']));?> | <?php echo Settings::get('site_name'); ?></title>
    
    <!--favicon-->
    <link rel="shortcut icon" href="" />
    
    <!--metatags-->
    <meta name="robots" content="noindex,nofollow" />
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    
    <!-- CSS -->
    <?php echo asset::css('invoice_style.css', array('media' => 'all'), NULL, $pdf_mode); ?>
    <link href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700,600italic' rel='stylesheet' type='text/css'>        

    <?php if (Settings::get('frontend_css')): ?>
        <style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
    <?php endif; ?>
</head>

<body class="estimate <?php echo is_admin() ? 'admin' : 'not-admin';?> <?php if ($pdf_mode): ?>pdf_mode pdf<?php else: ?>not-pdf<?php endif;?>">
    <?php if( ! $pdf_mode): ?>
    <div class="buttonBar">
        <div class="buttonHolders">
            <div id="pdf">
                <a href="<?php echo site_url('pdf/'.$invoice['unique_id']); ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
            </div><!-- /pdf -->            
            <?php if (is_admin()): ?>
                <?php echo anchor('admin/invoices/'.((isset($is_estimate) and $is_estimate) ? 'estimates' : 'all'), 'Go to Admin &rarr;'); ?>
            <?php endif; ?>
            
            <?php echo anchor(Settings::get('kitchen_route').'/'.$client_unique_id, 'Go to Client Area &rarr;'); ?>            
        </div><!-- /buttonHolders -->
    </div><!-- /buttonBar -->
    <?php endif; ?>

    <div id="wrapper">
		<div id="header">
			<div id="envelope" <?php if (!$pdf_mode):?> style="padding:3em 0 0 0; margin-top: 70px;" <?php endif; ?>>
                <h1><span><?php echo __('global:estimate'); ?></span></h1>
                                    
                <?php //load the Info Boxes ?>
                <?php include($this->template->get_theme_path().'views/info.php'); ?>                           
                           
			</div><!-- /envelope -->
		</div><!-- /header -->
        
        <div class="description">
            <?php if ( ! empty($invoice['description'])): ?>
                <?php echo auto_typography($invoice['description']);?>
            <?php endif; ?>
        </div>        
        
        <table class="invoice-meta">
            <tr>
                <td class="invoice-id"><span class="h5">Estimate No:</span> <span><?php echo __($invoice['invoice_number']); ?></span></td>
                <td class="spacer">&nbsp;</td>
                <td class="invoice-date"><span class="h5"><?php echo __('invoices:date_entered'); ?>:</span> <span><?php echo $invoice['date_entered'] ? format_date($invoice['date_entered']) : '<em>n/a</em>';?></span></td>
                <td class="invoice-due"><span class="h5"><?php echo __('invoices:due'); ?>:</span> <span><?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : 'n/a';?></span></td>
            </tr>
        </table>                        
                
        <?php echo $template['body']; ?>

		<div id="footer"></div><!-- /footer -->
	</div><!-- /wrapper -->
</body>
</html>