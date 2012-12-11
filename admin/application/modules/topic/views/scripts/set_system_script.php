<script type="text/javascript">
	$("#setSystem").click(function() {
		  var multipleValues = $("#selections").val() || [];
		  var type = <?php echo $entry_type; ?>;
		  alert(type);
		  $("#system_topics").load("<?php echo base_url(); ?>topic/setSystem_post", {topics: multipleValues, entry_type: type}, function(response, status, xhr) {
			  if (status == "error") {
			    //var msg = "Sorry but there was an error: "+ xhr.status + " " + xhr.statusText;
			    //console.log(msg);
			  }
		});
		  
	});
</script>