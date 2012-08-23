<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>

<title><?php echo $title;?> | <?php echo Settings::get('site_name'); ?></title>

<!--favicon-->
<link rel="shortcut icon" href="" />

<!--metatags-->
<meta name="robots" content="noindex,nofollow" />
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<!-- CSS -->
<?php echo asset::css('invoice_style.css', array('media' => 'all'), NULL, $pdf_mode); ?>

<?php if (Settings::get('frontend_css')): ?>
	<style type="text/css"><?php echo Settings::get('frontend_css'); ?></style>
<?php endif; ?>

</head>

<body class="report <?php echo is_admin() ? 'admin' : 'not-admin';?> <?php echo $pdf_mode ? 'pdf pdf_mode' : 'not-pdf';?>">
    <?php if( ! $pdf_mode): ?>
        <div id="buttonBar">
            <div id="buttonHolders">
            <?php if (is_admin()): ?>
                <?php echo anchor('admin', 'Go to Admin &rarr;'); ?>
            <?php endif; ?>
            
            <div id="pdf">
                <a href="<?php echo $report_url_pdf; ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
            </div><!-- /pdf -->
            </div><!-- /buttonHolders -->
        </div><!-- /buttonBar -->
    <?php endif; ?>
	<div id="wrapper">
		<div id="header">
			<div id="clientInfo">
            <div id="envelope2">
              <table cellspacing="5" cellpadding="5">
                <tr>
                  <td width="310px" style="vertical-align:top;"><h2><?php echo $title;?></h2></td>
                  <td width="310px" style="text-align:right;vertical-align:top;">
                      <?php echo logo(false, false, 2);?>
                    <p><?php echo nl2br(Settings::get('mailing_address')); ?></p>
                  </td>
                </tr>
              </table>
              <br /> <br />
            </div>
		  </div><!-- /clientInfo -->
		</div><!-- /header -->
        
        <?php echo $template['body']; ?>
		
        <div id="footer">

		</div><!-- /footer --><!-- /wrapper -->
</div>
</body>
</html>