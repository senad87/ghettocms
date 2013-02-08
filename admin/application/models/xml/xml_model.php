<?php

class Xml_model extends CI_Model {
    
    protected $file_path;
    protected $parser;
    const DOM_DOCUMENT = "DOMDocument";
    const SIMPLE_XML = "SimpleXML";


    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }
    
    public function initialise( $file_path, $parser = "DOMDocument" ){
        $this->file_path = $file_path;
        $this->parser = $parser;
        switch ( $this->parser ) {
            case DOMDOCUMENT:
                $this->parser_obj = new Dom_model( $this->file_path );
                return $this->parser_obj;
                break;

            case SIMPLE_XML:
                $this->parser_obj = new SimpleXml_model( $this->file_path );
                return $this->parser_obj;
                break;
            
            default:
                break;
        }
    }
    
    
    
    

}