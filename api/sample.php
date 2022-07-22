<?php


include '../connection/config.php';


$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':
 $details = json_decode(file_get_contents('php://input'));

$supplierDetails =  $details->suppliers;


$object = array_reduce($supplierDetails, function($a, $b){
    return $a->unitCost < $b->unitCost ? $a : $b;
}, array_shift($supplierDetails));


echo json_encode($object);

}

?>