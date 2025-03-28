 <?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    include("../../db.php");

    $data = json_decode(file_get_contents("php://input"), true);

       $email = $data['email'];
       $password = $data['password'];
       $hash=password_hash($password, PASSWORD_DEFAULT);

       $checkEmailSql = "SELECT * FROM users WHERE email = ?";
       $checkStmt = $conn->prepare($checkEmailSql);
       $checkStmt->bind_param("s", $email);
       $checkStmt->execute();
       $result = $checkStmt->get_result();

       if ($result->num_rows > 0) {
        echo json_encode(["message" => "email already used"]);
        exit;
    } 
       $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
       $stsm=$conn->prepare($sql);
       $stsm->bind_param("ss", $email, $hash);


       if ($stsm->execute()) {
        echo json_encode(["message" => "user is now registered"]);
    } else {
        echo json_encode(["error" => "error "]);
    }
        

  mysqli_close($conn);
  
 ?>
