<?php
    require_once '../connection/config.php';
    session_start();

    
$method = $_SERVER['REQUEST_METHOD'];

    switch($method) {
        case 'POST':

        $user = json_decode(file_get_contents('php://input'));

        $username = $user->username;
        $password = $user->password;

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if(mysqli_num_rows($result) > 0) {
            while($user = $result->fetch_assoc()) {
                if(password_verify($password, $user['password'])) {
                 
                    $data = ['status' => 0, 'message' => "success"];

                } else {
                    $data = ['status' => 0, 'message' => "failed"];
                } 
            }     
        } else {
             $data = ['status' => 0, 'message' => "User does not exist"];
        }

        echo json_encode($data);
        break;
    }
?>