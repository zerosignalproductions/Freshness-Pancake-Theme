<div class="invoice-block">

    <ul class="btns-list">
		<li><a href="<?php echo site_url('admin/invoices/create/client/'.$client['id']); ?>" class="yellow-btn"><span><?php echo lang('invoices:create'); ?></span></a>
		<li><a href="<?php echo site_url('admin/clients/edit/'.$client['id']); ?>" class="yellow-btn"><span><?php echo lang('global:edit'); ?></span></a>
		<li><a href="<?php echo site_url('admin/clients/delete/'.$client['id']); ?>" class="yellow-btn"><span><?php echo lang('global:delete'); ?></span></a>
    </ul><!-- /btns-list end -->

    <div id="ajax_container"></div>


    <div class="head-box">

	   <?php if ($client['company']): ?>

			<h3 class="ttl ttl3"><?php echo lang('global:client') ?>: <?php echo $client['company']; ?></h3>

		<?php else: ?>

			<h3 class="ttl ttl3"><?php echo lang('global:client') ?>: <?php echo $client['first_name'] . ' ' . $client['last_name'];?></h3>

		<?php endif; ?>
    </div>



<div id="addressHolder" style="width:150px; float:left; clear:none; margin-left:80px">
	<h4 class="orangered"><?php echo lang('global:address'); ?></h4>
	<p>
		<?php echo $client['company'];?><br />
		<?php echo nl2br($client['address']);?><br />
	</p>
</div><!-- /addressHolder -->


<div id="detailsHolder" style="width:200px; float:left; padding:0 30px; margin:0 20px; clear:none; border-right:1px solid #f2f2f2; border-left:1px solid #f2f2f2">
	<h4 class="orangered"><?php echo lang('global:details') ?></h4>
	<p>
		<?php echo lang('global:email'); ?>: <?php echo mailto($client['email'], $client['email']); ?><br/>
		<?php echo lang('global:overdue') ?>: <span class="overdue"><?php echo Currency::format($totals['overdue']['total']); ?></span><br/>
		<?php echo lang('global:unpaid') ?>: <span class="unpaid"><?php echo Currency::format($totals['unpaid']['total']); ?></span><br/>
		<?php echo lang('global:paid') ?>: <span class="paid"><?php echo Currency::format($totals['paid']['total']);?></span><br/>
	</p>

</div><!-- /detailsHolder -->


<div id="notesHolder" style="width:200px; float:left; clear:none; height:100px;">
	<h4 class="orangered"><?php echo lang('global:notes'); ?></h4>
	<p><?php echo nl2br($client['profile']);?></p>

</div><!-- /notesHolder -->
</div>
<br style="clear: both" />

<?php if($totals['count'] == 0): ?>
	
	<div class="no_object_notification">
	<h4><?php echo lang('clients:hasnoinvoicetitle') ?></h4>
	<p><?php echo lang('clients:hasnoinvoicebody') ?></p>
	<p class="call_to_action"><a class="yellow-btn fire-ajax" id="create_project" href="<?php echo site_url('admin/projects/create'); ?>"><span><?php echo lang('projects:add'); ?></span></a></p>
	</div><!-- /no_object_notification -->
	
<?php else: ?>

<div class="invoice-block">
	<?php echo lang('clients:health_check') ?> (<?php echo $client['health']['overall'];?>%):
	<div class="healthCheck">
		<span class="healthBar"><span class="paid" style="width:<?php echo $client['health']['overall'];?>%"></span></span>
	</div><!-- /healthCheck -->
</div><!-- /invoice-block -->


<div class="invoice-block">
<div class="head-box">
	<h3 class="ttl ttl2"><?php echo __('invoices:overdue'); ?></h3>
</div><!-- /head-box end -->
</div>


<div class="table-area">
<table class="pc-table">
<thead>
		<tr>
		    <th><?php echo lang('invoices:number') ?></th>
		    <th><?php echo lang('invoices:unpaid_totalamount') ?></th>
			<th><?php echo lang('invoices:due') ?></th>
			<th><?php echo lang('global:actions') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($invoices['overdue'] as $invoice): ?>
	<tr>
	    <td><?php echo $invoice->invoice_number; ?></td>
   	<td><?php echo Currency::format($this->ppm->getInvoiceUnpaidAmount($invoice->unique_id), $invoice->currency_code); ?> / <?php echo Currency::format($this->ppm->getInvoiceTotalAmount($invoice->unique_id), $invoice->currency_code); ?></td>
	   	<td><?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>n/a</em>'; ?></td>
		<td><?php echo anchor($invoice->unique_id, __('global:view')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/created/'.$invoice->unique_id, __('global:resend')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/edit/'.$invoice->unique_id, __('global:edit')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/delete/'.$invoice->unique_id, __('global:delete')); ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div><!-- /table-area -->


<br style="clear: both" />
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('invoices:unpaid'); ?></h3>
	</div><!-- /head-box end -->
</div>

<div class="table-area">
	<table class="pc-table">
	<thead>
		<tr>
		    <th><?php echo lang('invoices:number') ?></th>
		    <th><?php echo lang('invoices:unpaid_totalamount') ?></th>
			<th><?php echo lang('invoices:due') ?></th>
			<th><?php echo lang('global:actions') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($invoices['unpaid'] as $invoice): ?>
	<tr>
	    <td><?php echo $invoice->invoice_number; ?></td>
	   	<td><?php echo Currency::format($this->ppm->getInvoiceUnpaidAmount($invoice->unique_id), $invoice->currency_code); ?> / <?php echo Currency::format($this->ppm->getInvoiceTotalAmount($invoice->unique_id), $invoice->currency_code); ?></td>
	   	<td><?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>n/a</em>'; ?></td>
		<td><?php echo anchor($invoice->unique_id, __('global:view')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/created/'.$invoice->unique_id, __('global:resend')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/edit/'.$invoice->unique_id, __('global:edit')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/delete/'.$invoice->unique_id, __('global:delete')); ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</div><!-- /table-area -->

<br style="clear: both" />

<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('invoices:paid'); ?></h3>
	</div><!-- /head-box end -->
</div>
<div class="table-area">
	<table class="pc-table">
	<thead>
		<tr>
		    <th><?php echo lang('invoices:number') ?></th>
		    <th><?php echo lang('invoices:unpaid_totalamount') ?></th>
			<th><?php echo lang('invoices:due') ?></th>
			<th><?php echo lang('global:actions') ?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($invoices['paid'] as $invoice): ?>
	<tr>
	    <td><?php echo $invoice->invoice_number; ?></td>
   		<td><?php echo Currency::format($this->ppm->getInvoiceUnpaidAmount($invoice->unique_id), $invoice->currency_code); ?> / <?php echo Currency::format($this->ppm->getInvoiceTotalAmount($invoice->unique_id), $invoice->currency_code); ?></td>
	   	<td><?php echo $invoice->due_date ? format_date($invoice->due_date) : '<em>n/a</em>'; ?></td>
		<td><?php echo anchor($invoice->unique_id, __('global:view')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/created/'.$invoice->unique_id, __('global:resend')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/edit/'.$invoice->unique_id, __('global:edit')); ?>&nbsp;|&nbsp;<?php echo anchor('admin/invoices/delete/'.$invoice->unique_id, __('global:delete')); ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>


</div><!-- /table-area -->

<?php endif; ?>