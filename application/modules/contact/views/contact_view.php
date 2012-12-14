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
    <span id="comm" ></span>
    <h2 class="komentari"><?php echo $this->lang->line('contact_title'); ?></h2>
    <div class="comments-send" id="commentForm" >
        <form action="<?php echo current_url(); ?>#comm" method="POST" >
            
            <div>
                <label for="name"><?php echo $this->lang->line('contact_name'); ?>*</label>
                <div class="error"><?php echo form_error('name'); ?></div>
                <div class="clear"></div>
                <input type="text" value="<?php echo set_value('name'); ?>" maxlength="64" size="32" name="name" id="name" class="required" >
            </div>
            <div>
                <label for="email"><?php echo $this->lang->line('contact_email'); ?>*</label>
                <div class="error"><?php echo form_error('email'); ?></div>
                <div class="clear"></div>
                <input type="text" value="<?php echo set_value('email'); ?>" maxlength="64" size="32" name="email" id="email" class="required email">
            </div>
            <div>
                <label for="comment"><?php echo $this->lang->line('contact_message'); ?> *</label> <div class="charcounter"><?php echo $this->lang->line('char_left'); ?> <span id="charCount" class="numb">600</span> <?php echo $this->lang->line('chars'); ?></div>
                <div class="error"><?php echo form_error('comment'); ?></div>
                <div class="clear"></div>
                <textarea onkeydown="countChars()" onkeyup="countChars()" name="comment" id="comment" rows="10" cols="70" class="required"><?php echo set_value('comment'); ?></textarea>
            </div>
            <div class="captcha">
                <div><?php print_r($recaptcha); ?></div>
                <div class="error"><?php echo form_error('recaptcha_response_field'); ?></div><br />
                    
                    
            </div>
            <div class="clear"></div>
            <div>
                <input id="menu_id" type="hidden" value="<?php echo $menu_id; ?>" name="menu_id">
                <input class="commButton" id="sub" type="submit" value="<?php echo $this->lang->line('send_comment'); ?>" name="cmtsbmt">
            </div>
    </div>
        
    <div class="obavezno">* <?php echo $this->lang->line('mandatory_fields'); ?></div>
</form>
</div>