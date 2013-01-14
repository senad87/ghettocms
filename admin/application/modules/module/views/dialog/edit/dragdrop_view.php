<style>
    #gallery { float: left; width: 100%; min-height: 12em; } * html #gallery { height: 12em; } /* IE6 */
    .gallery.custom-state-active { background: #eee; }
    .gallery li { float: left; width: 192px; padding: 0.4em; margin: 0 0.4em 0.4em 0; text-align: center; }
    .gallery li h5 { margin: 0 0 0.4em; cursor: move; }
    .gallery li a { float: right; }
    .gallery li a.ui-icon-zoomin { float: left; }
    .gallery li img { width: 100%; cursor: move; }
 
    #trash { float: left; width: 100%; min-height: 18em; padding: 1%;} * html #trash { height: 18em; } /* IE6 */
    #trash h4 { line-height: 16px; margin: 0 0 0.4em; }
    #trash h4 .ui-icon { float: left; }
    #trash .gallery h5 { display: none; }
</style>
 <h4 class="ui-widget-header"><span class="ui-icon ui-icon-newwin">Slider</span> Slider</h4>
<div id="trash" class="ui-widget-content ui-state-default">
  
    <ul class="gallery ui-helper-reset">
        <?php foreach( $set_items as $set_item ):  ?>
        <li data-id="<?php echo $set_item->id; ?>" class="ui-widget-content ui-corner-tr ui-draggable" style="display: list-item; width: 96px;">
            <h5 class="ui-widget-header"><?php echo $set_item->name; ?></h5>
            <img width="192" height="26" alt="<?php echo $set_item->name; ?>" src="<?php echo base_url() . $set_item->file_location; ?>" style="height: 14px;">
            <!-- <a class="ui-icon ui-icon-zoomin" title="View larger image" href="<?php echo base_url() . $set_item->file_location; ?>">View larger</a> -->
            <input type="hidden" value="<?php echo $set_item->id; ?>" name="items[]"/>
            <a class="ui-icon ui-icon-refresh" title="Recycle this image" href="link/to/recycle/script/when/we/have/js/off">Recycle image</a>
	</li>
        <?php endforeach; ?>
    </ul>
</div>

<div id="content">
    <script>
    
    $(document).ready(function() {
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
        
        // let the gallery items be draggable
        $( "li", $trash ).draggable({
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
            <?php foreach( $items as $item ):  ?>
            <li data-id="<?php echo $item['id']; ?>" class="ui-widget-content ui-corner-tr">
                <h5 class="ui-widget-header"><?php echo $item['name']; ?></h5>
                <img src="<?php echo base_url() . $item['file_location']; ?>" alt="<?php echo $item['name']; ?>" width="192" height="26" />
                <!-- <a href="<?php echo base_url() . $item['file_location']; ?>" title="View larger image" class="ui-icon ui-icon-zoomin">View larger</a> -->
                <a href="link/to/trash/script/when/we/have/js/off" title="Add this image" class="ui-icon ui-icon-plus">Add image</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php echo $pagination; ?>
</div>