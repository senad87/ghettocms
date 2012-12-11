<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$CI =& get_instance();
    	$CI->load->model('Menu_model', '', TRUE);
    	
if ( ! function_exists('recursion_menus_table')) {

	function recursion_menus_table($menu_id, $level, $item_counter, $root_menu_id, $basic_level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") {
	global $CI;
                $menus = $CI->Menu_model->get_menu_kids(intval($menu_id), $CI->session->userdata('language_id'));
                $maxorder = $CI->Menu_model->get_maxorder_by_parent_id($menu_id);
                $minorder = $CI->Menu_model->get_minorder_by_parent_id($menu_id);
                
                if (count($menus) > 0){
                       
                        foreach($menus as $menu){ ?>
                               
                               <?php if (check_menu_kids($menu->id) == 0) { ?>
                               <tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
							   <td align="center"><?php echo $menu->id; ?></td>
							   <td align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $menu->id; ?>"></td>
							   <td align="left"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $menu->name; ?></td>
							   <td align="left"><a href="<?=base_url(); ?>menu/create_layout/<?php echo $menu->id; ?>">Create/Edit Layout</a></td>
							   <td align="left"><?php echo $menu->home; ?></td>
							   <td align="left"><?php echo get_state_name($menu->menu_state_id); ?></td>
							   <td align="left">
								   <?php if($maxorder[0]->ordering == $menu->ordering){ ?>
								   <a href="<?=base_url(); ?>menu/up/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Up</a>
								   <?php }elseif($minorder[0]->ordering == $menu->ordering){ ?>
								   <a href="<?=base_url(); ?>menu/down/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Down</a>
								   <?php }else{ ?>
								   <a href="<?=base_url(); ?>menu/up/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Up</a>
								   <a href="<?=base_url(); ?>menu/down/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Down</a>
								   <?php } ?>
							   </td>
							   </tr>
                               <? } else { ?>
                               <tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
			                   <td align="center"><?php echo $menu->id; ?></td>
			                   <td align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $menu->id; ?>" disabled></td>
			                   <td align="left"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $menu->name; ?></td>
							   <td align="left"><a href="<?=base_url(); ?>menu/create_layout/<?php echo $menu->id; ?>">Create/Edit Layout</a></td>
							    <td align="left"><?php echo $menu->home; ?></td>
							    <td align="left"><?php echo get_state_name($menu->menu_state_id); ?></td>
							   <td align="left">
							   <?php if($maxorder[0]->ordering == $menu->ordering){ ?>
							   <a href="<?=base_url(); ?>menu/up/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Up</a>
							   <?php }elseif($minorder[0]->ordering == $menu->ordering){ ?>
							   <a href="<?=base_url(); ?>menu/down/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Down</a>
							   <?php }else{ 
							   	?>
							   <a href="<?=base_url(); ?>menu/up/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Up</a>
							   <a href="<?=base_url(); ?>menu/down/<?php echo $root_menu_id; ?>/<?php echo $menu->id; ?>">Down</a>
							   <?php } ?>
							   </td>
			                   </tr>
                               <?php } ?>            
                        <?php 
                        $item_counter++;
                        if (check_menu_kids($menu->id) > 0){
                        $down_level = $basic_level."".$level;	
                        recursion_menus_table($menu->id, $down_level, $item_counter, $root_menu_id);
                        }        
                        
                        }
                }
        }	
}

if ( ! function_exists('recursion_menus_right_panel')) {

	function recursion_menus_right_panel($menu_id, $level, $basic_level = ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;") {
	global $CI;
                $menus = $CI->Menu_model->get_menu_kids(intval($menu_id), $CI->session->userdata('language_id'));
               
                if (count($menus) > 0){     
                   foreach($menus as $menu){ ?>
                   <tr class="rolover">
				   <td align="center"><input type="radio" name="menu_id" class="radio_category_id" value="<?php echo $menu->id; ?>"></td>
				   <td align="left"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $menu->name; ?></td>
				   </tr>    
                   <?php if (check_menu_kids($menu->id) > 0){
                        $down_level = $level."".$basic_level;	
                        recursion_menus_right_panel($menu->id, $down_level);
                        }        
                }
                }
        }	
}

if ( ! function_exists('recursion_menus_right_panel_edit')) {

	function recursion_menus_right_panel_edit($menu_id, $level, $menu_parent_id, $basic_level = ".&nbsp;&nbsp;&nbsp;&nbsp;") {
	global $CI;
                $menus = $CI->Menu_model->get_menu_kids(intval($menu_id), $CI->session->userdata('language_id'));
                if (count($menus) > 0){     
                   foreach($menus as $menu){ ?>
                   <tr class="rolover">
				   <td align="center"><input type="radio" name="parent_id" class="radio_category_id" value="<?php echo $menu->id; ?>" <?php if($menu_parent_id == $menu->id){?>checked="checked"<?php } ?>></td>
				   <td align="left"><a href="<?=base_url(); ?>menu/create_layout/<?php echo $menu->id; ?>"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $menu->name; ?></a></td>
				   </tr>      
                   <?php 
                        if (check_menu_kids($menu->id) > 0){
                        $down_level = $basic_level."".$level;	
                        recursion_menus_right_panel_edit($menu->id, $down_level, $menu_parent_id);
                        }        
                }
                }
        }	
}

/**
 * Function used to display category list on edit pages
 */
if ( ! function_exists('recursion_menus_multiselect')){

	function recursion_menus_multiselect($parent_id, $level, $basic_level = ".&nbsp;&nbsp;"){
	global $CI;
                $items = $CI->Menu_model->get_menu_kids(intval($parent_id), $CI->session->userdata('language_id'));
                if (count($items) > 0){
                        foreach($items as $item){ ?>
                               <option value="<?php echo $item->id;?>" >
                               <?php echo $level; ?><?php echo $item->name; ?>
                               </option>
           					   <?php $down_level = $level."".$basic_level;
            				   recursion_menus_multiselect($item->id, $down_level);
                        }        
                }
    }	
}

if ( ! function_exists('check_menu_kids')){
	/**
	 * 
	 * Check there is menu items in menu with menu_id and return 0 if it is not
	 * @param int $menu_id
	 * @return int number 
	 */

	function check_menu_kids($menu_id){
	global $CI;
                $menus = $CI->Menu_model->get_menu_kids(intval($menu_id), $CI->session->userdata('language_id'));
                if (count($menus) > 0){
                    return count($menus);   
                } else {
	                return 0;
                }
        }	
}

if ( ! function_exists('check_menu_modules')){
	/**
	 * 
	 * Check is there modules connected to this menu item
	 * @param int $menu_id
	 * @return int number 
	 */

	function check_menu_modules($menu_id){
	global $CI;
                $menus = $CI->Menu_model->get_menu_modules(intval($menu_id));
                if (count($menus) > 0){
                    return count($menus);   
                } else {
	                return 0;
                }
        }	
}

if ( ! function_exists('get_state_name')){
	/**
	 * 
	 * Get state name on menu_state_id
	 * @param int $menu_state_id
	 */

	function get_state_name($menu_state_id){
		global $CI;
		
        $menu_state = $CI->Menu_model->get_state_by_id(intval($menu_state_id));
        return $menu_state[0]->state_name;
    }	
}