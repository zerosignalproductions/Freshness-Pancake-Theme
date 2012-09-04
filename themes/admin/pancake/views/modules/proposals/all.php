<div class="invoice-block">
	
    <div class="head-box">
        <h3 class="ttl ttl3"><?php echo lang('proposals:all') ?></h3>
    </div>
	
	<div class="filters">
		<div class="form-holder">
			<?php echo form_open(uri_string()); ?>
			<fieldset>
				<div class="row">
					<label for="client_id"><?php echo lang('clients:filter') ?>:</label>
					<div class="sel-item"><?php echo form_dropdown('client_id', (array('0' => 'All') + $clients_dropdown), $client_id, 'onchange="this.form.submit()"'); ?></div>
				</div><!-- /row -->
			</fieldset>
			<?php echo form_close(); ?>
		</div><!-- /form-holder -->
	</div><!-- /filters -->
</div><!-- /invoice-block -->



<?php if (empty($proposals)): ?>

    <div class="no_object_notification">
        <h4><?php echo lang('proposals:noproposaltitle') ?></h4>

		<?php if (group_has_role('projects', 'track_time')): ?>
        <p><?php echo lang('proposals:noproposalbody') ?></p>
        <p class="call_to_action"><a class="yellow-btn fire-ajax" id="create_project" href="<?php echo site_url('admin/proposals/create'); ?>" title="<?php echo lang('proposals:newproposal') ?>"><span><?php echo lang('proposals:newproposal') ?></span></a></p>
		<?php endif ?>
		
    </div><!-- /no_object_notification -->

<?php else: ?>

    <div class="table-area thirty-days">
        <?php $this->load->view('reports/table', array('rows' => $proposals)); ?>
    </div>

    <div class="pagination">
		<?php echo $this->pagination->create_links(); ?>
    </div>

<?php endif; ?>