<div class="headcont">
<h1 class="heading">New Internal Page</h1>
	<?php if (isset($message)) {
		if($message <> ""){ ?>
			 <div class="message" id="message"><?php echo $message; ?></div>
		<?php } ?>
	<?php } ?>
<div class="clear"></div>
</div>
<div class="container">
<div id="right_panel" class="right-panel">
<h5>Choose parent menu item:</h5>
	<div class="box-right-panel">
		<div class="box-right-panel-inbox">
			<div class="table-minicat">
			<table class="data" border="0" cellpadding="0" cellspacing="0">
				<thead>
				</thead>
				<?php foreach ($root_menus as $root_menu) { ?>
					<tr class="rolover">
					<td width="8" align="center"><input type="radio" name="parent_id" class="radio_category_id"  value="<?php echo $root_menu->id; ?>" <?php if($menu[0]->parent_id == $root_menu->id){?>checked="checked"<?php } ?>></td>
					<td><?php echo $root_menu->name; ?></td>
					</tr>
				<?php  $level = ".&nbsp;&nbsp;&nbsp;&nbsp;";
				recursion_menus_right_panel_edit($root_menu->id, $level, $menu[0]->parent_id); 
				} ?>
				<tfoot>
				</tfoot>
			</table>
			</div>
		</div><div class="clear"></div>
	</div>
    
</div>

<div class="left-panel">
<div class="submenu">
	<label for="category_name"><strong>Menu Name:</strong></label><br />
	<input class="lform2" id="menu-name" type="text" name="name" value="<?php echo $menu[0]->name; ?>"><br />    
	<input type="hidden" id="menu-id" name="menu_id" value="<?php echo $menu[0]->id; ?>">
	<select class="filter2" id="menu_type" name="menu_type">
		<?php foreach($menu_types as $type){?>
		<option value="<?php echo $type->id; ?>" <?php if($type->id == $menu[0]->menu_type_id){?>selected="selected"<?php }?>><?php echo $type->name; ?></option>
		<?php } ?>
		</select>
</div>
<div class="layout-bottom">
	<!-- External Url -->
	<div id="external_url" <?php if($menu[0]->menu_type_id != 3){ ?>style="display:none;"<?php } ?>>
				<label for="category_name"><strong>Url:</strong></label><br />
				<input class="lform2" type="text" name="url" id="url" value="<?php if(isset($menu[0]->url) && $menu[0]->url != "") echo $menu[0]->url; ?>"></textarea><br />
				
				<input type="checkbox" name="new_window" id="new_window" value="1" <?php if($menu[0]->open_in == 1){?>checked="checked"<?php }?>>
                <label for="category_name"><strong>Open in new tab:</strong></label>			
	</div><br />
	<!-- END OF External Url -->
	<!-- Tabs Start -->
	<div id="tabs" <?php if($menu[0]->menu_type_id != 1){ ?>style="display:none;"<?php } ?>>
		<ul>
			<li><a href="#tabs-1">Landing page</a></li>
			<li><a href="#tabs-2">Story page</a></li>
	
		</ul>
		<div id="tabs-1">
			<label for="template_name"><strong>Templates:</strong></label><br />
			<select class="filter" style="width: 300px;" id="selectTemplate">
				<option value="0">Select ...</option>
				<option value="parent">Same as parent</option>
				<?php foreach($templates as $template){ ?>
				<option value="<?php echo $template->id; ?>" <?php if($menu[0]->template_id == $template->id){?>selected="selected"<?php } ?> ><?php echo $template->name; ?></option>
				<?php } ?>
			</select>
		<div id="preset_options">
		<a href="javascript:;" id="savePreset">Save layout as preset</a><br />
		<a href="javascript:;" id="loadPreset">Load preset</a>
		</div>	
		<div id="container" style="width: 100%; margin-top: 20px; background-color: #c9edff;"></div>
		<div id="error"></div>	
		</div>
		<div id="tabs-2">
	
			<p>2 Morbi tincidunt, dui sit amet facilisis feugiat, odio metus gravida ante, ut pharetra massa metus id nunc. Duis scelerisque molestie turpis. Sed fringilla, massa eget luctus malesuada, metus eros molestie lectus, ut tempus eros massa ut dolor. Aenean aliquet fringilla sem. Suspendisse sed ligula in ligula suscipit aliquam. Praesent in eros vestibulum mi adipiscing adipiscing. Morbi facilisis. Curabitur ornare consequat nunc. Aenean vel metus. Ut posuere viverra nulla. Aliquam erat volutpat. Pellentesque convallis. Maecenas feugiat, tellus pellentesque pretium posuere, felis lorem euismod felis, eu ornare leo nisi vel felis. Mauris consectetur tortor et purus.</p>
		</div>
	
	</div>
	<!-- Tabs END -->
    <input class="button-1" type="button" id="saveChanges" value="Save Changes"/>
	<input class="button-1" type="button" id="deleteLayout" value="Remove Layout"/>
</div>
</div>

</div>
<!-- hidden elements for dialogs on this page -->
<div id="dialog-load-preset" style="display: none;" title="Choose which preset to use to fill layout with modules">
	<div id="preset-list">
	</div>
</div>
<!-- END of hidden -->
<script type="text/javascript">

$(document).ready(function()
{
	var template_id = $('#selectTemplate').val();
	var menu_id = $("#menu-id").val();
	//load template if menu does not have set template
	if(template_id != 0){
		$("#container").load("<?=base_url(); ?>template/load", {id: template_id, menu_id: menu_id}, function(response, status, xhr) {
			  if (status == "error") {
			    var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
			    console.log(msg);
			  }
		});
	}
	//load template when user choose template from drop down
	$('#selectTemplate').change(function()				
	{
		var id = $(this).val();

		$("#container").load("<?=base_url(); ?>template/load", {id: id, menu_id: menu_id}, function(response, status, xhr) {
			  if (status == "error") {
			    var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
			    console.log(msg);
			  }
		});
	});
	//save menu name, parent_id and type changes
	$("#saveChanges").click(function()				
	{
		var menu_name = $("#menu-name").val();
		//url for external url item
		var url = $("#url").val();
		var new_window = $("#new_window").val();
		var menu_type = $("#menu_type").val();
		var parent_menu_id = $("input[name='parent_id']:checked").val();
		//alert(parent_menu_id);
		if(menu_name != ""){
		$.post("<?php echo base_url(); ?>menu/save_changes", "menu_id="+ menu_id +"&menu_name="+ menu_name +"&url="+ url +"&new_window="+ new_window +"&menu_type="+ menu_type+"&parent_menu_id="+ parent_menu_id,function(response){
	    	alert("Changes save succesfully!");
	    	$("#right_panel").empty();
	    	$("#right_panel").append(response);
	   });
		}else{
			alert("Menu name is required field!");
		}	   
	});
	//change menu types
	$("#menu_type").change(function()				
	{
		var type_id = $(this).val();
		if(type_id == 3){
			$("#external_url").removeAttr("style");
			$("#tabs").attr("style","display:none;");
		} else if(type_id == 1) {
			$("#tabs").removeAttr("style");
			$("#external_url").attr("style","display:none;");
		}
	});

	//save layout as preset
	$("#savePreset").live('click', function(){
		//alert("Saved");
		var template_id = $('#selectTemplate').val();
		var menu_id = $("#menu-id").val();
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );

		$( "#dialog-save-preset" ).dialog({
			resizable: false,
			width:350,
			modal: true,
			buttons: {
				"Select": function() {
					//get data from inputs
					var preset_name = $('#preset-name').val();
					var preset_description = $('#preset-description').val();
					//load div with module properties
					
					$.ajax({
						   type: "POST",
						   url: "<?php echo base_url(); ?>preset/save",
						   data: "menu_id="+ menu_id +"&template_id="+ template_id +"&name="+ preset_name+"&description="+ preset_description,
						   async: false,
						   success: function(response){
							   $("#save-message").append(response);
						   }
					});
					$( this ).dialog( "close" );
					
					$( "#save-preset-message" ).dialog({
						resizable: true,
						width: 200,
						height: 100,
						modal: true,
						buttons: {
							"Close": function() {
								$( this ).dialog( "close" );
							}
						}
					});
					
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
	});

	//load preset
	$("#loadPreset").live('click', function(){
		//load preset list
		$("#preset-list").load("<?=base_url(); ?>preset/load_list", function(response, status, xhr) {
			  if (status == "error") {
			    var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
			    console.log(msg);
			  }
		});
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );

		$( "#dialog-load-preset" ).dialog({
			resizable: false,
			width:1000,
			modal: true,
			buttons: {
				"Fill": function() {
					
					//var preset_id = $("input:checked").val();
					var preset_id = $('input[name=item_id]:radio').val();
					$.ajax({
						   type: "POST",
						   url: "<?php echo base_url(); ?>preset/load",
						   data: "menu_id="+ menu_id +"&preset_id="+ preset_id,
						   async: false,
						   timeout: 30000,
						   success: function(response){
							   //location.reload();
							   var id = response;
							   //alert(id);
							  $("#container").load("<?=base_url(); ?>template/load", {id: id, menu_id: menu_id}, function(response, status, xhr) {
									  if (status == "error") {
									    var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
									    console.log(msg);
									  }
								});
						   }
					});
					$( this ).dialog( "close" );	
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});	
	});

	
});
</script>
</body>
</html>