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
        
        <?php /*
        <div id="header">
            <div id="envelope" <?php if (!$pdf_mode):?> style="padding:60px 0 0 0" <?php endif; ?>>
                <h1><span><?php echo __('global:estimate'); ?></span></h1>
            
                <table cellspacing="0" cellpadding="0" style="padding: 0 0px;">
                    <tr>
                        <td style="text-align:left;vertical-align:<?php echo (logo(true, false) != '') ?  "top" :  "bottom"; ?>;" id="company-info-holder">
                            <?php echo logo(false, false, 2);?>
                            <p><?php echo nl2br(Settings::get('mailing_address')); ?></p>	
                        </td>

                        <td width="300px" style="text-align:right; vertical-align:top;" class="tight" id="invoice-details-holder">
                            <div id="details-wrap">
                                <p><?php echo __('estimates:estimatenumber', array($invoice['invoice_number']));?>
                                
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

        </div><!-- /header --> */ ?>
        
        

		<div id="header">
			<div id="envelope" <?php if (!$pdf_mode):?> style="padding:3em 0 0 0; margin-top: 70px;" <?php endif; ?>>
                <h1><span><?php echo __('global:estimate'); ?></span></h1>
                
                <?php /* <table class="title">
                    <tr>
                        <td class="spacer">&nbsp;</td>
                        <td class="invoice-title"><h1><span><?php echo Settings::get('default_invoice_title'); ?></span></h1></td>
                        <td class="spacer">&nbsp;</td>
                    </tr>
                </table>  */ ?>               
                <table class="invoice-contact">
                    <tr class="row">
                        <td id="company-info-holder">
                            <ul class="info">
                                <li class="logo"><?php echo logo(false, false, 2);?></li>
                                <li class="address"><h5>Address:</h5> <?php echo nl2br(Settings::get('mailing_address')); ?></li>
                                <li class="phone"><h5>Phone:</h5> 512-552-1536</li>
                                <li class="email"><h5>Email:</h5> <?php echo nl2br(Settings::get('notify_email')); ?></li>
                                <li class="fax"><h5>Fax:</h5> 555-555-5555</li>
                            </ul>
                        </td>
        
                        <td id="invoice-details-holder">
                            <div id="clientInfo">
                                <div id="billing-info">
                                    <ul class="info">
                                        <?php if($invoice['company']): ?>
                                            <li class="logo"><h2><?php echo $invoice['company'];?></h2></li>
                                        <?php endif; ?>
                                        <li class="address"><h5>Address: </h5><?php echo nl2br($invoice['address']);?></li>
                                        <li><h5>Contact: </h5> <?php echo $invoice['first_name'].' '.$invoice['last_name'];?></li>
                                        <li class="email"><h5>Email:</h5> <?php echo $invoice['email']; ?></li>
                                        <li class="phone"><h5>Phone:</h5> <?php echo $invoice['phone']; ?></li>
                                    </ul>
                                </div>
                            </div><!-- /clientInfo -->
                        </td>                        
                    </tr>
                </table>
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

		<div id="footer">

		</div><!-- /footer -->

	</div><!-- /wrapper -->

</body>
</html>