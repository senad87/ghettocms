<div id="toolbar">
    <div class="floatleft">
	<h1 id="<?php echo $title;?>"><?php echo $this->lang->line($title); ?></h1>
    </div>
<div id="horizontalManager" class="floatright">
<ul class="toolbar">
<?php foreach($buttons as $button){ ?>
	<?php $id_button = str_replace(" ", "_", $button); ?>
	<li id="<?php echo $id_button;?>li">
		<?php if($button == 'new'){ ?>
			<a title="<?php echo ucfirst($button);?>" id="<?php echo $id_button;?>" href="<?php echo base_url();?><?php echo $module;?>/createNew/"><?php echo ucfirst($button);?></a>
		<?php }elseif($button == 'help'){ ?>
        		<a title="<?php echo ucfirst($button);?>" id="<?php echo $id_button;?>"  href="#window2" class='modal'><?php echo ucfirst($button);?></a>
		<?php }else{ ?>
			<a title="<?php echo ucfirst($button);?>" id="<?php echo $id_button;?>" class="action_button" href="#"><?php echo ucfirst($button);?></a>
		<?php } ?>
	</li>
<?php } ?>
</ul>
</div>
</div>

<!--<script  type="text/javascript">

$(document).ready(function(){

$("#all").click(function(){
     var checked_status = this.checked;
     $("input[name=row]").each(function(){
          this.checked = checked_status;
     });
});

//$('#horizontalManager li a').each(function(index, value){
	//$('#'+value.id).tipsy({gravity: 's'});
//});


$("#editor-error").hide();
$('.action_button').live('click', function(e){
	e.preventDefault();
	var action = $(this).attr('id');
	action = action.replace(' ', '_');
	
	if(action == 'save' || action == 'next'){
		container.Validation();
		if (container.IsValid()){
			$('#<?php echo $module;?>_form').submit();
		}else{
			//alert("Morate popuniti obavezna polja.");
			$("#message").attr({style: 'display:block', class: 'error'}).html("Some mandatory fields are left empty. <span id='close_mess'></span>");
			jQuery.fn.dissapear('message', 'slow');
		}
	}else if(action == 'cancel'){
		redirectme('<?php echo $module;?>');
	}else{
	
		var checked_boxes = $("input:checked").length;
		ids = 0;
		if(checked_boxes > 0){
			$("input:checked").each(function() {
				if(ids == 0){
				    ids = $(this).val();
				}else{   
				    ids = ids+','+$(this).val();
				}
                 	});

		        $.ajax({
		                type: "POST",
		                url: "<?php echo base_url();?><?php echo $module;?>/"+action+"/",
		                data: ({ids: ids}),
		                success: function(data) {
					        $(".checkbox").each( function(){
								$(this).attr("checked",false);
							});
							location.reload();
				         }
		        });               
		}else{
			//alert('You must select something from the list to perform this action.');
			$("#message").attr({style: 'display:block', class: 'warning'}).html("You must select something from the list to perform this action. <span id='close_mess'></span>").fadeIn('');
			jQuery.fn.dissapear('message', 'slow');
		}
	}
	
								  
}); 

                                              
});

function redirectme(where){
	$(window.location).attr('href', '<?php echo base_url();?>'+where+'/');

}


</script> -->
