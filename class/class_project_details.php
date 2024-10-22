<?php 
class project{
    public $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    public function get_project_data(){
        $array = array();
        $query_01 = "select * from project_header_all";
        $query_result =$this->conn->query($query_01);
        $row_count = mysqli_num_rows($query_result);

        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "project found", "projects"=>$array];
        } else {
            $response = ["msg" => "project not found"];   
        }
        return $response;
    }
}
?>