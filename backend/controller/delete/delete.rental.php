<?php

   include('../../db.php');
 
   header("Access-Control-Allow-Origin:*");
   header("Access-Control-Allow-Methods:POST, GET, DELETE, OPTIONS,");
   header("Access-Control-allow-Headers:Content-Type");

   $data=json_decode(file_get_contents("php://input"), true);
          $rental_id = $data['rental_id'] ?? null;

   $sql='DELETE FROM rental WHERE id=?';

         $stsm=$conn->prepare($sql);
         $stsm->bind_param("i", $rental_id);

     if ($stsm->execute()) {
       echo json_encode(["message" => "deleted successful"]);
     } else {
       echo json_encode(["error" => "delete feiled"]);
     }

mysqli_close($conn);

?>