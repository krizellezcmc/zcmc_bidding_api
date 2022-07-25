<?php

    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: *");


    /* Attempt MySQL server connection. Assuming you are running MySQL
    server with default setting (user 'root' with no password) */
    $db = mysqli_connect("127.0.0.1", "root", "", "zcmc_bidding");
    
    // Check connection
    if($db === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    // Print host information
    // echo "Connect Successfully. Host info: " . mysqli_get_host_info($db);

?>