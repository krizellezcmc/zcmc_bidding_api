<?php
include '../connection/config.php';

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':

        $sql="SELECT * FROM supplier";

        $stmt=$db->prepare($sql);
        $stmt->execute();

        $supplierList=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        echo json_encode($supplierList);

        break;

    }

?>