<?php

require_once 'constants.php';
require_once 'AVLObjects.class.php';
require_once 'IO.class.php';

class Parser
{
    private $_is_binary;
    private $_offset;
    private $_raw_data;
    private $_avl_packet;
    
    public function __construct($raw_data, $is_binary = false){
        $this->_raw_data = str_replace(array(" ", "\n"), array("",""), $raw_data);
        $this->_is_binary = $is_binary;
        if ($this->_is_binary) {
            $this->_offset = 8;
        } else {
            $this->_offset = 2;
        }
        $this->_avl_packet = new AVLPacket();
        $this->_decapsulate();
    }

    private function _decapsulate($data = '')
    {
        if (empty($data)) {
            $data = $this->_raw_data;
        } else {
            $data =  str_replace(array(" ", "\n"), array("",""), $data);
        }
        $start = $this->_offset * LENGTH_FOUR_ZEROS;
        $length = $this->_offset * LENGTH_DATA_LENGTH;
        $this->_avl_packet->setDataLength(substr($data, $start, $length));
        
        $start += $length;
        $length = $this->_offset * $this->_avl_packet->getDataLength();
        $this->_avl_packet->data = substr($data, $start, $length);
        
        $start += $length;
        $length = $this->_offset * LENGTH_CRC;
        $this->_avl_packet->setCRC(substr($data, $start, $length));
    }
    
    public function parse($data = '')
    {
        if (empty($data)) {
            $data = $this->_avl_packet->data;
        } else {
            $data =  str_replace(array(" ", "\n"), array("",""), $data);
        }
        // Parsing of codec id
        $start = 0;
        $length = $this->_offset * LENGTH_CODEC_ID;
        $this->_avl_packet->avl_data_array->setCodecID(substr($data, $start, $length));
        
        // Parsing of number of data
        $start += $length;
        $length = $this->_offset * LENGTH_NUMBER_OF_DATA;
        $this->_avl_packet->avl_data_array->setNbData(substr($data, $start, $length));
        
        // Parsing of AVL Data Array. It consist of AVL Data objects
        for ($i = 0; $i < $this->_avl_packet->avl_data_array->getNbData(); $i++) {
            $avl_data = new AVLData();
            
            // Parsing of Timestamp
            $start += $length;
            $length = $this->_offset * LENGTH_TIMESTAMP;
            $avl_data->setTimestamp(substr($data, $start, $length));
            
            // Parsing of Priority
            $start += $length;
            $length = $this->_offset * LENGTH_PRIORITY;
            $avl_data->setPriority(substr($data, $start, $length));
            
            // Parsing of GPS Element
            // Longitude
            $start += $length;
            $length = $this->_offset * LENGTH_GPS_LONGITUDE;
            $avl_data->gps_element->setLongitude(substr($data, $start, $length));
            
            // Latitude
            $start += $length;
            $length = $this->_offset * LENGTH_GPS_LATITUDE;
            $avl_data->gps_element->setLatitude(substr($data, $start, $length));
            
            // Altitude
            $start += $length;
            $length = $this->_offset * LENGTH_GPS_ALTITUDE;
            $avl_data->gps_element->setAltitude(substr($data, $start, $length));
            
            // Angle
            $start += $length;
            $length = $this->_offset * LENGTH_GPS_ANGLE;
            $avl_data->gps_element->setAngle(substr($data, $start, $length));
            
            // Satellites
            $start += $length;
            $length = $this->_offset * LENGTH_GPS_SATELLITES;
            $avl_data->gps_element->setSatellites(substr($data, $start, $length));
            
            // Speed
            $start += $length;
            $length = $this->_offset * LENGTH_GPS_SPEED;
            $avl_data->gps_element->setSpeed(substr($data, $start, $length));
            
            // Parsing of IO Element
            // IO Event ID
            $start += $length;
            $length = $this->_offset * LENGTH_IO_EVENT_IO_ID;
            $avl_data->io_element->setEventIOID(substr($data, $start, $length));
            
            // Number Total of IO
            $start += $length;
            $length = $this->_offset * LENGTH_IO_N;
            $avl_data->io_element->setTotalIO(substr($data, $start, $length));
            
            foreach ($avl_data->io_element->getAllIO() as $size => $io) {
                $start += $length;
                $length = $this->_offset * LENGTH_IO_N;
                // Set up new IO object
                $io = new IO(substr($data, $start, $length));
                $nb_io = $io->getNbIO();
                
                // Seeking for IO[$size] IDs and Values
                for ($k = 0; $k < $nb_io; $k++) {
                    $start += $length;
                    $length = $this->_offset * LENGTH_IO_ID;
                    $io_id = substr($data, $start, $length);
                    
                    $start += $length;
                    $length = $this->_offset * LENGTH_IO_VALUE * $size;
                    $io_value = substr($data, $start, $length);
                    
                    $io->addEvent($io_id, $io_value);
                    
                }
                $avl_data->io_element->setIO($size, $io);
            }
            $this->_avl_packet->avl_data_array->addAVLData($avl_data);
        }
        
        return $this->_avl_packet->avl_data_array;
    }
    
}
?>