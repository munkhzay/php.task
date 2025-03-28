 <?php
   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
   header("Access-Control-Allow-Headers: Content-Type");
 
   include('../../db.php');

    $owner_id=$_GET["owner_id"] ?? null;

      $sql='SELECT * FROM rental WHERE owner_id=?';

         $stsm=$conn->prepare($sql);
         $stsm->bind_param("i", $owner_id);
         $stsm->execute();
         $result = $stsm->get_result();
         $rentals = $result->fetch_all(MYSQLI_ASSOC);

    if(empty($rentals)){
       echo json_encode('no rentals found');
      exit;
     };
    echo json_encode(["rentals"=>$rentals]);

  mysqli_close($conn);
?>