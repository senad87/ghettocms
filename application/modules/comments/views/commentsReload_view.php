<div class="comments-send" id="commentForm" >
<p>
					<label for="name">Име*</label>
					<div class="error"><?php echo form_error('name'); ?></div><br />
					<input type="text" value="<?php echo set_value('name');?>" maxlength="64" size="32" name="name" id="name" class="required" >
				</p>
				<p>
					<label for="email">Електронска пошта*</label>
					<div class="error"><?php echo form_error('email'); ?></div><br />
					<input type="text" value="<?php echo set_value('email');?>" maxlength="64" size="32" name="email" id="email" class="required email">
				</p>
				<p>
					<label for="comment">Ваш коментар* <div class="charcounter">(Преостало <span id="charCount" class="numb">600</span> карактера)</div></label>
					<div class="error"><?php echo form_error('comment'); ?></div><br />
					<textarea onkeydown="countChars()" onkeyup="countChars()" name="comment" id="comment" rows="10" cols="70" class="required"><?php echo set_value('comment');?></textarea>
				</p>
				<p>
				<?php echo form_error('recaptcha_response_field'); ?>
				<?php print_r($recaptcha); ?>
				</p>
				<p>
					<input id="menu_id" type="hidden" value="<?php echo $menu_id; ?>" name="menu_id">
					<input id="item_id" type="hidden" value="<?php echo $item_id;?>" name="item_id">
					<input id="sub" type="submit" value="Pošalji" name="cmtsbmt">
</p>
</div>
<div class="obavezno">* Ова поља су обавезна.</div>