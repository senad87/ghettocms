<div class="headcont">
<h1 class="heading">Edit Comment</h1>
<?php echo modules::run('toolbar', 'comments_title', 'comments', array('save', 'cancel')); ?>	
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
	<?php echo form_open_multipart('comments/edit_post/', array('id'=>'comments_form'));?>
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
		</p>
	</form>   
</div>
</div>
</body>
</html>
