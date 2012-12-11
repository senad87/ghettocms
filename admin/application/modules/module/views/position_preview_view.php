<?php if( $hasModule ): ?>
    <div>
        <p>
            Module: <?php echo $module; ?><br />
            Module Title: <?php echo $module_title; ?><br />
            Module Description: <?php echo $module_description; ?><br />
        </p>
        <input type="hidden" id="module-id-pos-<?php echo $position_id; ?>" value="<?php echo $module_id; ?>" />
        <input type="hidden" id="module" value="<?php echo $module; ?>" />
        <input type="button" id="<?php echo $position_id; ?>" class="edit-module" value="+ Edit Module Settings" /><br />
        <input type="button" id="<?php echo $position_id; ?>" class="replace-module" value="+ Replace Module" />
    </div>
<?php else: ?>
    <div id="position<?php echo $position_id; ?>" class="module-box"><input class="add-module" id="<?php echo $position_id; ?>" type="button" value="+ Add Module" />
    </div>
<?php endif; ?>
<script type="text/javascript">
$(".replace-module").click(function() {
		var position_id = $( this ).attr("id");

		//checked module by selected module instance
		$(".select-module-instance").change(function() {
			var module_name = $(this).attr('data-name');
			$("#"+module_name).attr("checked", "checked");
			
		});
		
		//alert(position_id);
		// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
		$( "#dialog:ui-dialog" ).dialog( "destroy" );
	
		$( "#dialog-confirm" ).dialog({
			resizable: false,
			width:750,
			modal: true,
			buttons: {
				"Select": function() {
					//get selected value
					//var module = $("#select-module").val();
					var module = $(".select-module:checked").val();
					var module_id = $("#instance-"+module).val();
					var menu_id = $("#menu-id").val();

					if (module_id == 0){
						
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
										
									    $.post("<?php echo base_url(); ?>module/replace", "module="+ module +"&position_id="+ position_id + "&" + data,function(response){
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
					    $.post("<?php echo base_url(); ?>module/load_module_by_id", "module="+ module +"&position_id="+ position_id + "&menu_id=" + menu_id + "&module_id=" + module_id,function(response){
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

$(".edit-module").click(function() {
	var position_id = $( this ).attr("id");
	var module_id = $("#module-id-pos-"+ position_id).val();
	var module = $("#module").val();
	//alert("Pos ID:"+ position_id +"Module ID"+ module_id);
	$("#module-properties").load("<?=base_url(); ?>module/load_edit_module", {module_id: module_id, position_id: position_id}, function(response, status, xhr) {
		  if (status == "error") {
		    var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
		    console.log(msg);
		  }
	});
	//exit;
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
				
			    $.post("<?php echo base_url(); ?>module/load_update_module", "module="+ module +"module_id="+ module_id +"&position_id="+ position_id + "&" + data,function(response){
			    	$("#position"+position_id).append(response);
			   });
				$( this ).dialog( "close" );
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	});
	
});

function javascript_abort()
{
   throw new Error('This is not an error. This is just to abort javascript');
}
</script>