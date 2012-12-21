<script>
    $(function() {
        // there's the gallery and the trash
        var $gallery = $( "#gallery" ),
            $trash = $( "#trash" );
 
        // let the gallery items be draggable
        $( "li", $gallery ).draggable({
            cancel: "a.ui-icon", // clicking an icon won't initiate dragging
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            containment: "document",
            helper: "clone",
            cursor: "move"
        });
 
        // let the trash be droppable, accepting the gallery items
       // $trash.droppable({
         $trash.droppable({   
            //accept: "#gallery > li",
            activeClass: "ui-state-highlight",
            drop: function( event, ui ) {
                deleteImage( ui.draggable );
            }
        }).sortable();
       
       // let the gallery be droppable as well, accepting items from the trash
        $gallery.droppable({
            accept: "#trash li",
            activeClass: "custom-state-active",
            drop: function( event, ui ) {
                recycleImage( ui.draggable );
            }
        });
 
        // image deletion function
        var recycle_icon = "<a href='link/to/recycle/script/when/we/have/js/off' title='Recycle this image' class='ui-icon ui-icon-refresh'>Recycle image</a>";
        //console.log(recycle_icon);
        function deleteImage( $item ) {
            //add input when add image to gallery
            if($item.find('input').length < 1){
                $item.append("<input type='hidden' name='items[]' value='"+ $item.attr('data-id') +"' >");
            }
            $item.fadeOut(function() {
                var $list = $( "ul", $trash ).length ?
                    $( "ul", $trash ) :
                    $( "<ul class='gallery ui-helper-reset'/>" ).appendTo( $trash );
 
                $item.find( "a.ui-icon-plus" ).remove();
                $item.find( "a.ui-icon-refresh" ).remove();
                $item.append( recycle_icon ).appendTo( $list ).fadeIn(function() {
                    $item
                        .animate({ width: "96px" })
                        .find( "img" )
                            .animate({ height: "14px" });
                });
                $item.append()
            });
        }
 
        // image recycle function
        var trash_icon = "<a href='link/to/trash/script/when/we/have/js/off' title='Add this image' class='ui-icon ui-icon-plus'>Add image</a>";
        //console.log(trash_icon);
        function recycleImage( $item ) {
            //remove input from image when remove from gallery
            $item.find('input').remove();
            
            $item.fadeOut(function() {
                $item.find( "a.ui-icon-plus" ).remove();
                $item
                    .find( "a.ui-icon-refresh" )
                        .remove()
                    .end()
                    .css( "width", "192px")
                    .append( trash_icon )
                    .find( "img" )
                        .css( "height", "26px" )
                    .end()
                    .appendTo( $gallery )
                    .fadeIn();
            });
        }
 
        // image preview function, demonstrating the ui.dialog used as a modal window
        function viewLargerImage( $link ) {
            var src = $link.attr( "href" ),
                title = $link.siblings( "img" ).attr( "alt" ),
                $modal = $( "img[src$='" + src + "']" );
 
            if ( $modal.length ) {
                $modal.dialog( "open" );
            } else {
                var img = $( "<img alt='" + title + "' width='960' height='127' style='display: none; padding: 8px;' />" )
                    .attr( "src", src ).appendTo( "body" );
                setTimeout(function() {
                    img.dialog({
                        title: title,
                        width: 400,
                        modal: true
                    });
                }, 1 );
            }
        }
 
        // resolve the icons behavior with event delegation
        $( "ul.gallery > li" ).click(function( event ) {
            var $item = $( this ),
                $target = $( event.target );
 
            if ( $target.is( "a.ui-icon-plus" ) ) {
                deleteImage( $item );
            } else if ( $target.is( "a.ui-icon-zoomin" ) ) {
                viewLargerImage( $target );
            } else if ( $target.is( "a.ui-icon-refresh" ) ) {
                recycleImage( $item );
            }
 
            return false;
        });
    });
</script>
<div class="ui-widget ui-helper-clearfix">
    <ul id="gallery" class="gallery ui-helper-reset ui-helper-clearfix">
        <?php foreach ($items as $item): ?>
            <li data-id="<?php echo $item['id']; ?>" class="ui-widget-content ui-corner-tr">
                <h5 class="ui-widget-header"><?php echo $item['name']; ?></h5>
                <img src="<?php echo base_url() . $item['file_location']; ?>" alt="<?php echo $item['name']; ?>" width="192" height="26" />
                <a href="<?php echo base_url() . $item['file_location']; ?>" title="View larger image" class="ui-icon ui-icon-zoomin">View larger</a>
                <a href="link/to/trash/script/when/we/have/js/off" title="Add this image" class="ui-icon ui-icon-plus">Add image</a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php echo $pagination; ?>