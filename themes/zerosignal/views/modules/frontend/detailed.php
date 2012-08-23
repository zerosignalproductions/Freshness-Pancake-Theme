<div id="content">
	<table class="data-table" id="<?php echo (isset($is_estimate) and $is_estimate) ? 'estimate_table' : ''; ?>" cellspacing="0" cellpadding="0">
		<thead>
		<tr>
			<th class="column_1" style="text-align:left"><?php echo __('global:description'); ?> </th>
			<th class="column_2"><?php echo __('invoices:timequantity');?></th>
			<th class="column_3"><?php echo __('invoices:ratewithcurrency', array($invoice['currency_code'] ? $invoice['currency_code'] : Currency::code()));?></th>
			<th class="column_4"><?php echo __('invoices:taxable');?></th>
			<th class="column_5"><?php echo __('invoices:total');?></th>
		</tr>
		</thead>

		<tbody>
			<?php
            if ( ! empty($invoice['items'])):
			$class = '';
			foreach( $invoice['items'] as $item ):
			?>
				<tr class="<?php echo $class; ?> invoice-desc-row">
					<td class="column_1"><?php echo $item['name']; ?></td>
					<td class="column_2"><?php echo $item['qty']; ?></td>
					<td class="column_3"><?php echo Currency::format($item['rate'], $invoice['currency_code']); ?></td>
					<td class="column_4"><?php echo $item['tax_id'] ? __('global:Y') : __('global:N'); ?></td>
					<td class="column_5 total-values"><?php echo Currency::format($item['total'], $invoice['currency_code']); ?></td>
				</tr>
				<?php if ($item['description']): ?>
				<tr class="invoice-item-notes">	
					<td colspan="5"><?php echo nl2br($item['description']); ?></td>
				</tr>
				<?php endif; ?>
			<?php
			$class = ($class == '' ? 'alt' : '');
			endforeach;
                        endif;
			?>
		</tbody>
	</table>
    
    <div class="table-meta">
        <div class="invoice-extra">
            <?php if (!isset($is_estimate)) : ?>   
                <?php $has_gateway = (count(Gateway::get_frontend_gateways($invoice['real_invoice_id'])) > 0); ?> 
                <?php if (count($invoice['partial_payments']) > 1) : ?>
                <h5 class="main-header-style" id="payment-plan-header"><?php echo __('partial:partialpayments');?></h5>
                <div class="payment-plan">
                    <ol>
                        <?php foreach ($invoice['partial_payments'] as $part) : ?>
                            <li>
                                <p>
                                    <span class="amount"><?php echo Currency::format($part['billableAmount'], $invoice['currency_code']); ?></span> <?php if ($part['due_date'] != 0) : ?><?php echo __('partial:dueondate', array('<span class="dueon">'.format_date($part['due_date']).'</span>'));?><?php endif; ?> <?php echo (empty($part['notes'])) ? '' : '- '.$part['notes']; ?> &raquo;
                                    <?php if (!$part['is_paid']) : ?>
                                    <?php if ($pdf_mode) : ?>
                                        <?php echo __('partial:topaynowgoto', array('<a href="'.$part['payment_url'].'">'.$part['payment_url'].'</a>'));?>
                                    <?php else: ?>
                                        <?php if ($has_gateway): ?>
                                        <?php echo anchor($part['payment_url'], __('partial:proceedtopayment'), 'class="simple-button"'); ?>
                                        <?php endif ?>
                                    <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo __('partial:partpaidthanks');?>
                                    <?php endif; ?>
                                </p>
                            </li>
                        <?php endforeach; ?>
                    </ol>
                </div>
                <?php endif; ?>
			<?php endif ; ?>            
            
            <div class="invoice-notes">
            <?php if (!empty($invoice['notes'])): ?>
                <h5>Notes</h5>
                <?php echo auto_typography($invoice['notes']);?>
            <?php endif; ?>
            </div>
            
            <?php if (!isset($is_estimate)) : ?> 
                <?php if ($files): ?>
                <div class="invoice-files" class="main-body-style">
                    <h5 class="main-header-style"><?php echo __('invoices:filestodownload'); ?></h5>
                        <div class="files-holder">
                            <?php if ( ! $is_paid): ?>
                                <p><?php echo __('invoices:fileswillbeavailableafterpay');?></p>
                            <?php endif; ?>
                    
                            <ul id="list-of-files">
                            <?php foreach ($files as $file): ?>
                                    <?php $ext = explode('.', $file['orig_filename']); end($ext); $ext = current($ext); ?>
                                    <?php $bg = $pdf_mode ? '' : asset::get_src($ext.'.png', 'img'); ?>
                                    <?php $style = empty($bg) ? '' : 'style="background: url('.$bg.') 1px 0px no-repeat;"'; ?>
                            <?php if ($is_paid): ?>
                                <li><a class="file-to-download" <?php echo $style;?> href="<?php echo site_url('files/download/'.$invoice['unique_id'].'/'.$file['id']);?>"><?php echo $file['orig_filename'];?></a></li>
                            <?php else: ?>
                                 <li class="file-to-download" <?php echo $style;?> ><?php echo $file['orig_filename']; ?></li>
                            <?php endif; ?>
                            <?php endforeach; ?>
                            </ul><!-- /list-of-files -->
                        </div><!-- /files-holder -->
                    </div><!-- /files -->
                <?php endif; ?>
            <?php endif; ?>
            
            <?php // Taxes Section  ?>
            <?php if ($invoice['has_tax_reg']): ?>
            <div class="invoice-taxes">
                <h3><?php echo __('settings:taxes') ?></h3>
                <ul id="taxes">
                    <?php foreach ($invoice['taxes'] as $id => $total ):
                        $tax = Settings::tax($id);
                        if (empty($tax['reg'])) continue;
                    ?>
                        <li class="<?php echo underscore($tax['name']) ?>">
                            <span class="name"><?php echo $tax['name'] ?>:</span>
                            <span class="reg"><?php echo $tax['reg'] ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>            
            <?php endif; ?>
            <?php // END Taxes section ?>            
        </div>
        <div class="invoice-totals">
            <table>
                <tr>
                    <td class="total-heading"><?php echo __('invoices:subtotal');?>:</td>
                    <td class="total-values"><?php echo Currency::format($invoice['sub_total'], $invoice['currency_code']); ?></td>
                </tr>
                <?php foreach( $invoice['taxes'] as $id => $total ): $tax = Settings::tax($id); ?>
                <tr>
                    <td class="total-heading"><?php echo $tax['name'].' ('.$tax['value'].'%):'; ?></td>
                    <td class="total-values"><?php echo Currency::format($total, $invoice['currency_code']); ?></td>
                </tr>
                <?php endforeach; ?>
                <tr>
                    <td class="total-heading"><?php echo __('invoices:totaltax');?>:</td>
                    <td class="total-values"><?php echo Currency::format($invoice['tax_total'], $invoice['currency_code']); ?></td>
                </tr>
    
                <tr class="invoice-total">
                    <td class="total-heading"><?php echo __('invoices:total');?>:</td>
                    <td class="total-values"><?php echo Currency::format($invoice['total'], $invoice['currency_code']); ?></td>
                </tr>
            </table>
        </div>
    </div>    
    
    
</div><!-- /content -->