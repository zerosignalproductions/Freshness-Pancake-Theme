<div class="invoice-block">
	<ul class="btns-list">
		<li>&nbsp;</li>
    </ul><!-- /btns-list end -->

	<div class="head-box">
		<h3 class="ttl ttl3"><?php echo __('Success!'); ?></h3>
	</div>

	<div class="row base-indent">
	<p>You have added a proposal for

		<?php if($proposal['client']->email != ''): ?>
			<a href="mailto:<?php echo $proposal['client']->email;?>"><?php echo $proposal['client']->name;?></a> <?php if($proposal['client']->company != ''){?>, from <?php echo $proposal['client']->company;?>, <?php }?>
		<?php else: ?>
			<?php echo $proposal['client']->name;?> <?php if($proposal['client']->company != ''){?>, from <?php echo $proposal['client']->company;?>, <?php }?>
		<?php endif; ?>

		for the proposal <strong>#<?php echo $proposal['proposal_number'];?></strong>.
	</p>

	
	<p class="urlToSend">Here is the url to send: <a href="<?php echo site_url('proposal/'.$unique_id); ?>" class="url-to-send"><?php echo site_url('proposal/'.$unique_id); ?></a> <a href="#" id="copy-to-clipboard" class="yellow-btn"><span>Copy to clipboard</span></a></p>
        
	</div>
</div>
<div class="invoice-block" id="mailperson">
	<?php if($proposal['client']->email != ''): ?>

	<?php echo form_open('admin/proposals/send/'.$unique_id, 'id="send-proposal"'); ?>
		<input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>" />

		<fieldset>
			
			<div class="head-box">
				<h3 class="ttl ttl3">Send proposal now?</h3>
			</div>
		    <div class="row base-indent">
			<p>Fill out the form below and we'll deliver this proposal for you.</p>
		    </div>
		
			<div class="row base-indent">
				<label for="email"><?php echo __('global:to') ?>: </label><input type="text" id="email" name="email" class="txt" value="<?php echo $proposal['client']->email ?>">
			</div>
			
			<div class="row base-indent">
				<label for="subject"><?php echo __('global:subject') ?>: </label>
				<input type="text" id="subject" name="subject" class="txt" value="<?php echo parse_tags(Settings::get('default_proposal_subject'), array('number' => $proposal['proposal_number'], 'title' => $proposal['title'])); ?>">
			</div>
			<div class="row base-indent">
				<textarea name="message" rows="15" style="height:200px"><?php echo PAN::setting('email_new_proposal'); ?></textarea>
			</div>
			<div class="row base-indent">
				<a href="#" class="yellow-btn" onclick="$('#send-proposal').submit();"><span><?php echo __('global:send_to_client') ?> &rarr;</span></a>
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