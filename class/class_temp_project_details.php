<?php 
class temp_project{
    public $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    public function get_temp_project_data($project_id){
        $array = array();
        $query_01 = "select * from temporary_project_header_all where project_id='$project_id'";
        $query_result =$this->conn->query($query_01);
        $row_count = mysqli_num_rows($query_result);

        if ($row_count > 0) {
            $array = mysqli_fetch_assoc($query_result);
            $response = ["msg" => "temp project found", "projects"=>$array];
        } else {
            $response = ["msg" => "project not found"];   
        }
        return $response;
    }
}
?>