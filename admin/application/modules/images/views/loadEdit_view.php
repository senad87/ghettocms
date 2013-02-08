<?php //print_r(count($images)); ?>
Title:<input id="title" name="title" type="text" value="<?php if(count($images) < 2){ echo $images[0]->title;} ?>" /><br />
<!--Tags:<input id="tags" name="tags" type="text" value="<?php if(count($images) < 2){ echo $images[0]->tags;} ?>" />-->
<a id="update" href="#" >Update</a>
<input id="submit" name="title" type="hidden" value="" />

<input id="ids" type="hidden" value=<?php echo $ids; ?> />

