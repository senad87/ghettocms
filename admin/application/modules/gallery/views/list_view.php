<div class="headcont">
<h1 class="heading">Galleries Management</h1>
<?php echo modules::run('toolbar', 'gallery_title', 'gallery', array('new', 'publish', 'unpublish', 'delete')); ?>	
<div class="clear"></div>
</div>
<div class="container">
<div class="right-panel">
<h5>Search</h5>
<div class="box-right-panel">
<div class="box-right-panel-inbox">
Enter search term:
<input class="search" name="" type="text" />
<input class="button-1"  type="submit" value="Search">

</div>
</div>

<h5 style="margin-top: 15px;">Filter</h5>
<div class="box-right-panel">
    <!--
<div class="box-right-panel-inbox">
By Category:
<select name="" id="select_category" class="filter">
	<option selected="selected">Select category...</option>
	<?php foreach($root_categories as $root_category){ ?>
		<option value="<?php echo $root_category->id; ?>"><?php echo $root_category->name; ?></option>
	<?php } ?>
</select>
</div>
-->
<div id="filter_by_category" class="box-right-panel-inbox">
</div>

<div class="box-right-panel-inbox">

Select Topic:
<select name="" id="select_topic" class="filter">
  <option selected="selected">Select TAG...</option>
  <option>Starcraft</option>
  <option>Diabolo</option>
</select>

</div>

<div class="box-right-panel-inbox">

By Tag:
<select name="" id="select_tag" class="filter">
  <option selected="selected">Select TAG...</option>
  <option>Starcraft</option>
  <option>Diabolo</option>
</select>

</div>

<div class="box-right-panel-inbox">

By Author:
<select name="" id="select_author" class="filter">
<option selected="selected">Select author...</option>
<?php foreach($authors as $author){ ?>
	<option value="<?php echo $author->id; ?>"><?php echo $author->name; ?></option>
<?php } ?>
</select>

</div>


<div class="box-right-panel-inbox">

By State:
<select name="" id="select_state" class="filter">
  <option selected="selected">Select state...</option>
  <?php foreach($states as $state){ ?>
	<option value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></option>
  <?php } ?>
</select>

</div>

<div class="panel-link"><a href="<?=base_url(); ?>gallery/">RESET ALL FILTERS</a></div>

<h5>Properties</h5>
<div class="box-right-panel-inbox">
<label>Set system topics:</label>
<div id="system_topics">
  <?php echo modules::run('topic/selectSystem', 1); ?>
</div>

</div><!-- end box-right-panel-inbox -->
</div>



</div> 

<div class="left-panel">
<?php echo modules::run('table', $entries, array('input|false|false|checkbox', 'text_link|title|Title', 'text|creation_date|Created', 'text|modified_date|Modified', 'text|state|Status', 'text|type_id|ID'), 'gallery'); ?>
</div>
   
<div class="clear"></div>      
</div>
</body>
</html>
