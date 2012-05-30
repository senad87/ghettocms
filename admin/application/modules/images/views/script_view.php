<script type="text/javascript" >
$(function() {
$(".del").click(function() {
	$("#<?php echo $id;?>").load("<?php echo base_url();?>images/delete/", {id: <?php echo $id;?>, image: '<?php echo $image;?>' });
	$('#<?php echo $id;?>').remove().fadeOut("slow");	
});
$(".close").click(function() {
	$('#<?php echo $id;?>').remove();	
});
});
</script>
