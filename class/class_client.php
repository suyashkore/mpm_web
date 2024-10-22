<?php
class client
{
    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function get_client_types()
    {
        $array = array();
        $query = "SELECT client_type_id, client_type_name, status FROM client_type_header_all";
        $query_result = $this->conn->query($query);
        $row_count = mysqli_num_rows($query_result);
        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "Get all Enquiry", "client" => $array];
            return $response;
        }
    }
}
