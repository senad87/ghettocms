<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Messages
{
    var $_ci;
    var $_types = array('success', 'error', 'warning');

    function __construct($params = array())
    {
        $this->_ci = get_instance();
        //$this->_ci->load->library('session');
        // check if theres already messages, if not, initialise the messages array in the session
        $messages = $this->_ci->session->userdata('messages');
        if (empty($messages)) {
            $this->clear();
        }
    }

    // clear all messages
    function clear()
    {
        $messages = array();
        foreach ($this->_types as $type) {
            $messages[$type] = array();
        }
        $this->_ci->session->set_userdata('messages', $messages);
    }

    // add a message, default type is message
    public function add($message, $type='message'){
        $messages = $this->_ci->session->userdata('messages');
        // handle PEAR errors gracefully
        if (is_a($message, 'PEAR_Error')) {
            $message = $message->getMessage();
            $type = 'error';
        } else if (!in_array($type, $this->_types)) {
            // set the type to message if the user specified a type that's unknown
            $type = 'message';
        }
        // don't repeat messages!
        //var_dump($messages[$type]);
        if (!in_array($message, $messages[$type]) && is_string($message)) {
            $messages[$type] = $message;
        }
        $messages = $this->_ci->session->set_userdata('messages', $messages);
    }

    // return messages of given type or all types, return false if none
    function sum($type = null)
    {
        $messages = $this->_ci->session->userdata('messages');
        if (!empty($type)) {
            $i = count($messages[$type]);
            return $i;
        }
        $i = 0;
        foreach ($this->_types as $type) {
            $i += count($messages[$type]);
        }
        return $i;
    }

    // return messages of given type or all types, return false if none, clearing stack
   public function get($type=null)
    {
        $messages = $this->_ci->session->userdata('messages');
        if (!empty($type)) {
            if (count($messages[$type]) == 0) {
                return false;
            }
            return $messages[$type];
        }
        // return false if there actually are no messages in the session
        $i = 0;
        foreach ($this->_types as $type) {
            $i += count($messages[$type]);
        }
        if ($i == 0) {
            return false;
        }

        // order return by order of type array above
        // i.e. success, error, warning and then informational messages last
        foreach ($this->_types as $type) {
            $return[$type] = $messages[$type];
        }
        $this->clear();
        return $return;
    }
} 
