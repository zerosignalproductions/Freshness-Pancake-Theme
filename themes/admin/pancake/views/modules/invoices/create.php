<?php $_POST = reconvert_dates($_POST); ?>
<script>invoice_unique_id = '<?php echo $unique_id;?>';</script>
<?php if (!isset($iframe) or !$iframe) :?><br /><br /><?php endif;?>
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl3"><?php echo isset($estimate) ? lang('estimates:createnew') : lang('invoices:newinvoice'); ?></h3>
	</div><!-- /head-box end -->
	<div class="form-holder">
		<?php echo form_open_multipart('admin/invoices/create/'.((!isset($iframe) or !$iframe) ? '' : 'iframe'), 'id="create-invoice"'); ?>
	    <input type="hidden" name="unique_id" value="<?php echo $unique_id;?>">
		<fieldset>

			<div id="invoice-type-block" class="row">
				<label for="nothing"><?php echo lang('invoices:type') ?></label>
				<div class="check-holder">
					<?php
					echo form_radio(array(
						'name' => 'type',
						'id' => 'type-simple',
						'value' => 'SIMPLE',
						'checked' => set_radio('type', 'SIMPLE')
					));
					?>
					<label for="type-simple"><?php echo __('invoices:simple') ?></label>
					<a href="#" class="more" title="<?php echo __('invoices:simple_help') ?>">?</a>
				</div>
				<div class="check-holder">
					<?php
					echo form_radio(array(
						'name' => 'type',
						'id' => 'type-detailed',
						'value' => 'DETAILED',
						'checked' => set_radio('type', 'DETAILED', TRUE) OR isset($project)
					));
					?>
					<label for="type-detailed"><?php echo __('invoices:detailed') ?></label>
					<a href="#" class="more" title="<?php echo __('invoices:detailed_help') ?>">?</a>
				</div>
				<div class="check-holder">
					<?php
					echo form_radio(array(
						'name' => 'type',
						'id' => 'type-estimate',
						'value' => 'ESTIMATE',
						'checked' => set_radio('type', 'ESTIMATE') OR isset($estimate)
					));
					?>
					<label for="type-estimate"><?php echo __('global:estimate') ?></label>
					<a href="#" class="more" title="<?php echo __('invoices:estimate_help') ?>">?</a>
				</div>
			</div><!-- /info-type-block end -->

			<div class="row hide-estimate">
				<label for="invoice_number">Invoice #</label>
				<?php echo form_input('invoice_number', set_value('invoice_number', isset($invoice_number) ? $invoice_number : ''), 'id="invoice_number" class="txt"'); ?>
			</div>
			
			<div class="row">
				<label for="date_entered"><?php echo __('invoices:date_entered');?></label>
				<?php echo form_input('date_entered', set_value('date_entered', format_date(time())), 'id="date_entered" class="text txt datePicker"'); ?>
			</div>
			
			<div class="row">
				<label for="is_recurring"><?php echo __('invoices:is_viewable') ?></label>
				<div class="sel-item">
					<?php echo form_dropdown('is_viewable', array(__('global:no'), __('global:yes')), set_value('is_viewable'), 'id="is_viewable"'); ?>
				</div>
			</div>

			<div class="row hide-estimate">
				<label for="is_recurring"><?php echo __('invoices:is_recurring') ?></label>
				<div class="sel-item">
					<?php echo form_dropdown('is_recurring', array(__('global:no'), __('global:yes')), set_value('is_recurring'), 'id="is_recurring"'); ?>
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
						<?php echo form_dropdown('frequency', array('w' => __('global:week'), 'm' => __('global:month'), 'q' => __('global:quarterly'), 's' => __('global:every_six_months'), 'y' => __('global:year'), 'b' => __('global:biyearly'),), set_value('frequency', 'm'), 'id="frequency"'); ?>
					</div>
				</div>

				<div class="row">
					<label for="auto_send">Auto Send?</label>
					<div class="sel-item">
						<?php echo form_dropdown('auto_send', array(__('global:no'), __('global:yes')), set_value('auto_send', 1), 'id="auto_send"'); ?>
					</div>
				</div>
                            
                    <div class="row">
					<label for="send_x_days_before">Send</label>
						<?php echo form_input('send_x_days_before', set_value('send_x_days_before', Settings::get('send_x_days_before')), 'id="send_x_days_before" class="text txt"'); ?>
                        <label class="send_x_days_before_label">days before invoice is due</label>
					</div>
			</div>
                        
                        <input type="hidden" name="due_date" value="0" />
                        
                        <?php if (!isset($iframe) or !$iframe) :?>
			<div class="row">
				<label for="lb06">Client</label>
				<div class="sel-item">
					<?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', isset($client_id) ? $client_id : (isset($project) ? (int) $project->client_id : '')), 'id="client"'); ?>
				</div>
				<a href="<?php echo site_url('admin/clients/create'); ?>" title="Add client" class="yellow-btn"><span>Add a Client</span></a>
			</div><!-- /row end -->
                        <?php else: ?>
                            <input type="hidden" name="client_id" value="<?php echo (isset($client_id) ? $client_id: ''); ?>">
                        <?php endif;?>

			<div class="row">
				<label for="currency">Currency</label>
				<div class="sel-item">
                	<select id="currency" name="currency">
	                    <?php foreach ($currencies as $code => $currency) : ?>
	                        <?php $selected = (isset($project) and $project->currency_id == $code) ? true : (($code == '0') ? true : false); ?>
	                        <option value="<?php echo $code;?>" data-symbol="<?php echo Currency::symbol($code);?>" <?php echo set_select('currency', $code, $selected); ?>><?php echo $currency;?></option>
	                    <?php endforeach; ?>
	                </select>
				</div>
			</div>
			
            <?php if (!isset($iframe) or !$iframe) :?>
			<div class="row">
				<label for="description"><?php echo __('global:description') ?></label>
				<?php
					echo form_textarea(array(
						'name' => 'description',
						'id' => 'description',
						'value' => set_value('description', isset($project) ? $project->description : ''),
						'rows' => 4,
						'cols' => 50
					));
				?>
			</div><!-- /row end -->
			
            <?php else: ?>
                <input type="hidden" name="description" value="">
            <?php endif;?>

			<div id="DETAILED-wrapper" class="type-wrapper row">
				<label for="nothing"><?php echo __('items:line_items') ?></label>
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
					<?php foreach ($items as $item): ?>
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
								
									<?php 
										if ( ! empty($item['entries'])):
										foreach ($item['entries'] as $entry): 
									 	echo form_hidden('entries[][]', $entry->id);
										endforeach;
										endif;
									?>
							    </td>
							    <td class="actions" rowspan="2">
								    <a href="javascript:void(0)" class="icon sort" style="margin:0; cursor:move;" title="<?php echo __('global:sort') ?>"><?php echo __('global:sort') ?></a>
								    <a href="javascript:void(0)" class="icon delete" style="margin:0;"><?php echo __('global:remove') ?></a>
							    </td>
							</tr>	
							<tr class="description">
								<td colspan="5">
									<textarea name="invoice_item[description][]" class="item_description txt small" style="margin: 5px 0; width: 580px; height:3em" rows="2"><?php echo $item['description']; ?></textarea>
								</td>
							</tr>
						    </table>
						</td>
					    </tr>
						
					<?php endforeach; ?>

					</tbody>
				</table>

					<div class="btns-holder" style="margin-left: 160px">
						<ul class="btns-list">
							<li><a class="yellow-btn" href="#" id="add-row"><span><?php echo __('items:add') ?></span></a></li>
						</ul><!-- /btns-list end -->
					</div><!-- /btns-holder end -->
				</div><!-- /row end -->
                
				<?php if (!isset($iframe) or !$iframe) :?>
				<div class="row">
					<label for="lb08"><?php echo __('global:notes') ?></label>
					<div class="textarea">
						<?php
							echo form_textarea(array(
								'name' => 'notes',
								'id' => 'notes',
								'value' => set_value('notes', Settings::get('default_invoice_notes')),
								'rows' => 4,
								'cols' => 50
							));
						?>
					</div>
				</div><!-- /row end -->
                <?php else: ?>
                	<input type="hidden" name="notes" value="">
                <?php endif;?>

				<div class="row hide-estimate">
					<label for="nothing">Files</label>
					<table class="pc-table" style="width: 702px">
						<thead>
							<tr>
								<th>File Name</th>
								<th>Date Created</th>
								<th>Size</th>
							</tr>
						</thead>
						<tbody>
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
					<label for="amount">Amount (<span id="symbol"><?php echo Currency::symbol(); ?></span>)</label>
					<?php echo form_input('amount', set_value('amount'), 'class="txt"'); ?>
				</div><!-- /row end -->
                                <?php $this->load->view('invoices/partial_input_container', array('action' => 'create', 'parts' => array('key' => 1))); ?>
             
   				<div class="gateway-items row">
                    <?php require_once APPPATH.'modules/gateways/gateway.php'; ?>
                    <?php $checked = Gateway::get_item_gateways('INVOICE', 0); ?>
                    
					<label><?php echo lang('gateways:paymentmethods')?></label>
					
					<?php if ($gateways): ?>
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
					<a href="#" class="yellow-btn" onclick="$('#create-invoice').submit(); return false;"><span><?php echo __('global:save') ?> &rarr;</span></a>
				</div>
			</fieldset>
            <input type="submit" class="hidden-submit" />
		<?php echo form_close(); ?>
	</div><!-- /form-holder end -->
</div><!-- /invoice-block end -->
<br style="clear: both;" />

<script type="text/javascript">
	$('select#currency').change(function(){
		$('span#symbol, .currencySymbol').html(this.value != 0 ? this.value : '<?php echo Currency::symbol(); ?>');
	}).change();
</script>

<?php
//	asset::js('jhtmlarea-0.7.0.min.js', array(), 'invoice');
asset::js('invoice-form.js', array(), 'invoice');
//	asset::css('form.css', array(), 'invoice');
//	asset::css('jHtmlArea.css', array(), 'invoice');
echo asset::render('invoice');
?>