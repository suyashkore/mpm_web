<?php 
require_once("../config/config.php");

$inserted_on = date('Y-m-d H:i:s');
$client_type_id_01 = $_POST['client_type_id_01'];
$offcer_incharge = $_POST['offcer_incharge'];
$designation_of_client = $_POST['designation_of_client'];
$office_osd_name = $_POST['office_osd_name'];
$office_osd_number = $_POST['office_osd_number'];
$office_osd_email = $_POST['office_osd_email'];
$office_address = $_POST['office_address'];
$official_communication_email_id = $_POST['official_communication_email_id'];
$mobile_number = $_POST['mobile_number'];
$client_id = 'CLT=000003';
$linked_projects = '';

$quiry_for_create_client = "INSERT INTO client_header_all (client_type_id,client_id,client_designation,name_of_official,official_contact_no,official_email_id,OSD_name,OSD_contact_no,OSD_email_id,inserted_on,status,linked_projects,client_address) VALUES('$client_type_id_01','$client_id','$designation_of_client','$offcer_incharge','$mobile_number','$official_communication_email_id','$office_osd_name','$office_osd_number','$office_osd_email','$inserted_on','Active','$linked_projects','$office_address')";

$query_result = mysqli_query($conn, $quiry_for_create_client);

if ($query_result) {
    $response = ["msg" => "client created", "client_id" => $client_id];
} else {
    $response = ["msg" => "Something went wrong"];
}

header('Content-Type: application/json');

echo json_encode($response);
    
?>