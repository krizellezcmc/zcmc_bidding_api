<?php
include "../connection/config.php";

// Give you Method used to hit API
$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'POST':

        // Read the POST JSON data and convert it into PHP Object
        $supply=json_decode(file_get_contents("php://input"));

        $stmt=$db->prepare("INSERT INTO supplier(PK_supplierId, supplierName, contactType, contactNumber, contactPerson, supplierAddress) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("isssss", $randomId, $supplier, $contactType, $contact, $contactPerson, $address);

        $randomId=(rand(1,1000000));
        $supplier=$supply->supplier;
        $contactType=$supply->contactType;
        $contact=$supply->contact;
        $contactPerson=$supply->contactPerson;
        $address=$supply->address;
    

        if($stmt->execute()){
            $data=['status'=>1, 'message' =>"Item successfully created."];
        } else{
            $data=['status'=>0, 'message' => "Failed to create item."];
        }

        echo json_encode($data);
        break;

}

?>