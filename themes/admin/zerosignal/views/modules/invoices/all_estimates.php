<div class="invoice-block">
	
	<br style="clear: both;" />
	<div class="head-box">
		<h3 class="ttl ttl3"><?php echo lang('estimates:alltitle') ?></h3>
	</div><!-- /head-box end -->
	<?php if ($invoices): ?>
	<div class="form-holder">
		<?php echo form_open(uri_string()); ?>
		<fieldset>
		<div class="row">
			<label for="client_id"><?php echo __('clients:filter');?></label>
			<div class="sel-item"><?php echo form_dropdown('client_id', $clients_dropdown, $client_id, 'onchange="this.form.submit()"'); ?></div>
		</div>
		</fieldset>
		<?php echo form_close(); ?>
	</div><!-- /form-holder -->
	<?php endif; ?>

</div>
<?php if (empty($invoices)): ?>

<div class="no_object_notification">
<h4><?php echo lang('estimates:noestimatetitle') ?></h4>
<p><?php echo lang('estimates:noestimatebody') ?></p>
<p class="call_to_action"><a href="<?php echo site_url('admin/estimates/create_estimate'); ?>" class="yellow-btn"><span><?php echo lang('estimates:createnew') ?></span></a></p>
</div><!-- /no_object_notification -->

<?php else: ?>
	
	<div id="project_container">
		<div class="table-area thirty-days">
		    <?php $this->load->view('reports/table', array('rows' => $invoices)); ?>
		</div>
	</div>

    <div class="pagination">
    	<?php echo $this->pagination->create_links(); ?>
    </div>

<?php endif; ?>

