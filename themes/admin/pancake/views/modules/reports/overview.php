<div class="report-overview report-<?php echo $report; ?> <?php echo $chart_type;?>">
    <h3 class="title"><?php echo $title; ?> <span class="per"><?php echo $per;?></span></h3>
    
    <div class="graph"></div>
    <div class="total"><?php echo $formatted_total; ?></div>
    <a href="<?php echo $report_url; ?>"><?php echo __('reports:view'); ?></a>
</div>
<script>
    <?php if (count($chart_totals) > 0) :?>
        <?php if ($chart_type == 'pie') :?>
            var data = [<?php $i =0; foreach($chart_totals as $label => $total) {if ($i != 0) {echo ',';} echo "{label: \"$label\", data: $total}";$i = 1;}?>];


        $.plot($(".report-<?php echo $report;?> .graph"), data, {
            series: {
                pie: { 
                    show: true,
                    radius: 1,
                    label: {
                        show: true,
                        radius: 1.75/3,
                        formatter: function(label, series){
                            return '<div style="font-size:8pt;text-align:center;padding:2px;color:white;">'+label+'<br/>'+Math.round(series.percent)+'%</div>';
                        },
                        threshold: 0.1
                    }
                }
            },
            legend: {
                show: false
            }
        });
        <?php else:?>
            var data = [<?php $i =0; foreach($chart_time_points as $label => $times) { $total = '['; foreach ($times as $time => $amount) {$total .= "[".($time * 1000).", $amount], ";} $total = substr($total, 0, strlen($total) - 2).']'; if ($i != 0) {echo ',';} echo "{label: \"$label\", data: $total}";$i = 1;}?>];
            $.plot($(".report-<?php echo $report;?> .graph"), data, {xaxis: {mode: 'time', timeformat: "%m/%d"}});
        <?php endif;?>
    <?php else: ?>
        $(".report-<?php echo $report;?> .graph").html('<?php echo __('reports:nodata', array(strtolower($title)));?>').addClass('no-data');
    <?php endif;?>
</script>