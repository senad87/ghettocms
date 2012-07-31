Title:
<input class="instant-update" id="title" name="image-title" type="text" value="<?php if(count($images) == 1 && $images[0]['title']){ echo $images[0]['title'];} ?>" /><br />


Lead:
<textarea class="instant-update" id="lead" name="image-lead"><?php if(count($images) == 1 && $images[0]['lead']){ echo $images[0]['lead'];} ?></textarea>




<!--<a id="update" href="#" >Update</a>-->

<input id="ids" type="hidden" value=<?php echo $ids; ?> />

