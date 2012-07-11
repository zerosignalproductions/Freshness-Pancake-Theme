<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<link href='//fonts.googleapis.com/css?family=Cabin:400,700&subset=latin&v2' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Copse&subset=latin&v2' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css'>

<?php if (Settings::get('frontend_css')): ?>
	<style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
<?php endif; ?>

</head>

<body class="invoice <?php echo is_admin() ? 'admin' : 'not-admin';?> <?php if ($pdf_mode): ?>pdf_mode pdf<?php else: ?>not-pdf<?php endif;?>">
<?php if( ! $pdf_mode): ?>
	<div id="buttonBar">

		<div id="buttonHolders">
		    
		<?php if (is_admin()): ?>
			<?php echo anchor('admin/invoices/'.((isset($is_estimate) and $is_estimate) ? 'estimates' : 'all'), 'Go to Admin &rarr;', 'class="button"'); ?>
		<?php endif; ?>
		    <?php echo anchor(Settings::get('kitchen_route').'/'.$client_unique_id, 'Go to Client Area &rarr;', 'class="button"'); ?>
		<div id="pdf">
			<a href="<?php echo site_url('pdf/'.$invoice['unique_id']); ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
		</div><!-- /pdf -->

		<?php if( ! $is_paid and (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0)){ ?>
		<div id="paypal">
        	<a href="<?php echo $invoice['partial_payments'][$invoice['next_part_to_pay']]['payment_url']; ?>" class="button"><?php if (count($invoice['partial_payments']) > 1) : ?>Pay part #<?php echo $invoice['next_part_to_pay']; ?> of your invoice now<?php else: ?>Proceed to payment<?php endif;?></a>
		</div><!-- /paypal -->
		<?php }?>
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
			<div id="envelope" <?php if (!$pdf_mode):?> style="padding:60px 0 0 0" <?php endif; ?>>
				<table cellspacing="0" cellpadding="0" style="padding: 0 0px;">
					<tr>
						<td style="text-align:left;vertical-align:<?php echo (logo(true, false) != '') ?  "top" :  "bottom"; ?>;" id="company-info-holder">
							<?php echo logo(false, false, 2);?>
							<p><?php echo nl2br(Settings::get('mailing_address')); ?></p>	
              			</td>

 						<td width="300px" style="text-align:right; vertical-align:top;" class="tight" id="invoice-details-holder">
							<div id="details-wrap">
								<p><?php echo __('invoices:invoicenumber', array($invoice['invoice_number']));?>
								<h2><?php echo Settings::get('default_invoice_title'); ?></h2>
                                                                <p><?php echo __('invoices:invoicedate'); ?>: <?php echo $invoice['date_entered'] ? format_date($invoice['date_entered']) : '<em>n/a</em>';?></p>
								<p><?php echo __('invoices:due'); ?>: <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>n/a</em>';?></p>
			                    <?php if($invoice['is_paid'] == 1): ?>
			                    <span class="paidon"><?php echo __('invoices:paidon', array(format_date($invoice['payment_date'])));?></span>
			                      <?php endif; ?>
				                  </p>
							</div><!-- /details-wrap -->	
						</td>
					</tr>
				</table>
			</div><!-- /envelope -->


			<div id="clientInfo">
            <div id="billing-info">
              <table cellspacing="0" cellpadding="0" id="billing-table">
                <tr>
                  <td width="240px" style="vertical-align:top;">
					<h2><?php echo $invoice['company'];?></h2>
                    <p><?php echo $invoice['first_name'].' '.$invoice['last_name'];?><br />
                  <?php echo nl2br($invoice['address']);?></p></td>
                  <td width="<?php echo (!$pdf_mode)? "560px" : "300px" ?>"  style="vertical-align:top;">
						<?php if ( ! empty($invoice['description'])): ?>
						<h3><?php echo __('global:description');?>:</h3>
						<?php echo auto_typography($invoice['description']);?>
						<?php endif; ?>
					</td>
                </tr>
              </table>
              <br /> <br />
            </div>
		  </div><!-- /clientInfo -->



		</div><!-- /header -->
<?php echo $template['body']; ?>
		<div id="footer">

		</div><!-- /footer -->
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