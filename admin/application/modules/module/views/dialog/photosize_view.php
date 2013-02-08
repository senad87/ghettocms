<label><strong><?php echo $label; ?></strong></label><br />
<?php $i = 0;
	//TODO: fix this foreach
	foreach ($dimensions as $dimension){
		
		echo "<input class='$cssclass' type='radio' name='$name' value='$dimension->id'";
		if ( $dimension->id == $default ){
			echo "checked='checked'";
		}
		echo ">";
		echo $dimension->name . " (" . $dimension->width . "x" . $dimension->height . ")";
		echo "</option><br />";
		$i++;
	}
?><br />
