<?php

    //Set default timezone
    date_default_timezone_set('Europe/Riga');

    class Datatable{
        private $db;
        public function __construct(){
            $this->db = new Database;
        }
        public function fechAllTable() {
            $this->db->query("SELECT * FROM datatable");
            $result = $this->db->resultSet();
            return $result;
        }

        public function clearTable() {
            $this->db->query("TRUNCATE TABLE datatable");
            $result = $this->db->resultSet();
            return $result;
        }
    }