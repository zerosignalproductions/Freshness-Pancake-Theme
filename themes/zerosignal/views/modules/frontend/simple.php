<div id="content"><?php echo logo(false, false);?>
	<h2>Hi <?php echo $invoice['first_name'].' '.$invoice['last_name'];?></h2>

	<?php if (count($invoice['partial_payments']) == 1 and $invoice['partial_payments'][1]['due_date'] != 0) : ?>

		<p>
			Your invoice #<?php echo $invoice['invoice_number'];?> totaling <?php echo Currency::format($invoice['amount'], $invoice['currency_code']);?>
			<?php echo ($invoice['partial_payments'][1]['over_due']) ? 'was' : 'is'; ?> due on <?php echo format_date($invoice['partial_payments'][1]['due_date']);?>
		</p>

	<?php else: ?>
	
		<p>
			Your invoice #<?php echo $invoice['invoice_number'];?> totals <?php echo Currency::format($invoice['amount'], $invoice['currency_code']);?>.
		</p>
	
	<?php endif; ?>
                
                <?php if (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0) : ?>
                    <?php if (count($invoice['partial_payments']) > 1) : ?>
                    <h3>Payment Plan</h3>
                    <ol>
                        <?php foreach ($invoice['partial_payments'] as $part) : ?>
                            <li>
                                <h4><?php echo Currency::format($part['billableAmount'], $invoice['currency_code']); ?> <?php if ($part['due_date'] != 0) : ?>due on <?php echo format_date($part['due_date']); ?><?php endif; ?> <?php echo (empty($part['notes'])) ? '' : $part['notes']; ?></h4>
                                <?php if (!$part['is_paid']) : ?>
                                        <?php echo anchor($part['payment_url'], 'Proceed to payment', 'class="simple-button"'); ?>
                                <?php else: ?>
                                <p>This part of your invoice's payment has been paid. Thank You.</p>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                    <?php else: ?>
                        <?php if ( ! $is_paid): ?>
                                <?php echo anchor($invoice['partial_payments'][1]['payment_url'], 'Proceed to payment', 'class="simple-button"'); ?>
                        <?php else: ?>
                            <p>This invoice has been paid.  Thank You.</p>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif;?>
 
	<?php if ($invoice['description'] != ''): ?>
		<div id="description">
			<h3>Description</h3>
			<p><?php echo $invoice['description']; ?></p>
		</div><!-- /description -->
	<?php endif; ?>

	<?php if ($invoice['notes'] != ''): ?>
		<div id="notes">
			<h3>Notes</h3>
			<p><?php echo $invoice['notes']; ?></p>
		</div><!-- /notes -->
	<?php endif; ?>

	<?php if ( ! empty($files)): ?>
	<div id="files">
		<h3>Files for Download</h3>
		<?php if ( ! $is_paid): ?>
			<p>These files will be available for download once the invoice has been fully paid.</p>
		<?php endif; ?>
			<ol class="fileList">
			<?php foreach ($files as $file): ?>
			<?php if ($is_paid): ?>
				<li><?php echo anchor('files/download/'.$invoice['unique_id'].'/'.$file['id'], $file['orig_filename']); ?></li>
			<?php else: ?>
				<li><?php echo $file['orig_filename']; ?></li>
			<?php endif; ?>
			<?php endforeach; ?>
			</ol>
	</div><!-- /file -->
	<?php endif; ?>
</div><!-- /content -->