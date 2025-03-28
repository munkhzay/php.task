 <?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type");

    include("../../db.php");

    $data = json_decode(file_get_contents("php://input"), true);

      if (!empty($data['email']) && !empty($data['password'])) {

       $email = $data['email'];
       $password = $data['password'];
       $hash=password_hash($password, PASSWORD_DEFAULT);

       $sql = "INSERT INTO users (email, password) VALUES (?, ?)";
       $stsm=$conn->prepare($sql);
       $stsm->bind_param("ss", $email, $hash);


    if ($stsm->execute()) {
    echo json_encode(["message"=>"user is now registered"]);
    } else {
    echo json_encode("field:" . $stsm->error);
    }
    } else {
    echo json_encode("data field");
    exit;
    }

  mysqli_close($conn);
  
 ?>
