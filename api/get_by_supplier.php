<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
        
            $stmt = $db->prepare("SELECT qty, item, Cost, total FROM ( SELECT item.itemDesc as item, item.quantity as qty, MIN(CASE WHEN bidding.FK_itemId THEN CONCAT(bidding.unitCost, ' - ', supplier.supplierName) END) as Cost, MIN(CASE WHEN bidding.FK_itemId THEN bidding.unitCost*item.quantity END) as total FROM bidding LEFT JOIN item ON bidding.FK_itemId = item.PK_itemId LEFT JOIN supplier on bidding.FK_supplierId = supplier.PK_supplierId where bidding.dateAdded = ? GROUP BY bidding.FK_itemId)T;");

            $stmt->bind_param('s', $_GET['dateSelected']);
            $stmt->execute();
            $supplierTotal=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);

            echo json_encode($supplierTotal);
            break;
}
