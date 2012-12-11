<style>
	#feedback { font-size: 1.4em; }
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected { background: #F39814; color: white; }
	#selectable { border: 1px solid; list-style-type: none; margin: 0; padding: 20px; height: 600px; width: 660px;}
	#selectable li { margin: 3px; padding: 1px; float: left; width: 100px; height: 80px; font-size: 4em; text-align: center; }
</style>
	
<div id="mainbody" >
	<div id="error" ></div>	
		<div id="upload" >
                    <span>+</span>
                </div>
        <span id="status" ></span>
		<!-- <form action="<?=base_url();?>index.php/story/post_add/" method="POST"> -->
		<ul id="files" ></ul>
		<!-- </form>-->
</div>

<div style="width: 1280px;">
<div  style="width: 900px; float: left;">
<ol id="selectable" class="ui-selectable">
	<?php foreach($images as $image){ ?>
		<?php //print_r($image->id); ?>
		<li id="<?php echo $image->id;?>" class="ui-state-default modal" ><img src="<?php echo 'http://localhost/ghettocms'.substr($image->path, 2);?>" width="80" height="70" /></li>	
	<?php } ?>
</ol>
</div>
<div style="width: 380px; float: right;">
<div id="edit"><!-- space for loading --></div>

with selected:
<hr />
<a id="delete" >Delete</a>
<br />
<a id="insert" >Insert</a>
<br />
<a id="crop_button" href="#" class="modal">Crop</a>

<div style="clear: both;"></div>
</div>
<br />

<br />
<div id="selektovano">

</div>
<!-- End demo -->


<br />

<script type="text/javascript" >
	$(function() {
		$( "#selectable" ).selectable({
			   filter: 'li',
			   stop: function(event, ui) {
			   var qwerty = [];
			   //var result = $( "#select-result" ).empty();
			   $( ".ui-selected", this ).each(function() {
					var index = $( "#selectable li" ).index( this );
					
						qwerty[index] = $(this).attr('id');
	
				});
			  // alert(cleanArray(qwerty));
			   //alert(qwerty.length);
			   var ids = cleanArray(qwerty);
			   //var html = "<p>"+ids+"</p>";
			  // $("#edit").empty();
			   //$("#edit").append(html);
			   $("#edit").load("<?php echo base_url();?>images/loadEdit/", {ids: ids});
			   $("#crop_button").attr('href', '<?php  echo base_url();?>images/open/'+ids[0]);
			}
		
			});
		$("#delete").click(function(){
			var ids = $("#ids").attr('value').split(',');
			
			$.each(ids, function(index,value){
					//alert(index+': '+value);
				$("#"+value).remove();
				$.post("<?php echo base_url();?>images/delete/", {id: value});
			});
		});

		$("#insert").click(function(){
			var ids = $("#ids").attr('value').split(',');
			var src = $('#'+ids[0]).children().attr('src');

			window.opener.CKEDITOR.tools.callFunction(1, src);
			window.close();
		});
		

		$("#update").live('click',function(){
			var title = $("#title").val();
			var tags = $("#tags").val();
			var ids = $("#ids").attr('value').split(',');
			
			$.each(ids, function(index,value){
					//alert(index+': '+value);
				//$("#"+value).remove();
				$.post("<?php echo base_url();?>images/update/", {id: value, title: title, tags: tags});
			});
		});

		//$("#crop_button").live('click', function(){
			
			//var ids = $("#ids").attr('value').split(',');
			//var src = $('#'+ids[0]).children().attr('src');
			//$(this).attr('href', '<?php echo base_url();?>images/crop/');

		//}); 


		
});


	function cleanArray(actual){
		  var newArray = new Array();
		  for(var i = 0; i<actual.length; i++){
		      if (actual[i]){
		        newArray.push(actual[i]);
		    }
		  }
		  return newArray;
		}
	
</script>

<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
		//alert('test');
		new AjaxUpload(btnUpload, {
			action: '<?php echo base_url();?>images/upload/',
			name: 'uploadfile',
                        responseType: 'json',
			onSubmit: function(file, ext){
				 if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    //extension is not allowed 
					status.text('Only JPG, PNG or GIF files are allowed');
					return false;
				}
				status.text('Uploading...');
			},
			onComplete: function(file, response){
				//On completion clear the status
				status.text('');
				//Add uploaded file to list
				//alert(response);
				var id = uniqid();
				//alert(response);
				//console.log(response);
				if(response==="error"){
					$('#error').prepend('<span style="color:red" id="'+id+'">'
					+'Error Uploding file '+file+'<a class="close">X</a>'
					+'</span>');
				}else if(response==="file_exists"){
					$('#error').prepend('<span style="color:red" id="'+id+'">'
					+'File '+file+' already exists!<a class="close">X</a>'
					+'</span>');
				}else{
					//u ovom slucaju response je id
					$('#selectable').prepend(
					'<li class="ui-state-default modal" id="'+response.id+'"><img width="80" height="70" src="<?php echo root_url(); ?>'+response.filepath+'" alt="" />'
					+'</li>');
				}

					
				
				$("#foo").load("<?php echo base_url(); ?>images/script/", {id: id, image: file });
			}
		});
		
		
		
	});
	
function uniqid()
    {
    var newDate = new Date;
    return newDate.getTime();
    }   
</script>

<div id="foo" ></div>
</body>
</html>
