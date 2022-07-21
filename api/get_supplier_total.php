<?php
include '../connection/config.php';

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':


        $sql="SELECT 
        MIN(CASE WHEN bidding.FK_itemId THEN CONCAT(bidding.unitCost, ' - ', supplier.supplierName) END), 
        bidding.unitCost*item.quantity as 'Total' 
        FROM bidding 
        LEFT JOIN item ON bidding.FK_itemId = item.PK_itemId 
        LEFT JOIN supplier on bidding.FK_supplierId = supplier.PK_supplierId WHERE bidding.dateAdded = ? 
        GROUP BY item.itemDesc ORDER BY bidding.FK_itemId;";

        $stmt=$db->prepare($sql);
        $stmt->bind_param('s', $_GET['dateSelected']);
        $stmt->execute();

        $supplierTotal=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        $supplier=array();

        echo json_encode($supplierTotal);

        break;
}

?>