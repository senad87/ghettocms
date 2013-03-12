<div class="descView">
<label>Title:</label><br />
<input class="instant-update lform2" id="title" name="image-title" type="text" value="<?php if(count($images) == 1 && $images[0]['title']){ echo $images[0]['title'];} ?>" /><br />


<label>Lead:</label><br />
<textarea class="instant-update lform2-textarea" id="lead" name="image-lead"><?php if(count($images) == 1 && $images[0]['lead']){ echo $images[0]['lead'];} ?></textarea>

<input id="ids" type="hidden" value=<?php echo $ids; ?> />
</div>
