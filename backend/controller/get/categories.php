<?php

   header("Access-Control-Allow-Origin: *");
   header("Access-Control-Allow-Methods:POST, GET, OPTIONS");
   header("Access-Control-Allow-Headers:Content-Type");

  include('../../db.php');

      $owner_id=$_GET['owner_id']?? null;

       $sql='SELECT * FROM category WHERE owner_id=?';

        $stsm=$conn->prepare($sql);
        $stsm->bind_param("i", $owner_id);
        $stsm->execute();
        $result=$stsm->get_result();
        $categories=$result->fetch_all(MYSQLI_ASSOC);

 if(empty($categories)){
   
   echo json_encode(["message"=>"no categories found"]);
 };
    echo json_encode(['categories'=>$categories]);

  mysqli_close($conn)

?>