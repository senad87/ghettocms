<link href="<?php echo base_url();?>system/application/views/css/smoothness/jquery-ui.custom.css" rel="stylesheet" type="text/css" /> 
<style type="text/css">
.container {
	width: 95%;
	margin: 20px;
	background-color: #c9edff;
}

.module-box {

}


.clear {
	clear: both;
}

.header-box {
	padding: 10px;
}

.banner-top {
	height: 150px;
	background-color: #6CF;
}

.left-box {
	width: 67%;
	float: left;
	padding: 10px 0 10px 10px;

}

.right-box {
	width: 27%;
	float: right;
	padding: 10px 10px 10px 0;
}


.story-list {
	height: 400px;
	background-color: #6CF;
}


.module-box {
	margin-bottom: 10px;
	background-color: #6CF;
}
</style>
<div class="header-box">
	<div id="position1" class="banner-top"><input class="add-module" id="1" type="button" value="+ Add Module" />
	</div>
</div>
<div class="left-box">
<div id="position2" class="story-list"><input class="add-module" id="2" type="button" value="+ Add Module" />
</div>    
</div>

<div class="right-box">
	<div id="position3" class="module-box"><input class="add-module" id="3" type="button" value="+ Add Module" />
	</div>
	<div id="position4" class="module-box"><input class="add-module" id="4" type="button" value="+ Add Module" />
	</div>
	<div id="position5" class="module-box"><input class="add-module" id="5" type="button" value="+ Add Module" />
	</div>
	<div id="position6" class="module-box"><input class="add-module" id="6" type="button" value="+ Add Module" />
	</div>
</div>
<div class="clear"></div>
<!-- hidden elements for dialogs on this page -->
<div id="dialog-confirm" style="display: none;" title="Create New Module">
	<p style="padding-bottom: 15px;"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Choose Module type to create new module instance:</p>
	<select id="select-module" name="module" class="filter">
		<option value="0">Select module</option>
		<?php foreach($modules as $module){?>
		<option value="<?php echo $module; ?>"><?php echo $module; ?></option>
		<?php } ?>
	</select>
</div>
<div id="dialog-edit" style="display: none;" title="Edit Module Properties">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Set module instance properties:</p>
	<div id="module-properties" style="overflow: auto;"></div>
</div>
<input type="hidden" id="num-of-positions" value="<?php echo $template[0]->num_of_positions; ?>">
<!-- END OF hidden elements for dialogs on this page -->
<script type="text/javascript">
//select all checkboxes in the list
$(document).ready(function()
{
	var menu_id = $("#menu-id").val();
	
	//on load this page get menu_id and over ajax request get module for each position on this template
	
	for (i=1;i<=$("#num-of-positions").val();i++)
	{
		 $.ajax({
			   type: "POST",
			   url: "<?php echo base_url(); ?>module/load",
			   data: "menu_id="+ menu_id +"&position_id="+ i,
			   async: false,
			   success: function(response){
					if(response != 0){
				   		$("#position"+i).empty();
		    			$("#position"+i).append(response);
					}
			   }
		});
	}
	
	$(".add-module").click(function() {
		var position_id = $( this ).attr("id");
		
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			width:350,
			modal: true,
			buttons: {
				"Select": function() {
					//get selected value
					var module = $("#select-module").val();
					//load div with module properties
					$("#module-properties").load("<?=base_url(); ?>module/load_new_module", {module: module}, function(response, status, xhr) {
					  if (status == "error") {
					    var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
					    console.log(msg);
					  }
					});
					$( this ).dialog( "close" );
					
					$( "#dialog-edit" ).dialog({
						resizable: true,
						width:780,
						height: 580,
						modal: true,
						buttons: {
							"Submit": function() {
								//TODO save module instance and display basic properties to selected position
								var fields = $(":input").serializeArray();
								var data = jQuery.param( fields );
								
								$("#position"+position_id).empty();
								
							    $.post("<?php echo base_url(); ?>module/load_add_module", "module="+ module +"&position_id="+ position_id + "&" + data,function(response){
							    	$("#position"+position_id).append(response);
							   });
								$( this ).dialog( "close" );
							},
							Cancel: function() {
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
});
</script>