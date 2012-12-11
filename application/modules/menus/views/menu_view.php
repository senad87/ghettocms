<!-- <div class="menuBox <?php if(isset($module_params['classsuffix']) && $module_params['classsuffix'] != "") echo $module_params['classsuffix']; ?>"> -->
<?php //print_r($menu_id);?>
<ul class="menu">
	<?php foreach ($menuItems as $item){ ?>
	<li <?php echo ($menu_id==$item->id?'class="current"':''); ?>>
	<?php if (check_menu_kids($item->id) > 0){ ?>
		<a class="hide <?php echo 'menu_'.$item->id; ?>" href="<?php if($item->home == 1){ echo base_url(); }elseif($item->menu_type_id == 3){ echo $item->url; }elseif($item->menu_type_id == 1){ echo base_url() . url_title( $item->name ); ?>/<?php echo $item->id;} ?>"><?php echo $item->name; ?></a>
		<?php recursion_menus($item->id); 
		} else { ?>
		<a class="<?php echo 'menu_'.$item->id; ?>" href="<?php if($item->home == 1){ echo base_url(); }elseif($item->menu_type_id == 3){ echo $item->url; }elseif($item->menu_type_id == 1){ echo base_url() . url_title( $item->name ); ?>/<?php echo $item->id;} ?>" ><?php echo $item->name; ?></a>
		<?php } ?>
	</li>
	<?php } ?>
</ul>
<!-- </div> -->
