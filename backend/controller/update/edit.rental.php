<?php
include('../../db.php');

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Method: POST, GET, OPTIONS");
header('Access-Control-Allow-Headers: Content-Type');

$data=json_decode(file_get_contents('php://input'), true);

   $owner_email = $data['owner_email'] ?? null;
   $id=$data['id'] ?? null;
   $rental_date=$data['rental_date']?? null;
   $rent=$data['rent']?? null;
   $mode=$data['mode']?? null;
   $category_name = $data['category_name']?? null;

$sql="SELECT rental_date, owner_email, rent, mode, category_name FROM rental WHERE id = ?";

   $stsm=$conn->prepare($sql);
   $stsm->bind_param("i", $id);
   $stsm->execute();
   $result=$stsm->get_result();

$oldData=$result->fetch_assoc();

   $up_rental_date =  !empty($data['rental_date']) ? $data['rental_date'] : $oldData['rental_date'];
   $up_owner_email = !empty($data['owner_email']) ? $data['owner_email'] : $oldData['owner_email'];
   $up_rent =  !empty($data['rent']) ? $data['rent'] : $oldData['rent'];
   $up_mode =  !empty($data['mode']) ? $data['mode'] : $oldData['mode'];
   $up_category_name = !empty($data['category_name']) ? $data['category_name'] : $oldData['category_name'];

$updateSql = "UPDATE rental SET rental_date = ?, owner_email = ?, rent = ?, mode = ?, category_name= ?  WHERE id = ?";

    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssissi", $up_rental_date, $up_owner_email, $up_rent, $up_mode,  $up_category_name, $id);

if ($stmt->execute()) {
    echo json_encode(["message" => "rental updated successful"]);
} else {
    echo json_encode(["error" => "update feild"]);
    exit;
}

mysqli_close($conn);
?>