<div class="invoice-block">
	<ul class="btns-list">
		<li>&nbsp;</li>
    </ul><!-- /btns-list end -->

	<div class="head-box">
		<h3 class="ttl ttl3"><?php echo __('Success!'); ?></h3>
	</div>

	<div class="row base-indent">
	<p>
		
		<?php if($invoice->type == 'ESTIMATE'): ?>
			<?php echo __('estimates:addedconf', array($invoice->invoice_number, 
													Currency::format($invoice->amount, $invoice->currency_code), 
													($invoice->email != '') ? "<a href=\"mailto:$invoice->email  \">" . $invoice->first_name . " ". $invoice->last_name . "</a>" : $invoice->first_name . " ". $invoice->last_name, 
													($invoice->company != '') ? ", " . __('global:from') . " " .$invoice->company : '' )) ?>
		<?php else: ?>
			<?php echo __('invoices:addedconf', array($invoice->invoice_number, 
													Currency::format($invoice->amount, $invoice->currency_code), 
													($invoice->email != '') ? "<a href=\"mailto:$invoice->email  \">" . $invoice->first_name . " ". $invoice->last_name . "</a>" : $invoice->first_name . " ". $invoice->last_name, 
													($invoice->company != '') ? ", " . __('global:from') . " " .$invoice->company : '' )) ?>
		<?php endif; ?>
		
	</p>

	<p class="urlToSend"><?php echo __('global:urltosend') ?> <a href="<?php echo site_url($unique_id); ?>" class="url-to-send"><?php echo site_url($unique_id); ?></a> <a href="#" id="copy-to-clipboard" class="yellow-btn"><span><?php echo __('global:copytoclipboard') ?></span></a></p>
        
	</div>
</div>

<div class="invoice-block">

	<div class="row base-indent">
		<p><a href="<?php echo site_url('/admin/'.($invoice->type == 'ESTIMATE' ? 'estimates' : 'invoices').'/edit/'.$unique_id); ?>"  class="yellow-btn" style="margin-right:20px"><span><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:edit' : 'invoices:edit') ?></span></a> 
			<a href="<?php echo site_url($unique_id); ?>"  class="yellow-btn"><span><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:preview' : 'invoices:preview') ?></span></a></p>
	</div>
	
</div>

<div class="invoice-block" id="mailperson">
	<?php if($invoice->email != ''): ?>

	<?php echo form_open('admin/invoices/send/'.$unique_id, 'id="send-invoice"'); ?>
		<input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>" />

		<fieldset>
			
			<div class="head-box">
				<h3 class="ttl ttl3"><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:send_now_title' : 'invoices:send_now_title') ?></h3>
			</div>
			<div class="row base-indent"><p><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:send_now_body' : 'invoices:send_now_body') ?></p>
				
			<div class="row base-indent">
				<label for="email"><?php echo __('global:to') ?>: </label><input type="text" id="email" name="email" class="txt" value="<?php echo $invoice->email; ?>">
			</div>
			
			<div class="row base-indent">
				<label for="subject"><?php echo __('global:subject') ?>: </label><input type="text" id="subject" name="subject" class="txt" value="<?php echo parse_tags(Settings::get('default_'.($invoice->type == 'ESTIMATE' ? 'estimate' : 'invoice').'_subject'), array('number' => $invoice->invoice_number)); ?>">
			</div>
			
			<div class="row base-indent">
				<textarea name="message" rows="15" style="height:200px"><?php echo PAN::setting($invoice->type == 'ESTIMATE' ? 'email_new_estimate' : 'email_new_invoice'); ?></textarea>
			</div>
			<div class="row base-indent">
				<a href="#" class="yellow-btn" onclick="$('#send-invoice').submit();"><span><?php echo __($invoice->type == 'ESTIMATE' ? 'estimates:send_now' : 'invoices:send_now') ?> &rarr;</span></a>
			</div>
			

		</fieldset>
	</form>
	<?php endif;?>
</div>
<?php
asset::js('jquery.zclip.min.js', array(), 'created');
echo asset::render('created');
?>
<script>
    $('a#copy-to-clipboard').click(function() {return false;}).zclip({
        path: '<?php echo asset::get_src('ZeroClipboard.swf')?>',
        copy: $('.url-to-send').text(),
        afterCopy:function(){
            $('.url-to-send').width($('.url-to-send').width()).text('<?php echo __('global:copied');?>');
        }
    });
</script>