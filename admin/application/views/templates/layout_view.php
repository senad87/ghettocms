<link href="<?php echo base_url();?>system/application/views/css/smoothness/jquery-ui.custom.css" rel="stylesheet" type="text/css" /> 
<!-- hidden elements for dialogs on this page -->
<div id="dialog-confirm" style="display: none;" title="Create New Module">
	<p style="padding-bottom: 15px;"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Choose Module type to create new module instance:</p>
	<table class="data" border="0" cellpadding="0" cellspacing="0">
		<thead>
		<tr>
		
		<th style="text-align: center;" width="10">#</th>
		<th width="300" align="left">Module name</th>
		<th width="180" style="text-align: center;">Instance</th>
		</tr>
		</thead>
		<?php 
		$i=0;
		if (isset($modules)){
		foreach($modules as$module) { ?>
			<tr class="rolover" <?php if ($i%2 == 0){ ?> bgcolor="#f3f3f3" <?php } ?>>
			<td align="center" width="20"><input id="<?php echo $module; ?>" class="select-module" type="radio" name="module" value="<?php echo $module; ?>"></td>
			<td align="left"><?php echo $module; ?></td>
			<td>
			<select id="instance-<?php echo $module; ?>" data-name="<?php echo $module; ?>" name="module_instance_name" class="filter select-module-instance">
				<option value="0">Blank instance</option>
				<?php foreach($instances[$module] as $instance){?>
					<option value="<?php echo $instance->id; ?>"><?php echo $instance->title; ?></option>
				<?php } ?>
			</select>
			</td>
			</tr>
		<?php 
		$i++;
		 } ?>
		 <?php } ?>
		<tfoot>
			<tr>
		<th colspan="8"><div></div></th>
		</tr>
		</tfoot>
	</table>
</div><!-- end of dialog confirm -->

<div id="dialog-edit" style="display: none;" title="Edit Module Properties">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Set module instance properties:</p>
	<div id="module-properties" style="overflow: auto;"></div>
</div><!-- end of dialog-edit -->
<div id="dialog-save-preset" style="display: none;" title="Save preset">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Save preset with module positions:</p>
	<label>Preset name:</label>
	<input type="text" id="preset-name"><br />
	<label>Description:</label>
	<textarea id="preset-description" rows="5" cols="30"></textarea><br />
	Used on template: <?php echo $template[0]->name; ?>
	<input type="hidden" id="template-id" value="<?php echo $template[0]->id; ?>">
</div><!-- end of dialog-save-preset-->



<div id="save-preset-message" style="display: none;" title="Message">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">Message</span></p>
	<p id="save-message"></p>
</div><!-- end of save-preset-message -->

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
			   data: "menu_id="+ menu_id +"&position_id="+ i + "entry_page=0" ,
			   async: false,
			   success: function(response){
					if(response != 0){
				   		$("#position"+i).empty();
                                                $("#position"+i).append(response);
					}
			   }
		});
	}
        
        //TODO: Populate modules for second tab
        $('input.add-module.story').each( function( index, domEl ){
            
            var positin_div = $("#positionstory-" + index);
            //console.log( positin_div );
            $.ajax({
                   type: "POST",
                   url: "<?php echo base_url(); ?>module/load",
                   data: "menu_id=" + menu_id + "&position_id=" + index + "&entry_page=1",
                   async: false,
                   success: function(response){
                                if(response != 0){
                                   positin_div.empty();
                                   positin_div.append( response );
                                }
                            }
                   });
        });
	
	$(".add-module").click(function() {
		var position_id = $( this ).attr("id");

		//checked module by selected module instance
		$(".select-module-instance").change(function() {
			var module_name = $(this).attr('data-name');
			$("#"+module_name).attr("checked", "checked");
			
		});
		
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			width:700,
			modal: true,
			buttons: {
				"Select": function() {
					//get selected value
					//alert('test');
					var module = $(".select-module:checked").val();
					var module_id = $("#instance-"+module).val();
					var menu_id = $("#menu-id").val();
					
					//load div with module properties
					//alert("Module:"+ module +"module instance:"+ module_id);
					
					if (module_id == 0){
						//alert('test');
						$("#module-properties").load("<?=base_url(); ?>module/load_new_module", {module: module, module_id: module_id}, function(response, status, xhr) {
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
                                                                        //this part make difference between menu page and story page
                                                                        var id = position_id.slice(-1);
                                                                        
									if (position_id == 'story-' + id){
                                                                           var entry_page = 1; 
                                                                        }else{
                                                                            var entry_page = 0;
                                                                        }
                                                                        //end of page decision making
                                                                        
								    $.post("<?php echo base_url(); ?>module/load_add_module", "module="+ module + "&position_id="+ id + "&entry_page="+ entry_page + "&" + data,function(response){
								    	$("#position"+position_id).append(response);
								   });
									$( this ).dialog( "close" );
								},
								Cancel: function() {
									$( this ).dialog( "close" );
								}
							}
						});
						
					}else{
						//TODO: Add module instance to selected position and load name and description
						$("#position"+position_id).empty();
                                                //this part make difference between menu page and story page
                                                var id = position_id.slice(-1);
                                                if (position_id == 'story-' + id){
                                                    var entry_page = 1; 
                                                }else{
                                                    var entry_page = 0;
                                                }
                                                //end of page decision making
					    $.post("<?php echo base_url(); ?>module/load_module_by_id", "module="+ module +"&position_id="+ id + "&menu_id=" + menu_id + "&module_id=" + module_id + "&entry_page=" + entry_page,function(response){
					    	$("#position"+position_id).append(response);
					   });
						$( this ).dialog( "close" );
						alert("Save success!");
					}	
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});		
});
</script>
