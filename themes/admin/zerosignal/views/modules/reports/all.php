<div class="report-filters invoice-block">
    <div class="filters">
        <div class="form-holder">
            <?php echo form_open(uri_string()); ?>
            <fieldset>
                <div class="row">
                    <div class="date">
                        <label for="client_id"><?php echo __('reports:datefrom') ?>:</label>
                        <input type="text" onchange="processFilters()" class="from text txt datePicker" name="from" value="<?php echo $from_input; ?>">
                        <label for="client_id" class="clientlabel"><?php echo __('reports:byclient') ?>:</label>
                        <div class="sel-item"><?php echo form_dropdown('client_id', $clients_dropdown, $client_id, 'onchange="processFilters()"'); ?></div>
                    </div>
                    <div class="client">
                        <label for="client_id"><?php echo __('reports:dateto') ?>:</label>
                        <input type="text" onchange="processFilters()" class="to text txt datePicker" name="to" value="<?php echo $to_input; ?>">
                        <a href="#" onclick="processFilters()" class="yellow-btn"><span><?php echo __('reports:show_all') ?></span></a>
                    </div>
                </div>
            </fieldset>
            <?php echo form_close(); ?>
        </div>
    </div><!-- /filters -->
</div>
<div class="overview-container">
    <div class="overviews">
        <?php foreach ($reports as $report) : ?>
            <?php echo $report; ?>
        <?php endforeach; ?>
    </div>
</div>
<script>
    function processFilters() {
        var from = $('.from.datePicker').datepicker( "getDate" );
        var to = $('.to.datePicker').datepicker( "getDate" );
        
        to.setDate(to.getDate() + 1);
        to.setTime(to.getTime() - 1000);
        
        from.setDate(from.getDate() + 1);
        from.setTime(from.getTime() - 1000);
        
        from = (from ? from.getTime() / 1000 : 0);
        to = to ? to.getTime() / 1000 : 0;
        
        if (to < from) {
            to = from;
        }
        
        var client = $('select[name=client_id]').val();
        
        window.location.replace('<?php echo site_url('admin/reports/all')?>/from:'+from+'-to:'+to+'-client:'+client);
    }
</script>