<?php

require_once 'IO.class.php';

class IOElement
{

    private $_event_io_id;
    private $_nb_total_io;
    public $_io_array;
    
    public function __construct($args = array())
    {
        $this->_io_array = array(
            1 => null, # IO of 1 byte
            2 => null, # IO of 2 bytes
            4 => null, # IO of 4 bytes
            8 => null  # IO of 8 bytes
        );
    }
    
    public function getEventIOID()
    {
        return $this->_event_io_id;
    }
    
    public function getTotalIO()
    {
        return hexdec($this->_nb_total_io);
    }

    public function setEventIOID($val)
    {
        $this->_event_io_id = $val;
    }
    
    public function setTotalIO($val)
    {
        $this->_nb_total_io = $val;
    }
    
    public function getIO($size)
    {
        if (array_key_exists($size, count($this->_io_array))) {
            return $this->_io_array[$size];
        }
        return false;
    }
    
    public function getAllIO()
    {
        return $this->_io_array;
    }
    
    public function setIO($size, $io)
    {
        if (array_key_exists($size, $this->_io_array)) {
            $this->_io_array[$size] = $io;
        }
    }
    
    public function isOnEvent()
    {
        return $this->getEventIOID() != 0;
    }
}
?>