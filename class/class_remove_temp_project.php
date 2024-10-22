<?php 
// print_r($_POST);
class remove_temp_project {
    public $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    public function remove_temp_project($project_id){
      
        $query_01 = "DELETE FROM temporary_project_header_all WHERE project_id = '$project_id'";

        $query_result = $this->conn->query($query_01);

        if ($query_result) {
            $response = ["msg" => "project removed", "project_id" => $project_id];
        } else {
            $response = ["msg" => "Something went wrong"];
        }

        return $response;

    }
}

?>