<h2><?php echo __('gateways:payment_details'); ?></h2>
<form method="post" action="" class="client_fields">
<?php if (isset($errors)) :?>
<div class="errors">
    <?php foreach ($errors as $error) : ?>
	<p><?php echo $error;?></p>
    <?php endforeach; ?>
</div>
<?php endif;?>
<?php foreach ($client_fields as $key => $field) : ?>
    <div class="row">
	<label for="<?php echo $key;?>"><?php echo $field['label'];?></label>
	<?php if ($field['type'] == 'text') : ?>
	    <input type="text" name="client_fields[<?php echo $key;?>]" id="<?php echo $key;?>" />
	<?php elseif ($field['type'] == 'select') : ?>
	    <select name="client_fields[<?php echo $key;?>]" id="<?php echo $key;?>">
		<?php foreach($field['options'] as $option_value => $option_label) : ?>
		    <option value="<?php echo $option_value; ?>"><?php echo $option_label; ?></option>
		<?php endforeach; ?>
	    </select>
	<?php elseif ($field['type'] == 'mmyyyy'): ?>
	    <select name="client_fields[<?php echo $key;?>][m]">
	    <?php for ($i = 1; $i <= 12; $i++) :?>
		<option value="<?php echo str_pad($i, 2, "0", STR_PAD_LEFT);?>"><?php echo str_pad($i, 2, "0", STR_PAD_LEFT) ?></option>
	    <?php endfor;?>
	    </select>
	    <select name="client_fields[<?php echo $key;?>][y]">
	    <?php for ($i = (date('Y')); $i <= (date('Y') + 10); $i++) :?>
		<option value="<?php echo $i;?>"><?php echo $i; ?></option>
	    <?php endfor;?>
	    </select>
	<?php endif; ?>
    </div>
<?php endforeach; ?>
    <div class="row">
	<button type="submit" name="submit"><?php echo __('partial:proceedtopayment');?></button>
    </div>
</form>