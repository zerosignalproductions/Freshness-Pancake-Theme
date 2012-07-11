<div id="content">
    <h1><?php echo $client->first_name; ?> <?php echo $client->last_name; ?><br><?php echo $client->company; ?></h1>
    

    <div class="comment-row <?php echo ($comment->user_id != null ? get_user_full_name_by_id($comment->user_id) : 'client'); ?>">
        <p class="comment-meta"><span class="orange"><?php echo $comment->user_name; ?></span> <?php echo __('kitchen:saidon', array(format_date($comment->created), format_time($comment->created))) ?> <a class="comment_delete_link" href="<?php echo site_url(Settings::get('kitchen_route') . "/" . $client->unique_id . "/delete_comment/" . $comment->id); ?>"><?php echo __('global:delete'); ?></a></p>
        <p class="comment-body"><?php echo str_replace(array("\n\n", "\n"), array('</p><p>', '<br>'), $comment->comment); ?></p>
        <?php if (count($comment->files)): ?>
            <div id="files">
                <p><?php echo __('kitchen:attachment') ?>:</p>
                <ul class="list-of-files">
                    <?php foreach ($comment->files as $file): ?>

                        <?php
                        $ext = explode('.', $file->orig_filename);
                        end($ext);
                        $ext = current($ext);
                        ?>
        <?php $bg = asset::get_src($ext . '.png', 'img'); ?>
        <?php $style = empty($bg) ? '' : 'style="background: url(' . $bg . ') 1px 0px no-repeat;"'; ?>

                        <li><a class="file-to-download" <?php echo $style; ?> href="<?php echo site_url(Settings::get('kitchen_route') . '/' . $client->unique_id . '/download/' . $comment->id . '/' . $file->id); ?>"><?php echo $file->orig_filename; ?></a></li>

            <?php endforeach; ?>
                </ul>
            </div><!-- /files -->
        <?php endif ?>
    </div>
    <div id="comment-form">
        <h3>Edit comment</h3>
            <?php echo form_open_multipart(Settings::get('kitchen_route') . "/" . $client->unique_id . "/edit_comment/" . $comment->id . "/" .$item_type.'/'.$item_id, 'id="comment-form"'); ?>
        <div class="row v-top">
            <label for="comment"><?php echo __('kitchen:comment') ?>:</label>
            <?php
            echo form_textarea(array(
                'name' => 'comment',
                'id' => 'comment',
                'rows' => 10,
                'cols' => 80,
                'class' => 'txt',
                'value' => set_value('comment', $comment->comment),
            ));
            ?>
        </div>
        <div class="row file-holder">
            <label for="file"><?php echo __('kitchen:file') ?>:</label>
<?php echo form_upload('files[]'); ?>
        </div>
        <div>
            <input type="submit" class="hidden-submit button" value="<?php echo __('kitchen:edit_comment') ?>" />
        </div>
<?php echo form_close(); ?>
    </div>
</div>