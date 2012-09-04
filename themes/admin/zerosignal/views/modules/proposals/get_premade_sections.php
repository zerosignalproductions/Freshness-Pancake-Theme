<?php if (count($sections) > 0) : ?>
    <table id="premade-sections">
	<?php foreach ($sections as $section) : ?>
	    <tr class="premadeSection" data-premade-id="<?php echo $section['id']; ?>">
		<td>
		    <h2 class="premade-title premade-<?php echo $section['id']; ?>"><?php echo $section['title']; ?></h2>
		    <h3 class="premade-subtitle premade-<?php echo $section['id']; ?>"><?php echo $section['subtitle']; ?></h3>
		    <div class="premade-contents premade-<?php echo $section['id']; ?>"><?php echo trim($section['contents']); ?></div>
		</td>
		<td class="premade-actions">
		    <a class="select-premade" href="#"><?php echo __('proposals:usesectiontemplate');?></a>
		    <a class="delete-premade" href="<?php echo site_url('ajax/delete_premade_section/'.$section['id']);?>"><?php echo __('proposals:deletepremadesection');?></a>
		</td>
	    </tr>
	<?php endforeach; ?>
    </table>
<?php else: ?>
    <p><?php echo __('proposals:nopremadesections') ?></p>
<?php endif; ?>