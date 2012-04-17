<div class="headcont">
<h1 class="heading">Edit Comment</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
	
<div class="clear"></div>
</div>

<div class="container">
<div class="right-panel">
<h5>Properties</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">There is no properties for this item. 
</div>
</div>
</div>
<div class="left-panel">


<form action="<?php echo base_url(); ?>comments/edit_post/" method="POST" >

<p>
					<label for="name"><strong>Name</strong></label><br />
					<input class="lform2" type="text" value="<?php echo $comment->name;?>" maxlength="64" size="32" name="name" >
				</p>
				<p>
					<label for="email"><strong>Email</strong></label><br />
					<input class="lform2" type="text" value="<?php echo $comment->email;?>" maxlength="64" size="32" name="email">
				</p>
				<p>
					<label for="comment"><strong>Comment</strong></label><br />
					<textarea class="lform2-textarea" name="body" ><?php echo $comment->body;?></textarea>
				</p>
				<p>
				<input type="hidden" value="<?php echo $comment->id;?>" name="id">
				<input type="hidden" value="<?php echo $offset;?>" name="offset">
				<input class="button-1" id="sub" type="submit" value="Save" name="cmtsbmt">
                <input class="button-1" type="button" value="Cancel"> <- ne radi :D
				</p>
                
             </form>   
             </div>
</div>
</body>
</html>