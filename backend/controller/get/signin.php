<?php

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type");

   include('../../db.php');

    $data=json_decode(file_get_contents("php://input"), true);
    $email=$data["email"];
    $password=$data["password"];

       $sql="SELECT * FROM users WHERE email=?";

           $stsm=$conn->prepare($sql);
           if (!$stsm) {
            echo json_encode(["error" => "Database error"]);
            exit;
        }
           $stsm->bind_param("s", $email);
           $stsm->execute();
           $result = $stsm->get_result();
           $user = $result->fetch_assoc();

     if (!$user) {
       echo json_encode(["message" =>"user not found"]);
        exit;
     }

    if (!password_verify($password, $user['password'])) {
      
       echo json_encode(["message" =>"password not match"]);
        exit;
     }
       echo json_encode(['user' => $user]); 

mysqli_close($conn);

?>