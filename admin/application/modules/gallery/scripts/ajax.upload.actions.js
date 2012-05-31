$(document).ready(function(){
        var btnUpload=$('#upload');
        var status=$('#status');
        new AjaxUpload(btnUpload, {
                action: config.base_url+'gallery/upload/',
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
                        var id = uniqid();
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
                                //u ovom slucaju response je json sa podacima
                                $('#selectable').append(
                                '<li class="ui-state-default modal" id="'+response.id+'"><img width="209" height="135" src="'+config.frontend_url+response.filepath+'" alt="" />'
                                +'</li>');
                                $('#hidden-inputs').append("<input class='"+response.id+"' type='hidden' name='images[]' value='"+response.filepath+"' >");
                        }



                        $("#foo").load(config.base_url+"gallery/script/", {id: id, image: file });
                }
        });



});
function uniqid(){
    var newDate = new Date;
    return newDate.getTime();
}