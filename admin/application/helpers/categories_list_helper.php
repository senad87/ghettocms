<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$CI = get_instance();
    	$CI->load->model('category/Category_model', '', TRUE);
    	$CI->load->model('Entry_model', '', TRUE);


if ( ! function_exists('recursion_categories')){
	/**
	 * 
	 * Display category tree with radio buttons in right panel
	 * on edit category page
	 * @param int $category_id
	 */
	function recursion_categories($category_id, $level, $current_category, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        foreach($categories as $category){ ?>
                               <tr>
                               <?php if (check_category_entries($category->id) == 0 && $category->id != $current_category->id) { ?>
                               <td><input type="radio" class="radio_category_id" name="parent_category_id" <?php if($category->id == $current_category->parent_id){?>checked="checked"<?php } ?> value="<?php echo $category->id; ?>"></td>
                               <td><a href="<?=base_url(); ?>index.php/category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup><?php echo $category->name; ?></a>
                               </td>
                               <? } else { ?>
                               <td><input type="radio" class="radio_category_id" name="parent_category_id" value="<?php echo $category->id; ?>" disabled></td>
                               <td><a href="<?php echo base_url(); ?>index.php/category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup><?php echo $category->name; ?></a>
                               </td>
                               <?php } ?>
                               </tr>
                        <?php 
                        if (check_category_kids($category->id) > 0){
                        $down_level = $level."".$basic_level;	
                        recursion_categories($category->id, $down_level, $current_category, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                        }
                        }
                        
                }
        }	
}

if ( ! function_exists('recursion_categories_new')){
	/**
	 * 
	 * Display category tree with radio buttons in right panel
	 * on new category page
	 * @param int $category_id
	 */
	function recursion_categories_new($category_id, $level, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        foreach($categories as $category){ ?>
                               <tr>
                               <?php if (check_category_entries($category->id) == 0) { ?>
                               <td><input type="radio" class="radio_category_id" name="parent_category_id" value="<?php echo $category->id; ?>"></td>
                               <td><a href="<?=base_url(); ?>index.php/category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup><?php echo $category->name; ?></a>
                               </td>
                               <? } else { ?>
                               <td><input type="radio" class="radio_category_id" name="parent_category_id" value="<?php echo $category->id; ?>" disabled></td>
                               <td><a href="<?php echo base_url(); ?>index.php/category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup><?php echo $category->name; ?></a>
                               </td>
                               <?php } ?>
                               </tr>
                        <?php 
                        if (check_category_kids($category->id) > 0){
                        $down_level = $level."".$basic_level;	
                        recursion_categories_new($category->id, $down_level, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;");
                        }
                        }
                        
                }
        }	
}

if ( ! function_exists('recursion_categories_table')){

	function recursion_categories_table($category_id, $level, $item_counter, $userdata, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        foreach($categories as $category){ ?>
                               <?php if (check_category_entries($category->id) == 0 && check_category_kids($category->id) == 0) { ?>
                               <tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
							   <td align="center"><?php echo $category->id; ?></td><td align="center"><input type="checkbox" name="row" class="radio_category_id" value="<?php echo $category->id; ?>"></td>
							   <?php if(in_array(3, $userdata)){ ?>
							   <td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $category->name; ?></a></td>
                               <?php } ?>
                               <? } else { ?>
                               <tr class="rolover" <?php if ($item_counter%2 == 0){ ?>bgcolor="#f3f3f3" <?php } ?>>
			                   <td align="center"><?php echo $category->id; ?></td><td align="center"><input type="checkbox" name="row" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
			                   <?php if(in_array(3, $userdata)){ ?>
			                   <td align="left"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $category->name; ?>&nbsp;&nbsp;</td>
                               <?php } ?>
                               <?php } ?>
                               </tr>
                        <?php 
                        $item_counter++;
                        if (check_category_kids($category->id) > 0){
                        $down_level = $level."".$basic_level;	
                        recursion_categories_table($category->id, $down_level, $item_counter, $userdata);
                        }        
                        
                        }
                }
        }	
}


if ( ! function_exists('recursion_categories_checkbox')){

	function recursion_categories_checkbox($category_id, $level, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        
                        foreach($categories as $category){ ?>
                               <tr class="rolover">
                               <?php if (check_category_kids($category->id) == 0) { ?>
                               <td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"/></td>
                               <td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $category->name; ?>&nbsp;(<?php echo check_category_entries($category->id); ?>)</a></td>
                               <? } else { ?>
			                   <td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
			                   <td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $category->name; ?>&nbsp;(<?php echo check_category_entries($category->id); ?>)</a></td>
                               <?php } ?>
                               </tr>
                        <?php 
                        $down_level = $level."".$basic_level;
                        recursion_categories_checkbox($category->id, $down_level);
                        }      
                }
        }	
}

if ( ! function_exists('recursion_categories_radio')){

	function recursion_categories_radio($category_id, $level, $basic_level= ".&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        
                        foreach($categories as $category){ ?>
                               <tr class="rolover">
                               <?php if (check_category_kids($category->id) == 0) { ?>
                               <td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>"/></td>
                               <td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $category->name; ?>&nbsp;(<?php echo check_category_entries($category->id); ?>)</a></td>
                               <? } else { ?>
			                   <td align="center"><input type="radio" name="category_id" class="radio_category_id" value="<?php echo $category->id; ?>" disabled></td>
			                   <td align="left"><a href="<?=base_url(); ?>category/edit/<?php echo $category->id; ?>"><?php echo $level; ?><sup>|_</sup>&nbsp;<?php echo $category->name; ?>&nbsp;(<?php echo check_category_entries($category->id); ?>)</a></td>
                               <?php } ?>
                               </tr>
                        <?php 
                        $down_level = $level."".$basic_level;
                        recursion_categories_checkbox($category->id, $down_level);
                        }      
                }
        }	
}
/**
 * Function used to display category list on edit pages
 */
if ( ! function_exists('recursion_categories_edit_radio')){

	function recursion_categories_edit_radio($category_id, $set_category){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        echo "<ul>";
                        foreach($categories as $category){ ?>
                               <li>
                               <?php if (check_category_kids($category->id) == 0) { ?>
                               <input <?php if($category->id == $set_category) {?>checked="yes"<?php } ?> type="radio" class="radio_category_id" name="category_id" value="<?php echo $category->id; ?>"><sup>|_</sup><a href="<?=base_url(); ?>index.php/category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a>
                               <? } else { ?>
                               <span class="indent">
                               <sup>|_</sup>
                               <a href="#"><?php echo $category->name; ?></a>
                               </span>
                               <?php } ?>
                        <?php recursion_categories_edit_radio($category->id, $set_category);          
                        echo "</li>";
                        }
                        echo "</ul>";        
                }
        }	
}




/**
 * Function used to display category list on edit pages
 */
if ( ! function_exists('recursion_categories_edit_checkbox')){

	function recursion_categories_edit_checkbox($category_id, $set_array){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                        echo "<ul>";
                        foreach($categories as $category){ ?>
                               <li>
                               <?php if (check_category_kids($category->id) == 0) { ?>
                               <input <?php if(in_array($category->id, $set_array)) {?>checked="yes"<?php } ?> type="checkbox" class="radio_category_id" name="category_<?php echo $category->id; ?>" value="<?php echo $category->id; ?>"><sup>|_</sup><a href="<?=base_url(); ?>index.php/category/edit/<?php echo $category->id; ?>"><?php echo $category->name; ?></a>
                               <? } else { ?>
                               <span class="indent">
                               <sup>|_</sup>
                               <a href="#"><?php echo $category->name; ?></a>
                               </span>
                               <?php } ?>
                        <?php recursion_categories_edit_checkbox($category->id, $set_array);          
                        echo "</li>";
                        }
                        echo "</ul>";        
                }
        }	
}

/**
 * Function used to display category list on edit pages
 */
if ( ! function_exists('recursion_categories_multiselect')){

	function recursion_categories_multiselect($category_id, $level, $basic_level = ".&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id));
                if (count($categories) > 0){
                        foreach($categories as $category){ 
                               if (check_category_kids($category->id) == 0) { ?>
                               <option value="<?php echo $category->id;?>" >
                               <?php echo $level; ?><?php echo $category->name; ?>
                               </option>
                               <?php } else { ?>
                               <optgroup label="<?php echo $level; ?><?php echo $category->name; ?>">
            				   <?php 
           					   $down_level = $level."".$basic_level;
            				   recursion_categories_multiselect($category->id, $down_level); ?>
            				   </optgroup>
                               <?php }
                        }        
                }
    }	
}

/**
 * Function used to display category list in module edit dialog
 */
if ( ! function_exists('recursion_categories_edit_multiselect')){

	function recursion_categories_edit_multiselect($category_id, $level, $module_params, $basic_level = ".&nbsp;&nbsp;"){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id));
                if (count($categories) > 0){
                        foreach($categories as $category){ 
                               if (check_category_kids($category->id) == 0) { ?>
                               <option value="<?php echo $category->id;?>" <?php if(in_array($category->id, $module_params['categories'])){ ?>selected="selected"<?php } ?>>
                               <?php echo $level; ?><?php echo $category->name; ?>
                               </option>
                               <?php } else { ?>
                               <optgroup label="<?php echo $level; ?><?php echo $category->name; ?>">
            				   <?php 
           					   $down_level = $level."".$basic_level;
            				   recursion_categories_edit_multiselect($category->id, $down_level, $module_params); ?>
            				   </optgroup>
                               <?php }
                        }        
                }
    }	
}


if ( ! function_exists('check_category_kids')){
	/**
	 * 
	 * Check there is subcategories in category with category_id and return 0 if it is not
	 * @param int $category_id
	 * @return int number 
	 */

	function check_category_kids($category_id){
	global $CI;
                $categories = $CI->Category_model->get_category_kids(intval($category_id), $CI->session->userdata('language_id'));
                if (count($categories) > 0){
                    return count($categories);   
                } else {
	                return 0;
                }
        }	
}

if ( ! function_exists('check_category_stories')){
	/**
	 * 
	 * Check is there stories in category with category_id
	 * @param int $category_id
	 * @return int number or 0 if it is category without stories
	 */

	function check_category_entries($category_id){
	global $CI;
                $entries = $CI->Entry_model->get_entries_by_category_id($category_id, $CI->session->userdata('language_id'));
                
                if (count($entries) > 0){
                       return count($entries);   
                } else {
	                return 0;
                }
        }	
}

if ( ! function_exists('category_name')){
	/**
	 * 
	 * Check is there stories in category with category_id
	 * @param int $category_id
	 * @return int number or 0 if it is category without stories
	 */

	function category_name($category_id){
		global $CI;
                $category = $CI->Entry_model->get_category_by_id($category_id);
                
                return $category[0]->name;
        }	
}
/* End of file categories_list_helper.php */
/* Location: ./system/aplication/helpers/array_helper.php */
