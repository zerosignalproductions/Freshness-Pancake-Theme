<div id="table_wrapper">
    <table class="data-table">
        <thead>
            <tr>
                <?php if ($count_users > 1) : ?><th class="timesheet_user">User</th><?php endif; ?>
                <th class="timesheet_date"  ><?php echo __('timesheet:date');?></th>
                <th class="timesheet_duration"  ><?php echo __('timesheet:duration');?></th>
                <th class="timesheet_task" ><?php echo __('timesheet:taskname');?> </th>
                <th class="timesheet_notes" ><?php echo __('global:notes');?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($times as $item) : ?>
            <tr>
                <?php if ($count_users > 1) : ?><td class="timesheet_user"><?php echo $item['first_name'].' '.$item['last_name']; ?></td><?php endif; ?>
                <td class="timesheet_date" ><?php echo $item['start_time'];?> - <?php echo $item['end_time'];?><br /><?php echo format_date($item['date']);?></td>
                <td class="timesheet_duration"><?php echo timespan(0, (int) $item['minutes'] * 60);?></td>
                <td class="timesheet_task" ><?php echo $tasks[$item['task_id']]['name'];?></td>
                <td class="timesheet_notes" ><?php echo $item['note'];?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div><!-- /table_wrapper -->
