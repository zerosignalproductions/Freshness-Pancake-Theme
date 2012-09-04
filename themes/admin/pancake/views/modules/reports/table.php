<div class="report-html-table-container" id="report-table<?php echo isset($suffix) ? '-'.$suffix : '';?>">
    <table class="pc-table report-html-table">
	<thead>
	    <tr>
		<th class="cell1"><?php echo __('global:status'); ?></th>
		<th class="cell3"><?php echo __('global:details'); ?></th>
		<th class="cell5"><?php echo __('global:client'); ?></th>
		<th class="cell5"><?php echo __('global:actions'); ?></th>
	    </tr>
	</thead>
	<tbody>
	    <?php foreach ($rows as $row): ?>
		
		<?php $permission_module = isset($row->proposal_number) ? 'proposals' : 'invoices' ?>
		
		<tr class="invoice_<?php echo $row->unique_id;?>">
		    <?php if (isset($row->proposal_number)) : ?>
			<td class="cell1">
			    <span class="status-icon <?php echo ($row->status == 'ACCEPTED' ? 'green' : 'red'); ?>">
				<?php echo __('proposals:' . (!empty($row->status) ? strtolower($row->status) : 'noanswer'), array(format_date($row->last_status_change))); ?>
			    </span>
			</td>
			<td class="cell3">
			    <?php $amount = ', estimated at <span class="'.($row->status == 'ACCEPTED' ? 'paid' : 'unpaid').'-amount">'.Currency::format($row->amount).'</span>';?>
			    <span><?php echo __('global:proposal'); ?> <?php echo anchor('admin/proposals/edit/' . $row->unique_id, '#' . $row->proposal_number); ?><?php echo $amount;?></span>
			    <span><?php echo $row->title; ?></span>
			    <span><?php echo ucfirst(($row->last_viewed > 0) ? (__('proposals:lastviewed', array(format_date($row->last_viewed), format_time($row->last_viewed)))) : __('proposals:neverviewed')) ?>.</span>
			</td>
		    <?php else: ?>
			<td class="cell1">
			    <span class="status-icon <?php echo ((isset($row->overdue) and $row->type != 'ESTIMATE' and $row->overdue) ? 'red' : (((isset($row->paid) and $row->paid) and $row->type != 'ESTIMATE') ? 'green' : ( ($row->type == 'ESTIMATE' or ($row->last_sent == 0)) ? 'grey' : 'red' ))); ?>">			    
				<?php if ($row->type == 'ESTIMATE') :?>
				<?php echo (($row->type == 'ESTIMATE' ? __('global:estimate') : '')); ?>
				<?php else: ?>
				    <?php if (isset($row->paid) and $row->paid) :?>
					<?php echo __('invoices:paidon', array(format_date($row->payment_date)));?>
				    <?php else: ?>
					<?php echo ((isset($row->overdue) and $row->overdue) ? __('global:overdue').'<br />' : (($row->due_date > 0) ? ucfirst(__('partial:dueondate', array(format_date($row->due_date)))).'<br />' : '') );?>
					<?php echo (isset($row->last_sent) and $row->last_sent > 0) ? __('invoices:senton', array(format_date($row->last_sent))).'<br />' :  __('global:notyetsent').'<br />'; ?>
				    <?php endif;?>
				<?php endif;?>
			    </span>
			</td>
			<td class="cell3">
                            <span><?php echo $row->type == 'ESTIMATE' ? __('global:estimate') : Settings::get('default_invoice_title'); ?> <?php echo anchor('admin/invoices/edit/' . $row->unique_id, '#' . $row->invoice_number); ?> (<?php echo Currency::format($row->billable_amount, $row->currency_symbol); ?>)<?php if (isset($row->proposal_id) and $row->proposal_id != 0): ?> - <?php echo __('estimates:attachedtoproposal', array($row->proposal_num))?><?php endif;?></span>
			    <?php if ($row->type != 'ESTIMATE'): ?><span><?php echo __('invoices:due') ?>: <?php echo ($row->due_date > 0) ? format_date($row->due_date) : 'n/a'; ?>
				<?php if (round($row->unpaid_amount, 2) > 0 and $row->type != 'ESTIMATE') : ?>| <span class="unpaid-amount"><?php echo __('global:unpaid') ?>: <?php echo Currency::format($row->unpaid_amount, $row->currency_symbol); ?></span><?php endif; ?>
				<?php if ($row->paid_amount > 0) : ?> | <span class="paid-amount"><?php echo __('global:paid') ?>: <?php echo Currency::format($row->paid_amount, $row->currency_symbol); ?></span><?php endif; ?>
			    </span><?php endif;?>
			    <?php if ($row->is_recurring) :?>
				<span>
				    <?php if ($row->id == $row->recur_id) :?>
				    <?php echo __('invoices:willreoccurin', array(format_date($this->invoice_m->getNextInvoiceReoccurrenceDate($row->id))))?>
				    <?php else: ?>
				    <?php echo __('invoices:thisisareoccurrence', array(anchor('admin/invoices/edit/' . $this->invoice_m->getUniqueIdById($row->recur_id), '#' . $this->invoice_m->getInvoiceNumberById($row->recur_id))));?>
				    <?php endif; ?>
				</span>
			    <?php endif; ?>
			    <?php if ($row->is_recurring): ?>
				<span><?php echo ($row->auto_send and $row->last_sent == 0) ? __('invoices:willbesentautomatically', array(format_date($row->date_to_automatically_notify))) : '';?></span>
			    <?php endif; ?>
			    <?php if ($row->last_viewed > 0) :?>    
			    <span><?php echo ucfirst(__('proposals:lastviewed', array(format_date($row->last_viewed), format_time($row->last_viewed)))); ?>.</span>
			    <?php endif; ?>
			</td>
		    <?php endif; ?>

		    <td class="cell5">
			<a href="<?php echo site_url('admin/clients/view/' . $row->client_id); ?>">
			    <span><?php echo isset($row->proposal_number) ? $row->client_name : $row->first_name . ' ' . $row->last_name; ?></span>
			    <span><?php echo isset($row->proposal_number) ? $row->client_company : $row->company; ?></span>
			</a>
		    </td>
		    <td class="cell5 actions">
			<?php echo anchor((isset($row->proposal_number) ? 'proposal/' : '') . $row->unique_id, __('global:view'), array('class' => 'icon view', 'title' => __('global:view')) ); ?>
			<?php if (group_has_role($permission_module, 'send')): ?>
			<?php echo anchor('admin/'.(isset($row->proposal_number) ? 'proposals/send' : (($row->type == 'ESTIMATE') ? 'estimates' : 'invoices').'/created').'/' . $row->unique_id, __('global:send_to_client'), array('class' => 'icon mail', 'title' => __('global:send_to_client'))); ?>
			<?php endif ?>
			<?php echo anchor('admin/'.(isset($row->proposal_number) ? 'proposals' : (($row->type == 'ESTIMATE') ? 'estimates' : 'invoices')).'/edit/' . $row->unique_id, __('global:edit'), array('class' => 'icon edit', 'title' => __('global:edit'))); ?>
			<div class="more-actions">
			    <div class="gear cf"><a href="#" class="icon gears"></a></div>
			    <ul>
				<?php if ((isset($row->type) and ($row->type == 'DETAILED' or $row->type == 'ESTIMATE')) or isset($row->proposal_number) and group_has_role($permission_module, 'edit')) :?>
				    <li><a href="<?php echo site_url((isset($row->proposal_number) ? 'proposal/' : 'pdf/').$row->unique_id.(isset($row->proposal_number) ? '/pdf' : ''));?>"><?php echo __('global:viewpdf');?></a></li>
				<?php endif;?>
				<?php if ((isset($row->type) and ($row->type == 'DETAILED' or $row->type == 'SIMPLE')) and group_has_role($permission_module, 'edit')): ?>
				    <?php if (!$row->paid) :?>
                                        <li><a href="#" class="add_payment" data-invoice-unique-id="<?php echo $row->unique_id;?>"><span><?php echo __('partial:add_payment');  ?></span></a></li>
                                    <?php endif;?>
                                    <?php if ($row->part_count == 1): ?>
                                        <li><a href="#" class="partial-payment-details invoice_<?php echo $row->unique_id;?> key_1" data-details="1" data-invoice-unique-id="<?php echo $row->unique_id;?>"><span><?php echo __('partial:'.(($row->paid) ? 'paymentdetails' : 'markaspaid'));  ?></span></a></li>
                                    <?php endif;?>
				<?php endif;?>
				<?php if ((isset($row->type) and ($row->type == 'DETAILED' or $row->type == 'SIMPLE')) and ($row->last_sent == 0)) :?>
				    <li><a href="#" class="mark-as-sent" data-invoice-unique-id="<?php echo $row->unique_id;?>"><span><?php echo __('invoices:markassent');  ?></span></a></li>
				<?php endif;?>
				
				<?php if (group_has_role($permission_module, 'create')): ?>
				<li><a href="<?php echo site_url('admin/'.(isset($row->proposal_number) ? 'proposals' : (($row->type == 'ESTIMATE') ? 'estimates' : 'invoices')).'/duplicate/' . $row->unique_id);?>"><?php echo __('global:duplicate')?></a></li>
				<?php endif ?>
				
				<?php if (isset($row->type) and $row->type == 'ESTIMATE') : ?>
				    <li><a href="<?php echo site_url('admin/estimates/convert/'.$row->unique_id);?>"><?php echo __('global:converttoinvoice');?></a></li>
				<?php endif; ?>
				
				<?php if (group_has_role($permission_module, 'delete')): ?>
				<li><?php echo anchor('admin/'.(isset($row->proposal_number) ? 'proposals' : (($row->type == 'ESTIMATE') ? 'estimates' : 'invoices')).'/delete/' . $row->unique_id, __('global:delete'), array('title' => __('global:delete'))); ?></li>
			    </ul>
				<?php endif ?>
			</div>
		    </td>
		</tr>
	    <?php endforeach; ?>
	</tbody>
</table>
</div>