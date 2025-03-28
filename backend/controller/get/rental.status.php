<?php

 header("Access-Control-Allow-Origin:*");
 header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
 header("Access-Control-Allow-Headers: Content-Type");

 include("../../db.php");

      $owner_id=$_GET["owner_id"];
      $mode=$_GET['mode'];

         $sql='SELECT * FROM rental WHERE owner_id=? AND mode=?';

            $stsm=$conn->prepare($sql);
            $stsm->bind_param("is", $owner_id, $mode );
            $stsm->execute();
            $result = $stsm->get_result();
            $rentals=$result->fetch_all(MYSQLI_ASSOC);

 if(empty($rentals)){

    echo json_encode(["message"=>"no rental found"]);
     }
    echo json_encode(['rentals'=>$rentals]);

mysqli_close($conn)
?>