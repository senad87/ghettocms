<script type="text/javascript" >
	$(function(){
		var btnUpload=$('#upload');
		var status=$('#status');
	
		new AjaxUpload(btnUpload, {
			action: '<?=base_url(); ?>image/upload/',
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
				//var uniqu = '<?=$this->image_model->uniqueString();?>';
				if(response==="success"){
				
					$('#files').prepend(
					'<li class="success" id="'+id+'"><img src="<?=base_url(); ?>upload_temp/'+file+'" alt="" />'+file
					+'<a class="del">X</a></li>');
					
				}else if(response==="error"){
					$('#files').prepend('<li class="error" id="'+id+'">'
					+'Error Uploding file '+file+'<a class="delerror">X</a>'
					+'</li>').fadeOut("slow");
					
				}else{
					$('#files').prepend('<li class="error" id="'+id+'">'
					+'File '+file+' already exists!<a class="delerror">X</a>'
					+'</li>').fadeOut("slow");
					
				}
				$("#foo").load("<?=base_url(); ?>image/script/", {id: id, image: file });
			}
		});
		
		
		
	});
function uniqid()
    {
    var newDate = new Date;
    return newDate.getTime();
    }   
</script>


<div id="mainbody" >
		
		<div id="upload" ><span>+<span></div><span id="status" ></span>
		<form action="<?=base_url();?>index.php/story/post_add/" method="POST">
		<ul id="files" ></ul>
		</form>
</div>
<div id="foo" >

</div>


</div>

