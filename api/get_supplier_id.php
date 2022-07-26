<?php
include '../connection/config.php';

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':


        $sql="SELECT * FROM supplier WHERE PK_supplierId = ?";

        $stmt=$db->prepare($sql);
        $stmt->bind_param('i', $_GET['supplierId']);
        $stmt->execute();

        $supplierList=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        echo json_encode($supplierList);

        break;
}

?>