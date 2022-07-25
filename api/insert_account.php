<?php
    require_once '../connection/config.php';
    session_start();

    $email = "zcmc_mms";
    $password = password_hash("zcmc@mms", PASSWORD_DEFAULT);

        $stmt = $db->prepare("INSERT INTO users(username, password) VALUES(?, ?)");
         $stmt->bind_param("ss", $email, $password);

        $stmt->execute();
?>