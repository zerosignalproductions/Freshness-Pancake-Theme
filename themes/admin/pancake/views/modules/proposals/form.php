<br /><br />
<div id="form_container">
    <div class="invoice-block">
        <div class="head-box">
            <h3 class="ttl ttl3"><?php echo lang('proposals:' . $action . 'proposal'); ?></h3>
        </div><!-- /head-box end -->
        <div class="form-holder">
        </div>
        <?php echo form_open('admin/proposals/' . $action, array('id' => 'create_form')); ?>
        <fieldset>

            <div id="invoice-type-block" class="row">

                <div class="row">
                    <label for="name"><?php echo lang('global:title'); ?></label>
                    <?php echo form_input('title', set_value('title', isset($proposal) ? $proposal->title : ''), 'class="txt"'); ?>
                </div>
                <div class="row">
                    <label for="client_id"><?php echo lang('global:client'); ?></label>
                    <div class="sel-item">
                        <?php echo form_dropdown('client_id', $clients_dropdown, set_value('client_id', isset($proposal) ? $proposal->client_id : 0)); ?>
                    </div>
                    <?php echo anchor('admin/clients/create', '<span>' . __('clients:add') . '</span>', 'class="yellow-btn"'); ?>
                </div>
                
                <div class="row hide-estimate">
				<label for="proposal_number"><?php echo __('proposals:number') ?></label>
				<?php echo form_input('proposal_number', set_value('proposal_number', isset($proposal_number) ? $proposal_number : ''), 'id="proposal_number" class="txt"'); ?>
			</div>

                <br />
                <?php if (isset($proposal)): ?>
                    <input type="hidden" name="id" value="<?php echo $proposal->id; ?>" />
                <?php endif; ?>
                <a href="#" class="yellow-btn" onclick="return $('#create_form').submit();"><span><?php echo lang('proposals:createandedit'); ?></span></a>
            </div>
        </fieldset>
        </form>
    </div>
</div>
<br style="clear: both;" />