<?php
include '../connection/config.php';

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':

        $sql="SELECT 
                winners.FK_supplierId, supplier.supplierName, SUM(winners.wQuantity*winners.wCost) 
                AS totalCost FROM winners 
                INNER JOIN supplier 
                ON winners.FK_supplierId=supplier.PK_supplierId
                WHERE winners.dateAdded = ? 
                GROUP BY supplier.supplierName";

        $stmt=$db->prepare($sql);
        $stmt->bind_param('s', $_GET['dateSelected']);
        $stmt->execute();
        $supplierTotal=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        echo json_encode($supplierTotal);
        break;
}

?>