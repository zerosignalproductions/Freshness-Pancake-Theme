<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

    <head>
        <title><?php echo __('timesheet:forproject', array($project)); ?> | <?php echo Settings::get('site_name'); ?></title>
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

    <body class="timesheet <?php echo is_admin() ? 'admin' : 'not-admin';?> <?php echo ($pdf_mode) ? 'pdf_mode' : '';?>">
        <?php if( ! $pdf_mode): ?>
        <div class="buttonBar">
            <div class="buttonHolders">
                <div id="pdf">
                    <a href="<?php echo $timesheet_url_pdf; ?>" title="Download PDF" id="download_pdf" class="button">Download PDF</a>
                </div><!-- /pdf -->
                <?php if (logged_in()): ?>
                    <?php echo anchor('admin', 'Go to Admin &rarr;'); ?>
                <?php endif; ?>
                <span class="button-bar-text"><?php echo __('timesheet:for');?> <?php echo $client['company'];?></span>
            </div><!-- /buttonHolders -->
        </div><!-- /buttonBar -->
        <?php endif; ?>
        <div id="wrapper">
                    
            <div id="header">
                <div id="envelope">
                    <h1><span>Timesheet</span></h1>
                    
                    <?php //load the Info Boxes ?>
                    <?php include($this->template->get_theme_path().'views/info.php'); ?>
              
                </div><!-- #envelop -->
            </div><!-- #header -->
            
            <table class="invoice-meta">
                <tr>
                    <td class="invoice-id"><span class="h5"><?php echo __('projects:project');?>:</span> <span><?php echo $project;?></span></td>
                    <td class="spacer">&nbsp;</td>
                    <td class="invoice-date"><span class="h5"><?php echo __('partial:dueon');?>:</span> <span><?php echo $project_due_date ? format_date($project_due_date) : '<em>n/a</em>';?></span></td>
                    <td class="invoice-due"><span class="h5"><?php echo __('timesheet:totalbillable');?>: </strong><?php echo $total_hours;?></span></td>
                </tr>
            </table>                            
                        
            <?php echo $template['body']; ?>
            
            <div id="footer">
            </div><!-- /footer --><!-- /wrapper -->
        </div>
    </body>
</html>