<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$CI =& get_instance();
    $CI->load->model('menus/Menus_model', '', TRUE);
    
    if ( ! function_exists('recursion_menus')) {

	function recursion_menus($menu_id) {
	global $CI;
                $menus = $CI->Menus_model->get_menu_kids(intval($menu_id));
                if (count($menus) > 0){ ?>
	               	<ul>     
	                <?php foreach($menus as $menu) { ?>
	                    <li>
	                        <?php if (check_menu_kids($menu->id) > 0){ ?>
	                        <a class="hide" href="<?php if($menu->home == 1){ echo base_url(); }elseif($menu->menu_type_id == 3){ echo $menu->url; }elseif($menu->menu_type_id == 1){ echo base_url()."menu/index/".$menu->id; } ?>"><?php echo $menu->name; ?></a>
	                        <?php recursion_menus($menu->id);
	                        }else{ ?>
	                        <a href="<?php if($menu->home == 1){ echo base_url(); }elseif($menu->menu_type_id == 3){ echo $menu->url; }elseif($menu->menu_type_id == 1){ echo base_url()."menu/index/".$menu->id; } ?>"><?php echo $menu->name; ?></a>
	                        <?php } ?>
	                    </li>          
	                <?php  } ?>
	                </ul>
                <?php }
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
                $menus = $CI->Menus_model->get_menu_kids(intval($menu_id));
                if (count($menus) > 0){
                    return count($menus);   
                } else {
	                return 0;
                }
        }	
}
