<?php
require_once 'GPSElement.class.php';
require_once 'IOElement.class.php';

class AVLPacket
{    

    private $_data_length;
    private $_crc;
    public $data;
    public $avl_data_array;

    public function __construct($args = array())
    {
        $this->avl_data_array = new AVLDataArray();
    }
    
    public function getDataLength()
    {
        return hexdec($this->_data_length);
    }
    
    public function setDataLength($val)
    {
        $this->_data_length = $val;
    }
    
    public function getCRC()
    {
        return hexdec($this->_crc);
    }
    
    public function setCRC($val)
    {
        $this->_crc = $val;
    }
}

class AVLDataArray
{

    private $_codec_id;
    private $_nb_data;
    private $_avl_datas;

    public function __construct($args = array())
    {
        $this->_avl_datas = array();
    }
    
    public function getCodecID()
    {
        return hexdec($this->_codec_id);
    }
    
    public function getNbData()
    {
        return hexdec($this->_nb_data);
    }

    public function getAVLDatas()
    {
        return $this->_avl_datas;
    }
    
    public function setCodecID($val)
    {
        $this->_codec_id = $val;
    }

    public function setNbData($val)
    {
        $this->_nb_data = $val;
    }
    
    public function addAVLData($avl_data)
    {
        $this->_avl_datas[] = $avl_data;
    }
}

class AVLData
{

    private $_timestamp;
    private $_formatTime;
    private $_priority;
    private $_str_priority;
    public $gps_element;
    public $io_element;
    
    public function __construct($args = array())
    {
        $this->gps_element = new GPSElement();
        $this->io_element = new IOElement();
        $this->_str_priority = array(
            0 => 'Low',
            1 => 'High',
            2 => 'Panic',
            3 => 'Security'
        );
    }
    
    public function getTimestamp()
    {
        return hexdec($this->_timestamp);
    }
    
    public function getStrTimestamp()
    {
         $mstosec = hexdec($this->_timestamp)/1000;
         return date('Y-m-d H:i:s', $mstosec);
    }
    
    public function getPriority()
    {
        return hexdec($this->_priority);
    }
    
    public function setTimestamp($val)
    {
        $this->_timestamp = $val;
    }

    public function setPriority($val)
    {
        $this->_priority = $val;
        
    }

    public function getStrPriority()
    {
        return $this->_str_priority[$this->getPriority()];
    }
}
?>