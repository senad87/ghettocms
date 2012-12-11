<input class='lform2' id='tagValue' type='text' value=''> 
<input class='button-1' type='submit' id='btnSubmitTag' value='Add'>
<script type="text/javascript">
$('#btnSubmitTag').click(function ()
{
	var tag = $('#tagValue').val();
	var topic_id = $('#topic_id').val();
	alert(topic_id);
	$.ajax({
		        type: "POST",
			url: '<?=base_url(); ?>tag/add/',
			data: ({tag: tag, topic_id: topic_id}),
			success: function(data) {
				
				$('#tagList').html(data);
			}
		});
});
</script>
