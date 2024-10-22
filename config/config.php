<?php

class connection
{ 
    public $conn;
    public function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'mounac53_mpm');
    }

    public function databaseconn()
    {
        return $this->conn;
    }
}
$db = new connection();
$conn = $db->databaseconn();
?>