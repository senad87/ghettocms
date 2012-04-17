<?php

abstract class Field_model extends Model {

	var $id;
	var $label;
	var $element_name;
	var $type;
	var $document_type_id;
	var $required;
	var $sortorder;
	var $location;
	var $show_column;


	function __construct(){
	        // Call the Model constructor
	        parent::__construct();
	}

	public function get_field_type_specific_params(){

	}
	/**
	 * get_field_params_by_name
	 * @param string $table_name Name of the table presenting field type
	 * @return array $table_columns Names of the table columns
	 */
	public function get_field_params_by_type($table_name){
		
		$table_columns = $this->db->list_fields($table_name);
		return $table_columns;
		
	}



}
?>
