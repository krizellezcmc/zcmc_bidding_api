<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
        
            $stmt = $db->prepare("SELECT MIN(CASE WHEN bidding.FK_itemId THEN bidding.unitCost END),  MIN(CASE WHEN bidding.FK_itemId THEN bidding.unitCost * item.quantity END) as 'Total' FROM bidding LEFT JOIN item ON bidding.FK_itemId = item.PK_itemId LEFT JOIN supplier on bidding.FK_supplierId = supplier.PK_supplierId where bidding.dateAdded = ? GROUP BY item.itemDesc ORDER BY bidding.FK_itemId;");
            $stmt->bind_param('s', $_GET['dateSelected']);
            $stmt->execute();
            $result = $stmt->get_result();

            $list = $result->fetch_all();

            echo json_encode($list);

            break;
}

?>