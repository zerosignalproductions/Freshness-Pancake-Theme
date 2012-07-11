<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
				<div id="pdf">
					<a href="<?php echo site_url('pdf/'.$invoice['unique_id']); ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
				</div><!-- /pdf -->

				
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
										<p><?php echo __('estimates:estimatenumber', array($invoice['invoice_number']));?>
										<h2><?php echo __('global:estimate'); ?></h2>
										<p><?php echo __('invoices:due'); ?>: <?php echo $invoice['due_date'] ? format_date($invoice['due_date']) : '<em>n/a</em>';?></p>
					                    
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

</body>
</html>