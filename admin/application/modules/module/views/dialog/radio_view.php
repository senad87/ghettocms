<label><strong><?php echo $label; ?></strong></label><br />
<?php $i = 0;
	//TODO: fix this foreach
	foreach ($options as $option){
		$value = $options->item($i)->getAttribute('value');
		echo "<input class='$cssclass' type='radio' name='$name' value='$value'";
		if ($value == $default){
			echo "checked='checked'";
		}
		echo ">";
		echo $options->item($i)->nodeValue;
		echo "</option><br />";
		$i++;
	}
?><br />