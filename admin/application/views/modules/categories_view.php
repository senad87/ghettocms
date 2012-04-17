<label><?php echo $label; ?></label>
<select style="width: 270px; height: 300px;" multiple="multiple" size="30"  id="selections" name="categories[]"> 
         
        <?php foreach($root_categories as $category){ ?>
        	<?php if (check_category_kids($category->id) == 0) {?>
        	<option value="<?php echo $category->id;?>"><?php echo $category->name;?></option>
        	<?php } else { ?>
            <optgroup label="<?php echo $category->name; ?>">
            <?php 
            $level = ".&nbsp;&nbsp;";
            recursion_categories_multiselect($category->id, $level); ?>
            </optgroup> 
            <?php } } ?> 
</select>
<script type="text/javascript">
	 function allselections() { 
            var e = document.getElementById('selections'); 
            //e.disabled = true; 
            var i = 0; 
            var n = e.options.length; 
            for (i = 0; i < n; i++) { 
                //e.options[i].disabled = true; 
                e.options[i].selected = true; 
            } 
     } 
     function disableselections() { 
           var e = document.getElementById('selections'); 
           //e.disabled = true; 
           var i = 0; 
           var n = e.options.length; 
           for (i = 0; i < n; i++) { 
               //e.options[i].disabled = true; 
               e.options[i].selected = false; 
           } 
    } 
    function enableselections() { 
          var e = document.getElementById('selections'); 
          e.disabled = false; 
          var i = 0; 
          var n = e.options.length; 
          for (i = 0; i < n; i++) { 
               e.options[i].disabled = false; 
           } 
   } 
</script> 