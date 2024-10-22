<!-- <?php  
print_r($_POST);
class create_project {
    public $conn;
    public function __construct($conn){
        $this->conn = $conn;
    }
    public function create_project(){
        $project_id = $_POST['project_id'];
        $project_name = $_POST['project_name'];
        $client_type_option = $_POST['client_type_option'];
        $select_client = $_POST['select_client'];
        $project_status = $_POST['project_status'];
        $project_strat_date = $_POST['project_strat_date'];
        $project_complition_time = $_POST['project_complition_time'];
        $sales_person_name = $_POST['sales_person_name'];
        $sales_person_no = $_POST['sales_person_no'];
        $project_type = $_POST['project_type'];
        $revenue_amount = $_POST['revenue_amount'];
        $including_gst = $_POST['including_gst'];
        $other_taxes = $_POST['other_taxes'];
        $amount_loa = $_POST['amount_loa'];
        $percentage = $_POST['percentage'];
        $select_file_sd = $_POST['select_file_sd'];
        $amount_sd = $_POST['amount_sd'];
        $percentage_pg = $_POST['percentage_pg'];
        $select_file_pg = $_POST['select_file_pg'];
        $amount_pg = $_POST['amount_pg'];
        $percentage_bg = $_POST['percentage_bg'];
        $select_bg = $_POST['select_bg'];
        $amount_bg = $_POST['amount_bg'];
        $amontemd = $_POST['amontemd'];
        $consignee = $_POST['consignee'];
        $bill_pass_authority = $_POST['bill_pass_authority'];
        $scope_short = $_POST['scope_short'];
        $scope_details = $_POST['scope_details'];
        $project_manager = $_POST['project_manager'];
        $project_manager_team = $_POST['project_manager_team'];
        // $profit = $_POST['profit'];
        // $profit_amount = $_POST['profit_amount'];
        $loss_amount = $_POST['loss_amount'];
        $projectmanager = $_POST['projectmanager'];
        $no_of_tem_member = $_POST['no_of_tem_member'];

        $department_name = $_POST['department_name'];
        $dep_hod = $_POST['dep_hod'];
        print_r($department_name);

        $query_01 = "INSERT INTO project_header_all(project_id,project_no,project_name,client_id,client_type_id,project_type_id,project_value,short_description,scope_of_work,scope_of_work_file,consignee_id,bill_passing_authority,bill_passing_office_address,project_email_id,project_manager,accepted_by_PM,project_official_start_date,project_initiated_on,project_configured_on,project_operational_from,status,tax_id,project_completion_date,sales_team_person_details,no_team_members,NA_SD,NA_PG,NA_EMD,NA_LOA,NA_WO,NA_CON,NA_BG,NA_ADV,project_closed_on,project_close_reason) VALUES ('$project_id','','$project_name','$select_client','$client_type_option','$project_type','','','','','','','','','','','','','','','','','','','','','','','','','','','','','')";
        $query_result = $this->conn->query($query_01);

        
        $query_02 = "INSERT INTO dept_seq_definition_all(project_id) VALUES ('$project_id')";
        $query_result = $this->conn->query($query_02);
        for($i = 1;$i<=count($department_name); $i++)
        {
            $dept= $department_name[$i - 1];
            $head = $dep_hod[$i - 1];
            $query_02 = "UPDATE dept_seq_definition_all SET dept_$i = '$dept',emp_$i = '$head' WHERE project_id = '$project_id'";
            $query_result = $this->conn->query($query_02);
        }

        if ($query_result) {
            $response = ["msg" => "project created", "project_id" => $project_id];
        } else {
            $response = ["msg" => "Something went wrong"];
        }

        return $response;

    }
}

?>

