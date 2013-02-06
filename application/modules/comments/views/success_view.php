<div class="comments-block">
<span id="comm" ></span>
<div class="commentsList" >
<div class="komentari">Komentari</div>
<ul >
<?php if($comments != false){ ?>		
	<?php foreach($comments as $comment){ ?>
	<li class="comment">
		<div class="comment-wrap" id="<?php echo $comment->id; ?>">
		<div class="comment-name"><?php echo $comment->name; ?></div><div class="comment-date"><?php echo $comment->createdDate; ?></div>
		<div class="comment-body"><?php echo $comment->body; ?></div></div>
	</li>
	<?php } ?>
<?php } ?>
</ul>
</div>
<div class="messageSuccess" ><?php echo $this->lang->line('thank_you'); ?></div>
</div>