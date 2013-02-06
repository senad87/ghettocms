var order = new Array();
var orderInput = $('#hidden-inputs').children('#images-order');
var previousVal = orderInput.val() == '' ? '' : orderInput.val() + "|";
function createUploader(){            
            var uploader = new qq.FileUploaderBasic({
                //element: document.getElementById('file-uploader-demo1'),
                button: document.getElementById('upload'), 
                action: 'http://localhost/ghettocms/admin/gallery/gallery/upload/',
                debug: false,
                onComplete: function(id, file, response){
                        //On completion clear the status
                        //status.text('');
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
                                var imageHtml = '<li class="ui-state-default modal" id="'+response.id+'">';
                                imageHtml += '<div class="handle"><span class="ui-icon ui-icon-arrow-4"></span></div>';
                                imageHtml += '<img width="209" height="135" src="'+config.frontend_url+response.filepath+'" alt="" />';
                                imageHtml += '</li>';
//                                $('#selectable').append(
//                                '<li class="ui-state-default modal" id="'+response.id+'"><img width="209" height="135" src="'+config.frontend_url+response.filepath+'" alt="" />'
//                                +'</li>');
                                $('#selectable').append( imageHtml );
                                //$('#hidden-inputs').append("<input class='"+response.id+"' type='hidden' name='images[]' value='"+response.filepath+"' >");
                                $('#hidden-inputs').append("<input class='"+response.id+"' type='hidden' name='images[]' value='"+response.id+"|"+response.filepath+"' >");
                                
                                order[response.id] = $( "#selectable" ).children('li').length;
                                
                                //updates value with newly added images id|order pairs
                                orderInput.attr('value', previousVal + getOrderString(order));
                        }



                        //$("#foo").load(config.base_url+"gallery/script/", {id: id, image: file });
                }
            });           
        }
        
        // in your app create uploader as soon as the DOM is ready
        // don't wait for the window to load  
        window.onload = createUploader;
        
function uniqid(){
    var newDate = new Date;
    return newDate.getTime();
}

function getOrderString(order){
    var sOrder = '';
    var count = order.length-1;
    //creates string like key1:value1|key2:value2|
    for(id in order) {
        sOrder += id + ":" + order[id];
        sOrder += "|"; 
    }
    //removes "|" at the and of a string
    sOrder = sOrder.substr(0, sOrder.length-1);
    
    return sOrder;
}











////$(document).ready(function(){
//        var btnUpload=$('#upload');
//        var status=$('#status');
//        new AjaxUpload(btnUpload, {
//                action: config.base_url+'gallery/upload/',
//                name: 'uploadfile',
//                responseType: 'json',
//                onSubmit: function(file, ext){
//                        if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
//                                //extension is not allowed 
//                                status.text('Only JPG, PNG or GIF files are allowed');
//                                return false;
//                        }
//                        status.text('Uploading...');
//                },
//                onComplete: function(file, response){
//                        //On completion clear the status
//                        status.text('');
//                        //Add uploaded file to list
//                        var id = uniqid();
//                        //console.log(response);
//                        if(response==="error"){
//                                $('#error').prepend('<span style="color:red" id="'+id+'">'
//                                +'Error Uploding file '+file+'<a class="close">X</a>'
//                                +'</span>');
//                        }else if(response==="file_exists"){
//                                $('#error').prepend('<span style="color:red" id="'+id+'">'
//                                +'File '+file+' already exists!<a class="close">X</a>'
//                                +'</span>');
//                        }else{
//                                //u ovom slucaju response je json sa podacima
//                                var imageHtml = '<li class="ui-state-default modal" id="'+response.id+'">';
//                                imageHtml += '<div class="handle"><span class="ui-icon ui-icon-arrow-4"></span></div>';
//                                imageHtml += '<img width="209" height="135" src="'+config.frontend_url+response.filepath+'" alt="" />';
//                                imageHtml += '</li>';
////                                $('#selectable').append(
////                                '<li class="ui-state-default modal" id="'+response.id+'"><img width="209" height="135" src="'+config.frontend_url+response.filepath+'" alt="" />'
////                                +'</li>');
//                                $('#selectable').append( imageHtml );
//                                //$('#hidden-inputs').append("<input class='"+response.id+"' type='hidden' name='images[]' value='"+response.filepath+"' >");
//                                $('#hidden-inputs').append("<input class='"+response.id+"' type='hidden' name='images[]' value='"+response.id+"|"+response.filepath+"' >");
//                        }
//
//
//
//                        //$("#foo").load(config.base_url+"gallery/script/", {id: id, image: file });
//                }
//        });
//
//
//
//});
//function uniqid(){
//    var newDate = new Date;
//    return newDate.getTime();
//}