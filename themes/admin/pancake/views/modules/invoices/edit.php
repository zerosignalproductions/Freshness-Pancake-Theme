<script>invoice_unique_id = '<?php echo $invoice->unique_id;?>';</script>
<br /><br />
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl3">
			
				<?php if($invoice->type == 'ESTIMATE'): ?>
					<?php echo __('estimates:editestimate', array($invoice->invoice_number )) ?>
				<?php else: ?>
					<?php echo __('invoices:editinvoice', array($invoice->invoice_number)) ?>
				<?php endif; ?></h3>
	</div><!-- /head-box end -->
	
	<div class="form-holder">
		<?php echo form_open_multipart('admin/invoices/edit/'.$invoice->unique_id, 'id="create-invoice"'); ?>
			<fieldset>

				<div id="invoice-type-block" class="row">
					<label for="nothing">Invoice Type</label>
					<div class="check-holder">
						<?php
						echo form_radio(array(
							'name' => 'type',
							'id' => 'type-simple',
							'value' => 'SIMPLE',
							'checked' => set_radio('type', 'SIMPLE', ($invoice->type == 'SIMPLE'))
						));
						?>
						<label for="type-simple">Simple</label>
						<a href="#" class="more" title="A simple invoice has no line items. Simply a total.">?</a>
					</div>
					<div class="check-holder">
						<?php
						echo form_radio(array(
							'name' => 'type',
							'id' => 'type-detailed',
							'value' => 'DETAILED',
							'checked' => set_radio('type', 'DETAILED', ($invoice->type == 'DETAILED'))
						));
						?>
						<label for="type-detailed">Detailed</label>
						<a href="#" class="more" title="Detaled invoices allow you to have multiple line items.">?</a>
					</div>
					<div class="check-holder">
						<?php
						echo form_radio(array(
							'name' => 'type',
							'id' => 'type-estimate',
							'value' => 'ESTIMATE',
							'checked' => set_radio('type', 'ESTIMATE', ($invoice->type == 'ESTIMATE'))
						));
						?>
						<label for="type-estimate">Estimate</label>
						<a href="#" class="more" title="Estimates are detailed invoices that are not billable.">?</a>
					</div>
				</div><!-- /info-type-block end -->

				<div class="row">
					<label for="invoice_number">Invoice #</label>
					<?php echo form_input('invoice_number', set_value('invoice_number', $invoice->invoice_number), 'id="invoice_number" class="txt"'); ?>
				</div>
				
				<div class="row">
				    <label for="date_entered"><?php echo __('invoices:date_entered');?></label>
				    <?php echo form_input('date_entered', set_value('date_entered', format_date($invoice->date_entered)), 'id="date_entered" class="text txt datePicker"'); ?>
			    </div>
				
				<div class="row">
					<label for="is_recurring"><?php echo __('invoices:is_viewable') ?></label>
					<div class="sel-item">
						<?php echo form_dropdown('is_viewable', array(__('global:no'), __('global:yes')), set_value('is_viewable', $invoice->is_viewable), 'id="is_viewable"'); ?>
					</div>
				</div>

				<?php if (!$invoice->is_recurring or ($invoice->recur_id == $invoice->id)) :?>
				<div class="row">
					<label for="is_recurring">Recurring?</label>
					<div class="sel-item">
						<?php echo form_dropdown('is_recurring', array(__('global:no'), __('global:yes')), set_value('is_recurring', $invoice->is_recurring), 'id="is_recurring"'); ?>
					</div>
				</div>

				<div id="recurring-options" style="display:none">
<div class="row">
                                    <label>&nbsp;</label>
                                    <p class="description"><?php echo __('global:you_need_pancake_cron_job')?><br /><?php echo __('global:if_you_dont_know_how_to_set_it_up')?></p>
                                </div>
					<div class="row">
						<label for="frequency">Frequency</label>
						<div class="sel-item">
                                                    <?php echo form_dropdown('frequency', array('w' => __('global:week'), 'm' => __('global:month'), 'q' => __('global:quarterly'), 's' => __('global:every_six_months'), 'y' => __('global:year'), 'b' => __('global:biyearly'),), set_value('frequency', $invoice->frequency), 'id="frequency"'); ?>
						</div>
					</div>

					<div class="row">
						<label for="auto_send">Auto Send?</label>
						<div class="sel-item">
							<?php echo form_dropdown('auto_send', array('No', 'Yes'), set_value('auto_send', $invoice->auto_send), 'id="auto_send"'); ?>
						</div>
					</div>
                                    
                                    <div class="row">
						<label for="send_x_days_before">Send</label>
							<?php echo form_input('send_x_days_before', set_value('send_x_days_before', $invoice->send_x_days_before), 'id="send_x_days_before" class="text txt"'); ?>
                                                <label class="send_x_days_before_label">days before invoice is due</label>
					</div>
				</div>
				<?php else:?>
				    <div class="row">
						<label>Recurring?</label>
						<label class="cannot_change_recurrence_settings">You cannot change the recurrence settings of an invoice that is a recurrence of another invoice.</label>
					</div>
				<?php endif;?>

				<input type="hidden" name="due_date" value="0" />

				<div class="row">
					<label for="lb06">Client</label>
					<div class="sel-item">
						<?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', $invoice->client_id), 'id="client"'); ?>
					</div>
					<a href="<?php echo site_url('admin/clients/create'); ?>" title="Add client" class="yellow-btn"><span>Add a Client</span></a>
				</div><!-- /row end -->

				<div class="row">
				<label for="description"><?php echo __('global:description') ?></label>
					<?php
						echo form_textarea(array(
							'name' => 'description',
							'id' => 'description',
							'value' => set_value('description', $invoice->description),
							'rows' => 4,
							'cols' => 50
						));
					?>
				</div><!-- /row end -->
				<div id="DETAILED-wrapper" class="type-wrapper row">
					<label for="nothing">Line Items</label>
					<table class="pc-table" id="invoice-items" style="width: 702px">
						<thead>
							<tr>
								<th style="width: 187px;"><?php echo __('items:name') ?></th>
								<th style="width: 77px;"><?php echo __('items:qty_hrs') ?></th>
								<th style="width: 97px;"><?php echo __('items:rate') ?></th>
								<th style="width: 155px;"><?php echo __('items:tax_rate') ?></th>
								<th style="width: 54px; padding: 0; text-align: center;"><?php echo __('items:cost') ?></th>
								<th style="padding: 0; text-align: center;"><?php echo __('global:actions') ?></th>
							</tr>
						</thead>
						<tbody class="make-it-sortable">
						<?php foreach ($invoice->items as $item): ?>
						    
						    <tr>
						<td colspan="6">
						    <table>
						    
							<tr class="details">
								<td><input type="text" name="invoice_item[name][]" class="item_name txt small" style="width: 150px" value="<?php echo form_prep($item['name']); ?>" /></td>
								<td><input type="text" name="invoice_item[qty][]" value="<?php echo $item['qty']; ?>" class="item_quantity txt small" style="width: 40px" /></td>
								<td><input type="text" name="invoice_item[rate][]"  value="<?php echo $item['rate']; ?>" class="item_rate txt small" style="width: 60px" /></td>
								<td align="center" class="tax-dropdown"><?php echo form_dropdown('invoice_item[tax_id][]', Settings::tax_dropdown(), isset($item['tax_id']) ? $item['tax_id'] : 0, 'class="tax_id"'); ?></td>
								<td>
									<input type="hidden" name="invoice_item[total][]" value="<?php echo number_format($item['total'], 2); ?>" class="item_cost" />
									<span class="item_cost"><?php echo number_format($item['total'], 2); ?></span>
								</td>
								<td class="actions" rowspan="2">
									<a href="#" class="icon sort" style="margin:0; cursor:move;" title="<?php echo __('global:sort') ?>"><?php echo __('global:sort') ?></a>
									<a href="#" class="icon delete" style="margin:0;"><?php echo __('global:remove') ?></a>
								</td>
							</tr>
							<tr class="description">
								<td colspan="5">
									<textarea name="invoice_item[description][]" class="item_description txt small" style="margin: 5px 0; width: 580px; height:3em" rows="2"><?php echo $item['description']; ?></textarea>
								</td>
							</tr>
							
							</table></td></tr>
							
						<?php endforeach; ?>

						</tbody>
					</table>

					<div class="btns-holder" style="margin-left: 160px">
						<ul class="btns-list">
							<li><a class="yellow-btn" href="#" id="add-row"><span><?php echo __('items:add') ?></span></a></li>
						</ul><!-- /btns-list end -->
					</div><!-- /btns-holder end -->
				</div><!-- /row end -->
				<div class="row">
					<label for="lb08"><?php echo __('global:notes') ?></label>
					<div class="textarea">
						<?php
							echo form_textarea(array(
								'name' => 'notes',
								'id' => 'notes',
								'value' => set_value('notes', $invoice->notes),
								'rows' => 4,
								'cols' => 50
							));
						?>
					</div>
				</div><!-- /row end -->
				<div class="row">
					<label for="nothing">Files</label>
					<table class="pc-table" style="width: 702px">
						<thead>
							<tr>
								<th>File Name</th>
								<th>Date Created</th>
								<th>Size</th>
								<th>Remove?</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($files as $file): ?>
							<tr>
								<td><a href="<?php echo site_url('uploads/'.$file['real_filename']); ?>" target="_blank"><?php echo $file['orig_filename']; ?></a></td>
								<td><?php echo date("M d, Y h:i:s a", filemtime('uploads/'.$file['real_filename'])); ?></td>
								<td><?php echo filesize('uploads/'.$file['real_filename']); ?></td>
								<td style="text-align: center"><input type="checkbox" name="remove_file[]" class="remove_file" value="<?php echo $file['id']; ?>" /></td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
					<div style="margin-left: 160px">
						<ul id="file-inputs">
							<li><?php echo form_upload('invoice_files[]'); ?></li>
						</ul><!-- /file-select end -->
						<br style="clear:both" />
						<div class="submit-holder">
							<div>
								<a class="yellow-btn" href="#" id="add-file-input"><span>Add More</span></a>
							</div>
						</div>
					</div>
				</div><!-- /row end -->
				<div id="SIMPLE-wrapper" class="type-wrapper row">
					<label for="amount"><?php echo __('invoices:amount') ?> (<?php echo $invoice->currency_code ? $invoice->currency_code : Currency::symbol(); ?>)</label>
					<?php echo form_input('amount', set_value('amount', $invoice->amount), 'class="txt"'); ?>
				</div><!-- /row end -->

   				<div class="gateway-items row">
	                <?php $this->load->view('invoices/partial_input_container', array('action' => 'edit', 'currency_code' => $invoice->currency_code,  'parts' => isset($invoice->partial_payments[1]) ? $invoice->partial_payments : array('key' => 1))); ?>
	                <?php require_once APPPATH.'modules/gateways/gateway.php'; ?>
				
	                <label><?php echo lang('gateways:paymentmethods')?></label>

	                <?php if ( ! empty($gateways)) : ?>
	                    <?php $checked = Gateway::get_item_gateways('INVOICE', $invoice->id); ?>
	                    <?php $first = true; foreach ($gateways as $gateway) : ?>
	                    <div class="gateway <?php echo !$first ? 'not-first' : null; ?>">
	                        <input type="checkbox" name="gateways[<?php echo $gateway['gateway'];?>]" id="gateways-<?php echo $gateway['gateway'];?>" <?php echo $checked[$gateway['gateway']] ? 'checked="checked"' : '';?> value="1" />
	                        <label for="gateways-<?php echo $gateway['gateway'];?>"><?php echo $gateway['title'];?></label>
	                   </div>
                    <?php $first = false; endforeach; ?>
               
                <?php else: ?>
					<p><?php echo __('invoices:no_payment_gateways_enabled', array(site_url('admin/settings'))) ?></p>
				<?php endif; ?>
				 </div>
				<div class="row">
					<label for="nothing">&nbsp;</label>
					<a href="#" class="yellow-btn" onclick="$('#create-invoice').submit();"><span><?php echo __('global:save'); ?>&rarr;</span></a>
				</div>
			</fieldset>
            <input type="submit" class="hidden-submit" />
		<?php echo form_close(); ?>

	</div>
</div>
<br style="clear: both;" />
<?php
//	asset::js('jhtmlarea-0.7.0.min.js', array(), 'invoice');
	asset::js('invoice-form.js', array(), 'invoice');
//	asset::css('jHtmlArea.css', array(), 'invoice');
	echo asset::render('invoice');
?>