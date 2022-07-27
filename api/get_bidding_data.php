<?php 

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':

            $item = $db->prepare('SELECT PK_itemId, itemDesc, quantity, lastEdit FROM item where PK_itemId = ? AND dateAdded = ?' );
            $item->bind_param('is', $_GET['itemId'], $_GET['dateSelected']);
            $item->execute();
            $get = $item->get_result();
            $item = $get->fetch_assoc();

            $stmt = $db->prepare('SELECT bidding.FK_supplierId as supplierId, bidding.unitCost as unitCost, bidding.lastEdit as lastEdit from bidding INNER JOIN item ON bidding.FK_itemId = item.PK_itemId INNER JOIN supplier ON bidding.FK_supplierId = supplier.PK_supplierId WHERE bidding.FK_itemId = ? AND bidding.dateAdded = ? GROUP BY bidding.FK_supplierId');
            $stmt->bind_param('is', $_GET['itemId'], $_GET['dateSelected']);
            $stmt->execute();
            $get = $stmt->get_result(); 
            $result = $get->fetch_all(MYSQLI_ASSOC);

            $storage = array_push($item, $result);

           echo json_encode($item);
           
        break;
    }
