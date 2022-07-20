<?php
include '../connection/config.php';

$method=$_SERVER['REQUEST_METHOD'];

switch($method){
    case 'GET':


        $sql="SELECT supplier.supplierName, SUM(bidding.unitCost*item.quantity) AS totalCost FROM ((bidding INNER JOIN supplier ON bidding.FK_supplierId=supplier.PK_supplierId) 
                INNER JOIN item ON bidding.FK_itemId=ITEM.PK_itemId) where bidding.dateAdded = ? GROUP BY supplier.supplierName";

        $stmt=$db->prepare($sql);
        $stmt->bind_param('s', $_GET['dateSelected']);
        $stmt->execute();


        $supplierTotal=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        
        $supplier=array();

        echo json_encode($supplierTotal);

        break;
}

?>