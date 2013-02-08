<!-- for this input fields both class and ids are important for functionality - DO NOT CHANGE IT -->
<input type="radio" name="sys_topics" id="checkall" class="sys_topic_option"/><label>Check all</label>
<input type="radio" name="sys_topics" id="disableall" class="sys_topic_option"/><label>Uncheck all</label>
<!-- <input type="radio" name="sys_topics" id="enableall" class="sys_topic_option"/><label>Enable</label> -->
<select style="width: 270px; height: 100px;" multiple="multiple" size="30"  id="selections">
	<?php foreach ($topics as $topic){ ?>
		<option value="<?php echo $topic->id;?>" <?php if(in_array($topic->id, $sys_topics_array)){?>selected="selected"<?php } ?> ><?php echo $topic->name;?></option>
	<?php } ?> 
</select>
<input type="button" id="setSystem" value="Save"/>