<div class="invoice-block">

    <ul class="btns-list">
	
	
		
		
		<?php if (group_has_role('projects', 'create')): ?>
		<li><a href="<?php echo site_url('admin/projects/index/0/'.$client->id.'#create'); ?>" class="yellow-btn"><span><?php echo __('projects:add'); ?></span></a></li>
		<?php endif ?>
		
		<?php if (group_has_role('invoices', 'create')): ?>
		<li><a href="<?php echo site_url('admin/invoices/create/client/'.$client->id); ?>" class="yellow-btn"><span><?php echo lang('invoices:create'); ?></span></a></li>
		<?php endif ?>
		
		<?php if (group_has_role('clients', 'edit')): ?>
		<li><a href="<?php echo site_url('admin/clients/edit/'.$client->id); ?>" class="yellow-btn"><span><?php echo lang('global:edit'); ?></span></a></li>
		<?php endif ?>
		
		<?php if (group_has_role('clients', 'delete')): ?>
		<li><a href="<?php echo site_url('admin/clients/delete/'.$client->id); ?>" class="yellow-btn"><span><?php echo lang('global:delete'); ?></span></a></li>
		<?php endif ?>
		
    </ul><!-- /btns-list end -->

    <div id="ajax_container"></div>


    <div class="head-box">

	   <?php if ($client->company): ?>

			<h3 class="ttl ttl3"><?php echo lang('global:client') ?>: <?php echo $client->company; ?></h3>

		<?php else: ?>

			<h3 class="ttl ttl3"><?php echo lang('global:client') ?>: <?php echo $client->first_name . ' ' . $client->last_name;?></h3>

		<?php endif; ?>
    </div>



<div id="addressHolder" style="">
	<h4 class="orangered"><?php echo lang('global:address'); ?></h4>
	<p>
		<?php echo $client->company;?><br />
		<?php echo nl2br($client->address);?><br />
	</p>
</div><!-- /addressHolder -->


<div id="detailsHolder" style="">
	<h4 class="orangered"><?php echo lang('global:details') ?></h4>
	<p>
		<?php echo lang('global:email'); ?>: <?php echo mailto($client->email); ?><br/>
		<?php echo lang('global:overdue') ?>: <span class="overdue"><?php echo Currency::format($totals['overdue']['total']); ?></span><br/>
		<?php echo lang('global:unpaid') ?>: <span class="unpaid"><?php echo Currency::format($totals['unpaid']['total']); ?></span><br/>
		<?php echo lang('global:paid') ?>: <span class="paid"><?php echo Currency::format($totals['paid']['total']);?></span><br/>
	</p>

</div><!-- /detailsHolder -->


<div id="notesHolder" style="">
	<h4 class="orangered"><?php echo lang('global:notes'); ?></h4>
	<p><?php echo nl2br($client->profile);?></p>

</div><!-- /notesHolder -->
</div>
<br style="clear: both" />


<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('kitchen:kitchen_name'); ?></h3>
	</div><!-- /head-box end -->
	
	<div id="cas-url-holder">
		<p class="text"><?php echo __('kitchen:description') ?></p>
	<p class="urlToSend"><?php echo __('kitchen:urltosend') ?>: <a href="<?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id); ?>" class="url-to-send"><?php echo site_url(Settings::get('kitchen_route').'/'.$client->unique_id); ?></a> <a href="#" id="copy-to-clipboard" class="yellow-btn"><span><?php echo __('global:copytoclipboard') ?></span></a></p>
	

	<?php if($client->passphrase == ''): ?>
	<p class="passphrase"><?php echo __('kitchen:nopassphrase') ?></p>
	<?php else: ?>
	<p class="passphrase set"><?php echo __('kitchen:passphrase') ?>: <span><?php echo $client->passphrase ?></span></p>
	<?php endif; ?>
	</div><!-- /cas-url-holder -->
	
	
</div>



<?php if ($totals['count'] == 0): ?>
	
	<div class="no_object_notification">
	<h4><?php echo lang('clients:hasnoinvoicetitle') ?></h4>
	<p><?php echo lang('clients:hasnoinvoicebody') ?></p>
	<p class="call_to_action"><a class="yellow-btn fire-ajax" id="create_invoice" href="<?php echo site_url('admin/invoices/create'); ?>?client=<?php echo $client->id ?>"><span><?php echo lang('invoices:create'); ?></span></a></p>
	</div><!-- /no_object_notification -->
	
<?php else: ?>

<div class="invoice-block">
	<div id="healthcheck-holder">	
	<?php echo lang('clients:health_check') ?> (<?php echo $client->health['overall'];?>%):
	<div class="healthCheck">
		<span class="healthBar"><span class="paid" style="width:<?php echo $client->health['overall'];?>%"></span></span>
	</div><!-- /healthCheck -->
	</div><!-- /healthcheck-holder -->
</div><!-- /invoice-block -->


<?php if ($invoices['overdue']): ?>
	
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('invoices:overdue'); ?></h3>
	</div><!-- /head-box end -->
</div>

<div class="table-area thirty-days">
		<?php $this->load->view('reports/table', array('rows' => $invoices['overdue'], 'suffix' => 'overdue')); ?>
	</div>

<br style="clear: both" />
	
<?php endif; ?>


<?php if ($invoices['unpaid']): ?>
	
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('invoices:unpaid'); ?></h3>
	</div><!-- /head-box end -->
</div>

<div class="table-area thirty-days">
		<?php $this->load->view('reports/table', array('rows' => $invoices['unpaid'], 'suffix' => 'unpaid')); ?>
	</div>

<br style="clear: both" />

<?php endif; ?>

<?php if ($invoices['paid']): ?>
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('invoices:paid'); ?></h3>
	</div><!-- /head-box end -->
</div>
<div class="table-area thirty-days">
		<?php $this->load->view('reports/table', array('rows' => $invoices['paid'], 'suffix' => 'paid')); ?>
	</div>

<br style="clear: both" />

<?php endif; ?>

<?php if ( ! empty($contact_log)): ?>
<div class="invoice-block">
	<div class="head-box">
		<h3 class="ttl ttl2"><?php echo __('contact:title'); ?></h3>
	</div><!-- /head-box end -->
</div>
<div class="table-area">
	<table class="pc-table">
		<thead>
			<tr>
			    <th><?php echo __('contact:subject') ?></th>
			    <th><?php echo __('contact:contact') ?></th>
				<th><?php echo __('global:sent') ?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($contact_log as $contact): ?>
		<tr>
			<td><?php echo $contact->subject; ?></td>
			<td><?php echo $contact->method == 'email' ? 'e: '.mailto($contact->contact) : 'p: '.$contact->contact; ?></td>
	   		<td><?php echo format_date($contact->sent_date, 'h:i:s'); ?></td>
		</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
</div>

<br style="clear: both" />

<?php endif; ?>

<?php endif; ?>
<?php
asset::js('jquery.zclip.min.js', array(), 'clipboard');
echo asset::render('clipboard');
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
