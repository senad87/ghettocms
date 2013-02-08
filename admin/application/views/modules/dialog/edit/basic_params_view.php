<label for="title"><strong>Module name:</strong></label><br />
<input class="lform2" style="width: 700px;" type="text" name="module_title" size="50" value="<?php echo $module[0]->title; ?>"><br />
<label for="lead"><strong>Module Desription:</strong></label><br />
<textarea class="lform2-textarea" style="width: 700px;" name="module_description" cols="50" rows="5"><?php echo $module[0]->description; ?></textarea><br />
<input type="hidden" name="module_id" value="<?php echo $module[0]->id; ?>" />