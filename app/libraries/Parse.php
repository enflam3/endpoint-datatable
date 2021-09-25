<?php

require_once '../app/libraries/Parser/Parser.class.php';

class Parse
{
    
    public $avl_data_array;
    
    public function parseHex($data) {
        $parser = new Parser($data);
        $avl_data_array = $parser->parse();
        $avl_data = $avl_data_array->getAVLDatas()[0];
        return $avl_data;
    }

    public function getTimestamp($hex)
    {
        $data = $this->parseHex($hex);
        return $data->getStrTimestamp();
    }

    public function getGps($hex)
    {
        $data = $this->parseHex($hex);
        $latlong = $data->gps_element->getLatitude().','.$data->gps_element->getLongitude();
        return $latlong;
    }

    public function getOnebyteIO($hex)
    {
        $data = $this->parseHex($hex);
        $iodata = $data ->io_element->_io_array[1]->_events;
        return json_encode($iodata);
    }

    public function getTwobyteIO($hex)
    {
        $data = $this->parseHex($hex);
        $iodata = $data ->io_element->_io_array[2]->_events;
        return json_encode($iodata);
    }

    public function getFourbyteIO($hex)
    {
        $data = $this->parseHex($hex);
        $iodata = $data ->io_element->_io_array[4]->_events;
        return json_encode($iodata);
    }
    
}