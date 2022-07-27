<?php 

include '../connection/config.php';

$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'GET':

            // GET ROW
            $row = $db->prepare("SELECT COUNT(DISTINCT(FK_supplierId)) FROM bidding where dateAdded = ?;");
            $row->bind_param('s', $_GET['dateSelected']);
            $row->execute();
            $count = $row->get_result();
            $count_row = $count->fetch_row();

            // GET SUPPLIER DATA
            $stmt = $db->prepare("SELECT FK_supplierId from bidding where dateAdded = ? GROUP BY FK_supplierId ORDER BY FK_supplierId");
            $stmt->bind_param('s', $_GET['dateSelected']);
            $stmt->execute();
            $result = $stmt->get_result();
            // QUERY START
            $query = 'SELECT ' ;
            
            if( $count_row[0] !== 0){
                                      
                while ($data = $result->fetch_assoc()) {

                    $supplierId[] = $data['FK_supplierId'];
                        
                }
                    for($i = 0; $i < ($count_row[0] ); $i++){
                            
                        if($i != $count_row[0]-1) {
                            $query .= ' MAX(CASE WHEN bidding.FK_supplierId = '.json_encode($supplierId[$i]).' THEN CONCAT(supplier.contactType, " - ", supplier.contactPerson, " - ", supplier.contactNumber) END) , ' ;
                            
                        } else {
                                $query .= ' MAX(CASE WHEN bidding.FK_supplierId = '.json_encode($supplierId[$i]).' THEN CONCAT(supplier.contactType, " - ", supplier.contactPerson, " - ", supplier.contactNumber) END) ';
                        }
                    }
                
                $query .= ' FROM bidding LEFT JOIN supplier ON bidding.FK_supplierId = supplier.PK_supplierId where bidding.dateAdded = ?;';

                $getBidding = $db->prepare($query);
                $getBidding->bind_param('s', $_GET['dateSelected']);
            
                if($getBidding->execute()){

                $result = $getBidding->get_result();

                $all = $result->fetch_all();
                    echo json_encode($all);
                }
            } else {
                echo json_encode([]);
            }
           
            break;


            
}

?>




