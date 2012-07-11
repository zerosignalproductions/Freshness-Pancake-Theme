<div class="pageContainer">
    <?php foreach ($proposal['pages'] as $key => $page) : ?>
        <div class="page page-<?php echo $key; ?>" data-key="<?php echo $key; ?>">
            <div class="sectionContainer">
                <?php foreach ($page['sections'] as $key => $section) : ?>
                    <div data-type="<?php echo $section['section_type'];?>" class="section section-<?php echo $key;?>" data-key="<?php echo $key;?>">
                        <a href="#" class="savePremadeSection" data-saved="<?php echo __('proposals:saved');?>" data-saving="<?php echo __('proposals:saving');?>" data-save="<?php echo __('proposals:savepremade');?>"><?php echo __('proposals:savepremade');?></a>
                        <h2 class="section-title editable <?php echo empty($section['title']) ? 'empty-stuffs' : null;?>"><?php echo empty($section['title']) ? __('proposals:emptysection') : $section['title']; ?></h2>
                        <h3 class="section-subtitle editable <?php echo empty($section['subtitle']) ? 'empty-stuffs' : null;?>"><?php echo empty($section['subtitle']) ? __('proposals:emptysubtitle') : $section['subtitle']; ?></h3>
                        <div data-estimate-id="<?php echo $section['estimate_id']; ?>" class="section-contents <?php echo ($section['section_type'] == 'section') ? null : $section['section_type']; ?> <?php echo $section['section_type'] == 'section' ? 'editable' : $section['section_type'];?> <?php echo empty($section['contents']) ? 'empty-stuffs' : null;?>">
                            <?php if ($section['section_type'] == 'section') :?>
                                <?php echo empty($section['contents']) ? __('proposals:emptycontents') : $section['contents']; ?>
                            <?php else: ?>
                                <?php echo $section['contents'];?>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a href="" class="addSection"><?php echo __('proposals:createsection');?></a>
            <a href="" class="addPremadeSection"><?php echo __('proposals:createpremadesection');?></a>
            <a href="" class="addEstimate"><?php echo __('proposals:addestimate');?></a>
        </div>
    <?php endforeach; ?>
</div>
<div class="page samplePage">
    <div class="sectionContainer"></div>
    <a href="" class="addSection"><?php echo __('proposals:createsection');?></a>
    <a href="" class="addPremadeSection"><?php echo __('proposals:createpremadesection');?></a>
    <a href="" class="addEstimate"><?php echo __('proposals:addestimate');?></a>
</div>
<div class="section sampleSection">
    <a href="#" class="savePremadeSection" data-saved="<?php echo __('proposals:saved');?>" data-saving="<?php echo __('proposals:saving');?>" data-save="<?php echo __('proposals:savepremade');?>"><?php echo __('proposals:savepremade');?></a>
    <h2 class="section-title editable"></h2>
    <h3 class="section-subtitle editable"></h3>
    <div class="section-contents editable"></div>
</div>
<a href="" class="addPage"><?php echo __('proposals:createpage');?></a>
<script>
pagexofcount = '<?php echo __('proposals:pagexofcount')?>';
</script>
<script src="<?php echo asset::get_src('proposals.js', 'js');?>"></script>