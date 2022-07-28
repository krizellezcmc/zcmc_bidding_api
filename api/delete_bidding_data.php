<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
            $details = json_decode(file_get_contents('php://input'));

            $itemId = $details->itemId;
            $date = $details->date; 
            $itemName = $details->itemName; 
            
            $stmt = $db->prepare("DELETE from bidding WHERE FK_itemId = ? AND dateAdded = ?");
            $stmt->bind_param("is", $itemId, $date);

                if($stmt->execute()) {
                   
                    $bidding = $db->prepare("DELETE from item WHERE PK_itemId = ? AND dateAdded = ?");
                    $bidding->bind_param("is", $itemId, $date);

                        if($bidding->execute()){
                            $winner = $db->prepare("DELETE from winners WHERE wItemDesc = ? AND dateAdded = ?");
                            $winner->bind_param("ss", $itemName, $date);

                            if($winner->execute()){
                                $data = ['status' => 1, 'message' => "Item deleted"];
                            }else {
                                $data = ['status' => 0, 'message' => "Delete failed"];
                            }
                   
                        }else {
                            $data = ['status' => 0, 'message' => "Delete failed"];
                        }
                   

                } else {
                    $data = ['status' => 0, 'message' => "Failed"];
                }
            
            echo json_encode($data);
            break;
}

?>