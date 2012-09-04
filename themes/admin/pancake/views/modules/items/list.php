<div class="invoice-block">
	
<?php if ($items): ?>
<ul class="btns-list">
	<li><a href="<?php echo site_url('admin/items/create'); ?>" title="<?php echo lang('items:add') ?>" class="yellow-btn"><span><?php echo lang('items:add') ?></span></a></li>
</ul><!-- /btns-list end -->
<?php endif; ?>

<br style="clear: both;" />
<div id="ajax_container"></div>

<div class="head-box">
	<h3 class="ttl ttl3"><?php echo lang('global:reusableinvoiceitems') ?></h3>
	
</div><!-- /head-box end -->
<div class="row reusable-items-description"><p>You should use Reusable Invoice Items when you want to reuse the same item in different invoices. To use them when you're creating or editing an invoice, simply start typing the name of the item you saved, and it'll offer to autocomplete the item's details for you.</p></div>
</div>
<?php if (empty($items)): ?>
	
<div class="no_object_notification">
	<h4><?php echo lang('items:noitemtitle') ?></h4>
	<p><?php echo lang('items:noitembody') ?></p>
	<p class="call_to_action"><a href="<?php echo site_url('admin/items/create'); ?>" title="<?php echo lang('items:add') ?>" class="yellow-btn"><span><?php echo lang('items:add') ?></span></a></p>
</div><!-- /no_object_notification -->

<?php else: ?>

<div id="project_container">

	<div class="table-area">
		<table class="pc-table" cellspacing="0">
			<thead>
				<tr>
					<th><?php echo lang('global:name') ?></th>
					<th><?php echo lang('global:description') ?></th>
					<th><?php echo lang('items:qty_hrs') ?></th>
	                <th><?php echo lang('items:rate') ?></th>
					<th><?php echo lang('global:actions') ?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($items as $item): ?>
				<tr>
					<td><?php echo $item->name; ?></td>
					<td><?php echo word_limiter($item->description, 20);?></td>
					<td><?php echo $item->qty; ?></td>
					<td><?php echo $item->rate; ?></td>
					<td class="actions">
					<?php echo anchor('admin/items/edit/'.$item->id, __('global:edit'), array('class' => 'icon edit', 'title' => __('global:edit'))); ?> 
					<?php echo anchor('admin/items/delete/'.$item->id, lang('global:delete'), array('class' => 'icon delete', 'title' => __('global:delete'))); ?>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="pagination">
	<?php echo $this->pagination->create_links(); ?>
</div>

<?php endif; ?>
