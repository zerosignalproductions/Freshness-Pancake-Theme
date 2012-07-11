<table class="report-contents timesheet-table">
    <thead>
        <tr>
            <?php $i = 0; ?>
            <?php foreach ($fields as $field => $title) : ?>
                <?php if ($field == 'taxes') : ?>
                    <th colspan="<?php echo $i; ?>"></th>
                    <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>
                        <th class="taxes" colspan="3"><?php echo str_ireplace('{tax}', $taxes[$tax_id], $title); ?></th>
                    <?php endforeach; ?>
                <?php else: ?>
                    <?php $i++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
        <tr>
            <?php foreach ($fields as $field => $title) : ?>
                <?php if ($field == 'taxes') : ?>
                    <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>
                        <th>Uncollected</th>
                        <th>Collected</th>
                        <th>Total</th>
                    <?php endforeach; ?>
                <?php else: ?>
                    <th class="<?php echo $field; ?>"><?php echo $title; ?></th>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </thead>   
    <tbody>
        <?php foreach ($records as $record) : ?>
            <tr>
                <?php foreach (array_keys($fields) as $field) : ?>
                    <?php if ($field == 'taxes') : ?>
                        <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>
                            <td><?php echo Currency::format((isset($record['total_taxes'][$tax_id]) and isset($record[$field][$tax_id])) ? ($record['total_taxes'][$tax_id] - $record[$field][$tax_id]) : 0); ?></td>
                            <td><?php echo Currency::format(isset($record[$field][$tax_id]) ? $record[$field][$tax_id] : 0); ?></td>
                            <td><?php echo Currency::format(isset($record['total_taxes'][$tax_id]) ? $record['total_taxes'][$tax_id] : 0); ?></td>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <td><?php
            switch ($field) {
                case 'due_date':
                    echo format_date($record[$field]);
                    break;
                case 'client':
                    echo ($record[$field]);
                    break;
                case 'invoice_number':
                    echo '<a href="' . site_url('pdf/' . $record['unique_id']) . '">#' . ($record[$field]) . '</a>';
                    break;
                default:
                    echo Currency::format($record[$field]);
                    break;
            }
                        ?></td>
                        <?php endif; ?>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>    
    </tbody>
    <tfoot>
        <tr>
            <?php foreach (array_keys($fields) as $field) : ?>
                <?php if (isset($totals[$field])) : ?>
                    <?php if ($field == 'taxes') : ?>
                        <?php foreach (array_keys($totals['taxes']) as $tax_id): ?>
                            <th class="<?php echo $field; ?>"><?php echo Currency::format($totals[$field][$tax_id]['uncollected']); ?></th>
                            <th class="<?php echo $field; ?>"><?php echo Currency::format($totals[$field][$tax_id]['collected']); ?></th>
                            <th class="<?php echo $field; ?>"><?php echo Currency::format($totals[$field][$tax_id]['total']); ?></th>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <th class="<?php echo $field; ?>"><?php echo Currency::format($totals[$field]); ?></th>
                    <?php endif; ?>
                <?php else: ?>
                    <th></th>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </tfoot>
</table>