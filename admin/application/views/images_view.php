<style>
	#feedback { font-size: 1.4em; }
	#selectable .ui-selecting { background: #FECA40; }
	#selectable .ui-selected { background: #F39814; color: white; }
	#selectable { border: 1px solid; list-style-type: none; margin: 0; padding: 20px; height: 600px; width: 660px;}
	#selectable li { margin: 3px; padding: 1px; float: left; width: 100px; height: 80px; font-size: 4em; text-align: center; }
</style>
	
<div id="mainbody" >
	<div id="error" ></div>	
		<div id="upload" ><span>+<span></div><span id="status" ></span>
		<!-- <form action="<?=base_url();?>index.php/story/post_add/" method="POST"> -->
		<ul id="files" ></ul>
		<!-- </form>-->
</div>
<!-- <script type="text/javascript" >
window.opener.CKEDITOR.tools.callFunction(1, 'http://photos-d.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961477805_172968787805_5361682_6286969_a.jpg');
//window.close();
</script>-->
<div style="width: 1280px;">
<div  style="width: 900px; float: left;">
<ol id="selectable" class="ui-selectable">
	<?php foreach($images as $image){ ?>
		<?php //print_r($image->id); ?>
		<li id="<?php echo $image->id;?>" class="ui-state-default" ><img src="<?php echo root_url().$image->path;?>" width="80" height="70" /></li>	
	<?php } ?>
	<!--  <li id="1" class="ui-state-default" ><img src="http://photos-b.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961252805_172968787805_5361643_562338_a.jpg" width="80" height="70" /></li>
	<li id="2" class="ui-state-default" ><img src="http://photos-c.ak.fbcdn.net/hphotos-ak-snc3/hs558.snc3/30515_417961262805_172968787805_5361644_4384083_a.jpg" width="80" height="70" /></li>
	<li id="3" class="ui-state-default" ><img src="http://photos-e.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961297805_172968787805_5361651_7720944_a.jpg" width="80" height="70" /></li>
	<li id="4" class="ui-state-default"><img src="http://photos-g.ak.fbcdn.net/hphotos-ak-snc3/hs558.snc3/30515_417961302805_172968787805_5361652_766299_a.jpg" width="80" height="70" /></li>
	<li id="5" class="ui-state-default"><img src="http://photos-h.ak.fbcdn.net/hphotos-ak-snc3/hs558.snc3/30515_417961357805_172968787805_5361661_2984712_a.jpg" width="80" height="70" /></li>
	<li id="6" class="ui-state-default"><img src="http://photos-f.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961362805_172968787805_5361662_3437741_a.jpg" width="80" height="70" /></li>
	<li id="7" class="ui-state-default"><img src="http://photos-f.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961397805_172968787805_5361669_5049173_a.jpg" width="80" height="70" /></li>
	<li id="8" class="ui-state-default"><img src="http://photos-e.ak.fbcdn.net/hphotos-ak-ash1/hs518.ash1/30515_417961462805_172968787805_5361679_2722325_a.jpg" width="80" height="70" /></li>
	<li id="9" class="ui-state-default"><img src="http://photos-h.ak.fbcdn.net/hphotos-ak-ash1/hs518.ash1/30515_417961467805_172968787805_5361680_3596412_a.jpg" width="80" height="70" /></li>
	<li id="10" class="ui-state-default"><img src="http://photos-d.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961477805_172968787805_5361682_6286969_a.jpg" width="80" height="70" /></li>
	<li id="11" class="ui-state-default"><img src="http://photos-b.ak.fbcdn.net/hphotos-ak-ash1/hs518.ash1/30515_417961432805_172968787805_5361674_6466976_a.jpg" width="80" height="70" /></li>
	<li id="12" class="ui-state-default"><img src="http://photos-d.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961317805_172968787805_5361654_2416292_a.jpg " width="80" height="70" /></li>
	<li id="13" class="ui-state-default"><img src="http://photos-f.ak.fbcdn.net/hphotos-ak-snc3/hs538.snc3/30515_417961327805_172968787805_5361655_3395010_a.jpg" width="80" height="70" /></li>
	-->
</ol>
</div>
<div style="width: 380px; float: right;">
<div id="edit"><!-- space for loading --></div>

with selected:
<hr />
<a id="delete" >Delete</a>
<br />
<a id="insert" >Insert</a>


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
			//$('.clickme').live('click', function() {
			//alert('test');
			var title = $("#title").val();
			var tags = $("#tags").val();
			var ids = $("#ids").attr('value').split(',');
			
			$.each(ids, function(index,value){
					//alert(index+': '+value);
				//$("#"+value).remove();
				$.post("<?php echo base_url();?>images/update/", {id: value, title: title, tags: tags});
			});
		});
		

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
					'<li class="ui-state-default" id="'+response+'"><img width="80" height="70" src="<?php echo base_url(); ?>upload_img/'+file+'" alt="" />'
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