<label><strong><?php echo $label; ?></strong></label>
<select name="<?php echo $name; ?>" class="<?php echo $cssclass; ?>">
<?php foreach ($clients as $client){ ?>
<option value="<?php echo $client->id; ?>"><?php echo $client->table_name; ?></option>
<?php } ?>
</select><br />
