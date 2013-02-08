<div id="toolbar">
    <div class="floatleft">
	<h1 id="<?php echo $title;?>"><?php echo $this->lang->line($title); ?></h1>
    </div>
<div id="horizontalManager" class="floatright">
<ul>
<?php foreach($buttons as $button){ ?>
	<li id="<?php echo $button;?>li">
		<?php if($button == 'new'){ ?>
			<a id="<?php echo $button;?>" href="<?php echo base_url();?><?php echo $module;?>/newItem/<?php echo $id; ?>"><?php echo ucfirst($button);?></a>
		<?php }elseif($button == 'help'){ ?>
        	<a id="<?php echo $button;?>"  href="#window2" class='modal'><?php echo ucfirst($button);?></a>
		<?php }
		else{ ?>
			<a id="<?php echo $button;?>" class="action_button" href="#"><?php echo ucfirst($button);?></a>
		<?php } ?>
	</li>
<?php } ?>
</ul>
</div>
</div>

<script  type="text/javascript">

$(document).ready(function(){
        
$('.action_button').click(function(){
	
	var action = $(this).attr('id');
	action = action.replace(' ', '_');
	
	if(action == 'save'){
		$('#<?php echo $module;?>_form').submit();
	}else if(action == 'cancel'){
		redirectme('<?php echo $module;?>/itemsList/<?php echo $id; ?>');
	}else if(action == 'back'){
		redirectme('<?php echo $module;?>');
	}else{
		//alert(action);
		var checked_stories = $("input:checked").length;
		ids = 0;
		if(checked_stories > 0){
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
                                //alert ("Stories deleted");
                                
                                $(".checkbox").each( function() {
				$(this).attr("checked",false);
				});
				
                                location.reload();
                                }
                        });
                                 
                 
		}else{
			alert('You must select something from the list to '+action+'.' );
		}
	}
	
		
}); 

                                              
});

function redirectme(where){
	$(window.location).attr('href', '<?php echo base_url();?>'+where+'/');

}

</script>
    
