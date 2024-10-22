<?php 
class get_project_count{
    public $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }

    public function get_ongoing_project(){
        $array = array();
        $query = "select * from project_header_all where status = ''";
        $query_result = $this->conn->query($query);
        $row_count = mysqli_num_rows($query_result);

        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "all operstional projects", "projects"=>$array];
            return $response;
        }
    }

    public function get_compleate_project(){
        $array = array();
        $query = "select * from project_header_all where status = ''";
        $query_result = $this->conn->query($query);
        $row_count = mysqli_num_rows($query_result);

        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "all operstional projects", "projects"=>$array];
            return $response;
        }
    }

    public function get_closed_project(){
        $array = array();
        $query = "select * from project_header_all where status = ''";
        $query_result = $this->conn->query($query);
        $row_count = mysqli_num_rows($query_result);

        if ($row_count > 0) {
            while ($arr = mysqli_fetch_assoc($query_result)) {
                array_push($array, $arr);
            }
            $response = ["msg" => "all operstional projects", "projects"=>$array];
            return $response;
        }
    }
}

?>