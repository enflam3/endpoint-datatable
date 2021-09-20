<?php
class Endpoint
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
                    for ($i = 1; $i <= $limit; $i++) {
                        $this->db->query('INSERT INTO datatable (timestamp, data1, data2) VALUES(:timenow, :offset, :hexstr)');
                        $this->db->bind(':timenow', date("d-m-Y H:i:s"));
                        $this->db->bind(':offset', $offset);
                        $this->db->bind(':hexstr', $endpoint_result[$i-1]);
                    //Execute function
                        $this->db->execute();
                    }
                }
            }
        }

        return $endpoint_result;

    }

}