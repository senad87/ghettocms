<script type="text/javascript">
		$(document).ready(function(){	
			$("#slider").easySlider({
				auto: true, 
				continuous: true,
				numeric: true,
				hoverPause: true
			});
		});	
</script>
<div id="slider" class="slider<?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>">
<ul>	
<?php foreach($stories_row as $story){ ?>          
		
         <li>
         	<div class="one-slide">
            	<a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>"><img src="<?php echo base_url(); ?><?php echo $story['photo_path']; ?>" width="577" height="379" /></a>
                <div class="title-lead">
                	<?php if($module_params['title'] == 1){?>
                    <h2>﻿<a href="<?php echo base_url(); ?>page/index/<?php echo $data['menu_id']; ?>/story/<?php echo $story['id']; ?>"><?php echo $story['title']; ?></a></h2>
                    <?php } ?>
                    <?php if($module_params['lead'] == 1){?>
                    <p><?php echo $story['lead']; ?></p>
                	<?php } ?>
                </div>
            </div>
		</li>
    <?php } ?>
    </ul>     
</div>