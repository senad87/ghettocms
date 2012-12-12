<div class="comments-block">
<span id="comm" ></span>
<div class="commentsList" >
<h2 class="komentari">Komentari</h2>
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
<p class="obavezno" ><?php echo $this->lang->line('thank_you'); ?></p>
</div>