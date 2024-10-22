<?php 
class department{
    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function get_department(){
        $array = array();
        $query = "SELECT dept_id, dept_name, status FROM department_header_all";
        $query_result = $this->conn->query($query);
        $row_count = mysqli_num_rows($query_result);
        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "Get all departmenr", "department"=>$array];
            return $response;
        }
    }
}
?>