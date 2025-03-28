<?php

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include("../../db.php");

  $owner_id=$_GET['owner_id'] ?? null;
  $value=$_GET['value'] ?? null;

        $sql=" SELECT * FROM rental WHERE owner_id = ?  AND (category_name = ?  OR owner_email = ?)
          UNION ALL
          SELECT * FROM rental WHERE owner_id = ?  AND NOT EXISTS ( SELECT 1 FROM rental  WHERE owner_id = ?  AND (category_name = ?  OR owner_email = ?))
          ORDER BY rental_date DESC";

               $stsm=$conn->prepare($sql);
               $stsm->bind_param("issiiss", $owner_id, $value, $value, $owner_id, $owner_id, $value, $value );
               $stsm->execute();
               $result = $stsm->get_result();

    if($result->num_rows===0){
        $sql="SELECT * FROM rental WHERE owner_id=?";

              $refreshStsm = $conn->prepare($sql);
              $refreshStsm->bind_param("i", $owner_id);
              $refreshStsm->execute();
              $refreshResult = $refreshStsm->get_result();

           if($refreshResult->num_rows>0){
              $rentals=$refreshResult->fetch_all(MYSQLI_ASSOC);
                echo json_encode(["rentals"=>$rentals]);
              }else{
              echo json_encode("no rentals found");
              }
    }else{
        $rentals=$result->fetch_all(MYSQLI_ASSOC);
        echo json_encode(["rentals"=>$rentals]);
     }


 mysqli_close($conn);
?>