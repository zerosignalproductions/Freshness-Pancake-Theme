<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <title><?php echo __('invoices:invoicenumber', array($invoice['invoice_number']));?> | <?php echo Settings::get('site_name'); ?></title>
    
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

<body class="invoice <?php echo is_admin() ? 'admin' : 'not-admin';?> <?php if ($pdf_mode): ?>pdf_mode pdf<?php else: ?>not-pdf<?php endif;?>">
<?php if(!$pdf_mode): ?>
	<div class="buttonBar">
		<div class="buttonHolders">
            <?php if( ! $is_paid and (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0)){ ?>
            <div id="paypal">
                <a class="button green" href="<?php echo $invoice['partial_payments'][$invoice['next_part_to_pay']]['payment_url']; ?>"><?php if (count($invoice['partial_payments']) > 1) : ?>Pay part #<?php echo $invoice['next_part_to_pay']; ?> of your invoice now<?php else: ?>Proceed to payment<?php endif;?></a>
            </div><!-- /paypal -->
            <?php }?>                 
                
            <div id="pdf">
                <a href="<?php echo site_url('pdf/'.$invoice['unique_id']); ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
            </div><!-- /pdf -->            
		               
            <?php if (is_admin()): ?>
                <?php echo anchor('admin/invoices/'.((isset($is_estimate) and $is_estimate) ? 'estimates' : 'all'), 'Go to Admin &rarr;'); ?>
            <?php endif; ?>
            
            <?php echo anchor(Settings::get('kitchen_route').'/'.$client_unique_id, 'Go to Client Area &rarr;'); ?>
                        
		<?php if ($is_paid) :?>
		    <span class="paidon"><?php echo __('invoices:thisinvoicewaspaidon', array(format_date($invoice['payment_date'])));?></span>
		<?php elseif (!isset($is_estimate)) :?>
		    <span class="paidon"><?php echo __('invoices:thisinvoiceisunpaid');?></span>
		<?php endif;?>
		</div><!-- /buttonHolders -->

	</div><!-- /buttonBar -->
<?php endif; ?>
	<div id="wrapper">
            
        <div id="header">
            <div id="envelope" <?php if (!$pdf_mode):?> style="padding:3em 0 0 0; margin-top: 70px;" <?php endif; ?>>
                <h1><span><?php echo Settings::get('default_invoice_title'); ?></span></h1>        
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
                <td class="invoice-id"><span class="h5">Invoice No:</span> <span><?php echo __($invoice['invoice_number']); ?></span></td>
                <td class="spacer">&nbsp;</td>
                <td class="invoice-date"><span class="h5"><?php echo __('invoices:invoicedate'); ?>:</span> <span><?php echo $invoice['date_entered'] ? format_date($invoice['date_entered']) : '<em>n/a</em>';?></span></td>
                <td class="invoice-due"><span class="h5"><?php echo __('invoices:due'); ?>:</span> <span><?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : 'n/a';?></span></td>
            </tr>
        </table>                
                
        <?php echo $template['body']; ?>
        
		<div id="footer"></div><!-- /footer -->
</div><!-- /wrapper -->



<?php
// ====================
// = Remittence slips =
// ====================
/*
	If you wish to remove this option delete everyting between
	=== PAYMENT SLIP ====
	=== END PAYMENT SLIP ===
*/
?>

<?php // 	=== PAYMENT SLIP ====	 ?>
<?php if($pdf_mode and Settings::get('include_remittance_slip')): ?>
<div style="page-break-before: always;"></div>
<div id="wrapper">
    <div id="header">
        <div id="envelope" class="remittance_slip">
            <table border="0" cellspacing="5" cellpadding="5">
                <tr>
                    <td width="400px">
                        <h2>How to Pay</h2>
                        <p>View invoice online at <?php echo anchor($invoice['unique_id']); ?></p>
                        <p>You may pay in person, online, or by mail using this payment voucher. Please provide your payment information below.<br/>
                        <br/><br/>
                        Enclosed Amount: __________________________________
                        </p>
                    </td>
                    <td width="200px" style="text-align:right">
                        <p>
                            <strong>Invoice #:</strong> <?php echo $invoice['invoice_number'];?><br/>
                            <strong>Total:</strong> <?php echo Currency::format($invoice['total'], $invoice['currency_code']); ?><br/>
                            <strong>Due:</strong> <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>n/a</em>';?>
                        </p>
                     
                        <h3>Mail To:</h3>      
                        <p><span class='site_name'><?php echo Settings::get('site_name'); ?><br /></span><span class="mailing-address"><?php echo nl2br(Settings::get('mailing_address')); ?></span></p>
                    </td>
                 
                </tr>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
<?php // === END PAYMENT SLIP === ?>

</body>
</html>