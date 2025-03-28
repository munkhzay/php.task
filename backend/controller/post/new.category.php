 <?php
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type");

   include('../../db.php');
  
     $data=json_decode(file_get_contents("php://input"), true);
     $category_name=$data['category_name'];
     $icon_id=$data['icon_id'];
     $owner_id=$data['owner_id'];

      $sql="INSERT INTO category( category_name, icon_id, owner_id) 
            VALUES (?, ?, ?)";

      $stsm=$conn->prepare($sql);
      $stsm->bind_param("sii", $category_name, $icon_id, $owner_id);
      $success=$stsm->execute();

  if ($success) {
    echo json_encode(["message"=>"category added successful"]);
  } else {
    echo json_encode(["field:" . $stsm->error]);
  }

 mysqli_close($conn);

?>