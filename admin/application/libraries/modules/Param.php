<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Param
 *
 * @author damir
 */
abstract class Param {
    protected $default = "";
    protected $name = "";
    protected $label = "";
    protected $cssclass = "";
    protected $type;
    protected $xml_obj;


    public static function getInstance( $type, $dom_node_list ){
        $this->type = $type;
        $this->xml_obj = $dom_node_list;
        switch ( $this->type ) {
            case "select":
                

                break;

            default:
                break;
        }
        if ($param_item->getAttribute("type") == "select") {
                    
                } elseif ($param_item->getAttribute("type") == "input") {
                    
                } elseif ($param_item->getAttribute("type") == "rich_text") {
                    
                } elseif ($param_item->getAttribute("type") == "radio") {
                    
                } elseif ($param_item->getAttribute("type") == "tags") {
                    //TODO:add possibility to filter content by tags
                } elseif ($param_item->getAttribute("type") == "categories") {
                    
                } elseif ($param_item->getAttribute("type") == "menus") {
                    
                } elseif ($param_item->getAttribute("type") == "menu_tree") {
                   
                } elseif ($param_item->getAttribute("type") == "stories") {
                    
                }elseif ( $param_item->getAttribute("type") == "photo_size" ) {
                    
                }elseif( $param_item->getAttribute("type") == "dragdrop" ){
                    
                }
    }
}

?>
