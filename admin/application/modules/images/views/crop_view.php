<script type="text/javascript" src="<?php echo base_url();?>application/style/js/jquery-1.4.4.min.js" ></script>
<script src="<?php echo base_url();?>application/style/js/jquery.Jcrop.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>application/style/js/jcrop/css/jquery.Jcrop.css" type="text/css" />

<!-- <img src="<?php // echo root_url().$image->path; ?>" />-->

<?php //print_r(getimagesize(root_url().$image->path)); ?>


<!--
<script language="Javascript">

		// Remember to invoke within jQuery(window).load(...)
		// If you don't, Jcrop may not initialize properly
		jQuery(document).ready(function(){
                    
                    var jcrop_api;
                    var bounds, boundx, boundy; 
		
			jQuery('#cropbox').Jcrop({
				aspectRatio: 1,
				onSelect: updateCoords,
                                onChange: updateCoords
                                //onSelect: showPreview 
			},function(){
                            jcrop_api = this;
                            bounds = jcrop_api.getBounds();
                            boundx = bounds[0];
                            boundy = bounds[1];
                        });
		});
		
		// Our simple event handler, called from onChange and onSelect
		// event handlers, as per the Jcrop invocation above
		function updateCoords(coords)
		{
			jQuery('#x').val(coords.x);
			jQuery('#y').val(coords.y);
			jQuery('#x2').val(coords.x2);
			jQuery('#y2').val(coords.y2);
			jQuery('#w').val(coords.w);
			jQuery('#h').val(coords.h);
                        
                        if (parseInt(coords.w) > 0){
                            var rx = 100 / coords.w;
                            var ry = 100 / coords.h;
                            $('#preview').css({
                            width: Math.round(rx * boundx) + 'px',
                            height: Math.round(ry * boundy) + 'px',
                            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                            marginTop: '-' + Math.round(ry * coords.y) + 'px'
                            });
                        } 
                        
                        
		};

</script>
	-->
<script type="text/javascript">     
    (function($) {
        $(function(){
            var jcrop_api;
            var bounds, boundx, boundy;
            
            $('#cropbox').Jcrop({
                onChange: showPreview,
                onSelect: showPreview,
                aspectRatio: 1
            },function(){
                jcrop_api = this;
                bounds = jcrop_api.getBounds();
                //console.log(bounds);
                boundx = bounds[0];
                boundy = bounds[1];
            });
            
            function showPreview(coords){
                if (parseInt(coords.w) > 0){
                    var rx = 100 / coords.w;
                    //console.log(boundx);
                    var ry = 100 / coords.h;
                    $('#preview').css({
                        width: Math.round(rx * boundx) + 'px',
                        height: Math.round(ry * boundy) + 'px',
                        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                        marginTop: '-' + Math.round(ry * coords.y) + 'px'
                    });
                }
                
                $('#x').val(coords.x);
                $('#y').val(coords.y);
                $('#x2').val(coords.x2);
                $('#y2').val(coords.y2);
                $('#w').val(coords.w);
                $('#h').val(coords.h);
                
                
            };
        });
    }(jQuery));         
</script>     
	</head>

	<body>

<div id="outer">
<div class="jcExample">
<div class="article">
		<table>
		<tr>
		<td>
		<img src="<?php echo root_url().$image->path; ?>" id="cropbox" />
		</td>
                <td>
                    <div style="width:100px;height:100px;overflow:hidden;">
                        <img id="preview" src="<?php echo root_url().$image->path; ?>">
                    </div>
                </td>
		</tr>
		</table>
	</div>
	</div>
<form method="post" action="<?php echo base_url();?>images/crop/" >
<input type="hidden" name="src" value="<?php echo $image->path;?>" />
<input type="hidden" id="x" name="x" />
<input type="hidden" id="y" name="y" />
<input type="hidden" id="x2" name="x2" />
<input type="hidden" id="y2" name="y2" />
<input type="hidden" id="w" name="w" />
<input type="hidden" id="h" name="h" />
<input id="submit-crop" type="submit" value="Crop" />
</form>	
	</div>
	</body>
</html>