<div class="invoice-block">
	
	<div class="head-box">
		<h3 class="ttl ttl3"><?php echo lang('invoices:all') ?></h3>
	</div>
	
	<div class="filters">
		<div class="form-holder">
			<?php echo form_open(uri_string()); ?>
			<fieldset>
				<div class="row">
					<label for="client_id"><?php echo lang('clients:filter') ?>:</label>
					<div class="sel-item"><?php echo form_dropdown('client_id', $clients_dropdown, $client_id, 'onchange="this.form.submit()"'); ?></div>
				</div><!-- /row -->
			</fieldset>
			<?php echo form_close(); ?>
		</div><!-- /form-holder -->
	</div><!-- /filters -->
</div><!-- /invoice-block -->
<?php if (empty($invoices)): ?>
	
<div class="no_object_notification">
	<h4><?php echo lang('invoices:noinvoicetitle') ?></h4>
	<p><?php echo lang('invoices:noinvoicebody') ?></p>
	<p class="call_to_action"><a class="yellow-btn fire-ajax" id="create_project" href="<?php echo site_url('admin/invoices/create'); ?>" title="<?php echo lang('invoices:newinvoice') ?>"><span><?php echo lang('invoices:newinvoice') ?></span></a></p>
</div><!-- /no_object_notification -->


<?php else: ?>

<div class="table-area thirty-days">
	<?php $this->load->view('reports/table', array('rows' => $invoices)); ?>
</div>

<div class="pagination">
	<?php echo $this->pagination->create_links(); ?>
</div>
<?php endif; ?>