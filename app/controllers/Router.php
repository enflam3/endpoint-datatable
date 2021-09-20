<?php
class Router extends Controller {
    public function __construct()
    {
        $this->tableModel = $this->model('Datatable');
        $this->endpointModel = $this->model('Endpoint');
    }

    public function index()
    {
        $dbRows = $this->tableModel->fechAllTable();
        
        $dbdata = [
            'rows' => $dbRows
        ];

        $this->view('index', $dbdata);
    }

    public function loader()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            if ($_POST['action'] == 'load') {

            $offset = $_POST['offset'];
            $limit = $_POST['limit'];

            //Loads data from API->DB
            $data = $this->endpointModel->apiResponse($limit,$offset);

            } else if ($_POST['action'] == 'delete') {
               
            $delete = $this->tableModel->clearTable();

            }

        }

        //Reddirects to index
        header('location:' . URLROOT . '/index');
        
    }
}