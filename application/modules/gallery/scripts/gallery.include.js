$(document).ready(function(){
    var galleries = $('.gallery');
    if(galleries){
        $.each(galleries, function(index, gallery){
            $.ajax({
                //url: config.base_url+'/gallery/getImages/',
                url: $('body').data('href') + '/gallery/getImages/',
                type: 'post',
                data: {gallery_id: gallery.id}
            }).done(function(response){
                //console.log(response);
                $('#'+gallery.id).replaceWith(response);
            });
            
        });
    }
});