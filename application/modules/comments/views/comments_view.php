<script type="text/javascript">
function countChars(){
			var len = document.getElementById('comment').value.length;
			var lmt = 600;
			if (len > lmt) {
				document.getElementById('comment').value = document.getElementById('comment').value.substring(0,lmt);
				len = lmt;
			  }
			document.getElementById('charCount').innerHTML = lmt - len;
		}
</script>


<div class="comments-block" >
<div class="commentsList" >
<h2 class="komentari" id="commlist">Komentari</h2>
<ul >
<?php if($comments != false){ ?>
			
	<?php foreach($comments as $comment){?>
	<li class="comment">
		<div class="comment-wrap" id="<?php echo $comment->id; ?>">
		<div class="comment-name"><?php echo $comment->name; ?></div><div class="comment-date"><?php echo srb_date($comment->createdDate); ?></div>
		<div class="comment-body"><?php echo $comment->body; ?></div></div>
	</li>
	<?php } ?>
<?php }else{ ?>
<p class="obavezno" ><?php echo $this->lang->line('first_to_comment'); ?></p>
<?php } ?>
</ul>
</div>

<span id="comm" ></span>
<!--<div  class="komentari"><?php echo $this->lang->line('write_a_comment'); ?></div>-->
<h2 class="komentari">Ostavite komentar:</h2>
<div class="comments-send" id="commentForm" >
<form action="<?php echo current_url(); ?>#comm" method="POST" >

<div>
					<label for="name"><?php echo $this->lang->line('comment_name'); ?>*</label>
					<div class="error"><?php echo form_error('name'); ?></div>
					<div class="clear"></div>
               <input type="text" value="<?php echo set_value('name');?>" maxlength="64" size="32" name="name" id="name" class="required" >
				</div>
				<div>
					<label for="email"><?php echo $this->lang->line('comment_email'); ?>*</label>
					<div class="error"><?php echo form_error('email'); ?></div>
               <div class="clear"></div>
					<input type="text" value="<?php echo set_value('email');?>" maxlength="64" size="32" name="email" id="email" class="required email">
				</div>
				<div>
					<label for="comment"><?php echo $this->lang->line('your_comment'); ?> *</label> <div class="charcounter"><?php echo $this->lang->line('char_left'); ?> <span id="charCount" class="numb">600</span> <?php echo $this->lang->line('chars'); ?></div>
					<div class="error"><?php echo form_error('comment'); ?></div>
               <div class="clear"></div>
					<textarea onkeydown="countChars()" onkeyup="countChars()" name="comment" id="comment" rows="10" cols="70" class="required"><?php echo set_value('comment');?></textarea>
				</div>
				<div class="captcha">
					<div><?php print_r($recaptcha); ?></div>
                    <div class="error"><?php echo form_error('recaptcha_response_field'); ?></div><br />
					
                    
				</div>
            <div class="clear"></div>
				<div>
					<input id="menu_id" type="hidden" value="<?php echo $menu_id; ?>" name="menu_id">
					<input id="item_id" type="hidden" value="<?php echo $item_id;?>" name="item_id">
					<input class="commButton" id="sub" type="submit" value="<?php echo $this->lang->line('send_comment'); ?>" name="cmtsbmt">
			</div>
</div>

<div class="obavezno">* <?php echo $this->lang->line('mandatory_fields'); ?></div>
</form>
</div>
<!--  <script type="text/javascript">
$(document).ready(function(){
  
	$('#sub').live('click', function(){
		$('#target').submit();
	//$('#sub').click(function(){
		var name = $('#name').val();
		var email = $('#email').val();
		var comment = $('#comment').val();
		var menu_id = $('#menu_id').val();
		var item_id = $('#item_id').val();
		var url = '<?php echo base_url();?>comments/comment_post/';
		var data = {name: name, email: email, comment: comment, menu_id: menu_id, item_id: item_id};
		$('#commentForm').load(url, data);		
	});

    
 });
		
</script>-->