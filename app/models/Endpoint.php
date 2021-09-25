<?php

class Endpoint extends Parse
{
    private $db;

    public function __construct()
    {
        $this->db = new Database;

    }

    private $apiUrl = API_URL;
    private $apiKey = API_KEY;
    private $error;

    public function apiResponse($limit, $offset)
    {
        $endpoint = $this->apiUrl . '?key=' . $this->apiKey . '&limit=' . $limit . '&offset=' . $offset;

        if (($endpoint_data = @file_get_contents($endpoint)) === false)
        {
            //Problem with URL or Endpoint server
            $error = error_get_last();
            $endpoint_result = $error['message'];
        }
        else
        {
            $endpoint_data = json_decode($endpoint_data);
            $endpoint_success = $endpoint_data->success;
            $endpoint_msg = $endpoint_data->message;

            if (!$endpoint_success)
            {
                //No success message from API
                $endpoint_result = $endpoint_msg;
            }
            else
            {
                if (empty($endpoint_data->data))
                {
                    //Empty data array from API
                    $endpoint_result = 'No data at selected offset';
                }
                else
                {
                    //Success data array from API
                    $endpoint_result = $endpoint_data->data;

                    //Write API Hex array to DB
                    for ($i = 1; $i <= $limit; $i++) {+
                        $hexstr = $endpoint_result[$i-1];
                        $this->db->query('INSERT INTO datatable (timestamp, data1, data2, data3, data4, raw) VALUES(:timestamp, :gps, :data2, :data3, :data4, :raw)');
                        $this->db->bind(':timestamp', $this->getTimestamp($hexstr));
                        $this->db->bind(':gps', $this->getGps($hexstr));
                        $this->db->bind(':data2', $this->getOnebyteIO($hexstr));
                        $this->db->bind(':data3', $this->getTwobyteIO($hexstr));
                        $this->db->bind(':data4', $this->getFourbyteIO($hexstr));
                        $this->db->bind(':raw', $hexstr);
                        
                    //Execute function
                        $this->db->execute();
                    }
                }
            }
        }

        return $endpoint_result;
    }

}