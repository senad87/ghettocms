<label><strong><?php echo $label; ?></strong></label>
<select class="<?php echo $cssclass; ?>" name="<?php echo $name; ?>">
<?php $i = 0;
		//TODO: fix this foreach
		foreach ($options as $option){
			$value = $options->item($i)->getAttribute('value');
			echo "<option value='$value'";
			if ($value == $default){
				echo "selected='selected'";
			}
			echo ">";
			echo $options->item($i)->nodeValue;
			echo "</option>";
			$i++;
		}
		echo "</select>";
?>
</select><br />