<?php 
class manager{
    public $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function get_all_manager(){
        $array = array();
        $query = "SELECT emp_id, name,emp_no FROM employee_header_all WHERE profile_id = 'PFL-00002'" ;
        $query_result = $this->conn->query($query);
        $row_count = mysqli_num_rows($query_result);
        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "Get all manager", "manager"=>$array];
            return $response;
        }
    }
}
?>