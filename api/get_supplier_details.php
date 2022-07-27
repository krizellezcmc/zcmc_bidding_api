<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
        
            $stmt = $db->prepare("SELECT supplierAddress, contactType, contactPerson, contactNumber FROM supplier where supplierName = ?;");
            $stmt->bind_param('s', $_GET['details']);
            $stmt->execute();
            $supplierDetails=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            echo json_encode($supplierDetails);
            break;
}
