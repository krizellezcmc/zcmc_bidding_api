<?php

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':
        
            $stmt = $db->prepare("SELECT * FROM supplier");
            $stmt->execute();
            $result = $stmt->get_result();

            $list = $result->fetch_all(MYSQLI_ASSOC);

            echo json_encode($list);

            break;
          
}

?>