<?php

class GPSElement
{   
    private $_longitude;
    private $_latitude;
    private $_altitude;
    private $_angle;
    private $_satellites;
    private $_speed;
    
    public function __construct($args = array())
    {
        
    }
    
    public function getLatitude()
    {
         $dec = hexdec($this->_latitude);
         return ($dec < 0x7fffffff) ? $dec * 0.0000001 : 0 - (0xffffffff - $dec) * 0.0000001;
                               
    }
    
    public function getLongitude()
    {
        $dec = hexdec($this->_longitude);
         return ($dec < 0x7fffffff) ? $dec * 0.0000001 : 0 - (0xffffffff - $dec) * 0.0000001;
    }

    public function getAltitude()
    {
        return hexdec($this->_altitude);
    }

    public function getAngle()
    {
        return hexdec($this->_angle);
    }
    
    public function getSatellites()
    {
        return hexdec($this->_satellites);
    }
    
    public function getSpeed($unit = 'kmph')
    {

        $speed = hexdec($this->_speed);
        switch ($unit) {
            case 'kpmh':
                
                break;
            case 'mph':
                
                break;
        }
        return $speed;
    }
    
    public function setLatitude($val)
    {
        $this->_latitude = $val;
    }
    
    public function setLongitude($val)
    {
        $this->_longitude = $val;
    }

    public function setAltitude($val)
    {
        $this->_altitude = $val;
    }
    

    public function setAngle($val)
    {
        $this->_angle = $val;
    }
    
    public function setSatellites($val)
    {
        $this->_satellites = $val;
    }
    
    public function setSpeed($val)
    {
        $this->_speed = $val;
    }

    public function isValid()
    {
        return $this->getSpeed() != 0;
    }
}
?>