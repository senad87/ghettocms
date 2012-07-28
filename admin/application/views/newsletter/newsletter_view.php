<div class="headcont">
<h1 class="heading">Newsletter</h1>		
<div class="clear"></div>
</div>
<?php if(isset($message)){echo $message;}?><br />
<button id="add_story" class="button-1">Add Stories</button>
<!--  <button class="button-1">Send</button>-->

<form action="<?php echo base_url(); ?>newsletter/send/" method="POST"> 
	<input class="button-1"  type="submit" value="Send" />
	<div id="newsletter-content" class="content" ></div>
</form>



<div id="stories-dialog" style="display: none;" title="Add Story To Newsletter">
<div id="content">
<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		<th width="35" style="text-align: center;">ID</th>
		<th style="text-align: center;" width="10">#</th>
		<th width="300" align="left">Title</th>
		</tr>
		</thead>
		<?php $i=0; ?>
		<?php if (isset($stories)){ ?>
		<?php foreach($stories as $story) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="right"><?php echo $story->id; ?></td>
			<td align="center" width="20"><input type="checkbox" name="story_id" value="<?php echo $story->id; ?>"></td>
			<td align="left"><?php echo $story->title; ?></td>
			</tr>
		<?php $i++; ?>
		<?php } ?>
		<?php }else{ ?>
   			<tr><td colspan="8"><?php echo $no_entries; ?></td></tr>
   	 	<?php } ?>
		<tfoot>
			<tr>
		<th colspan="8"><div><?php echo $pagination; ?></div></th>
		</tr>
		</tfoot>
</table>
</div>
</div>


<script type="text/javascript">
$(document).ready(function(){
	var checked = Array();
$("#add_story").live('click', function() {
	$("#stories-dialog").dialog({
			resizable: false,
			width:850,
			modal: true,
			buttons: {
				"Add": function(){
					//alert('test');
						$("input:checked").each(function(index, input_object){
							checked[index] = input_object.value; //value is actualy story id that is checked 
						});
						//alert(checked);
						url="<?php echo base_url();?>newsletter/add_stories/";
						data={ids: checked};
						$("#newsletter-content").load(url, data);
						$(this).dialog( "close" );
				},
				Cancel: function() {
					$(this).dialog( "close" );
				}
			}
		});
	});
});
</script>