<?php 

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':

            $item = $db->prepare('SELECT PK_itemId, itemDesc, quantity FROM item where PK_itemId = 977397');
            // $row->bind_param('s', $_GET['dateSelected']);
            $item->execute();
            $get = $item->get_result();
            $item = $get->fetch_all(MYSQLI_ASSOC);

            $stmt = $db->prepare('SELECT bidding.FK_supplierId, supplier.supplierName, bidding.unitCost from bidding INNER JOIN item ON bidding.FK_itemId = item.PK_itemId INNER JOIN supplier ON bidding.FK_supplierId = supplier.PK_supplierId where bidding.FK_itemId = 977397 GROUP BY bidding.FK_supplierId');
            // $row->bind_param('s', $_GET['dateSelected']);
            $stmt->execute();
            $get = $stmt->get_result();
            $result = $get->fetch_all(MYSQLI_ASSOC);


            $storage = array_push($item, $result);

           echo json_encode($item);

           

        break;
    }
