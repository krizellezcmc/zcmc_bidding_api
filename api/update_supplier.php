<?php
include '../connection/config.php';

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'POST':

        $details = json_decode(file_get_contents('php://input'));

        $sql="UPDATE supplier SET supplierName = ?, contactType = ?, contactNumber = ?, contactPerson = ?, supplierAddress = ? WHERE PK_supplierid=?";
        $stmt=$db->prepare($sql);

        $supplierId = $details->id;
        $supplier = $details->supplier;
        $contactType= $details->contactType;
        $contact = $details->contact;
        $contactPerson = $details->contactPerson;
        $address = $details->address;

        $stmt->bind_param('sssssi', $supplier, $contactType, $contact, $contactPerson, $address, $supplierId);

        if($stmt->execute()) {
            $response = ['status' => 1, 'message' => 'Record updated successfully.'];
        } else {
            $response = ['status' => 0, 'message' => 'Failed to update record.'];
        }
        echo json_encode($response);

        break;

    }

?>