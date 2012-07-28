Title:
<input id="title" name="title" type="text" value="<?php if(count($images) == 1 && $images[0]['title']){ echo $images[0]['title'];} ?>" /><br />


Lead:
<textarea id="lead" name="image-lead"><?php if(count($images) == 1 && $images[0]['lead']){ echo $images[0]['lead'];} ?></textarea>




<a id="update" href="#" >Update</a>

<input id="ids" type="hidden" value=<?php echo $ids; ?> />

