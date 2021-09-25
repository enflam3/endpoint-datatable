<?php

class IO
{

    private $_nb_io;
    public $_events;

    public function __construct($nb_io = null)
    {
        $this->_nb_io = $nb_io;
        $this->_events = array();
    }
    
    public function getNbIO()
    {
        return hexdec($this->_nb_io);
    }
    
    public function getEvents()
    {
        $ret = array();
        foreach ($this->_events as $id => $value) {
            $ret[hexdec($id)] = hexdec($value);
        }
        return $ret;
    }
    
    public function addEvent($id, $val)
    {
        $this->_events["IO id:".hexdec($id)] = hexdec($val);
    }
    
    public function setNbIO($val)
    {
        $this->_nb_io = $val;
    }
}
?>