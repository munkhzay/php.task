<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

include('../../db.php');

$data = json_decode(file_get_contents("php://input"), true);

    $owner_email = $data['owner_email'];
    $owner_id=$data['owner_id'];
    $rental_date=$data['rental_date'];
    $rent=$data['rent'];
    $mode=$data['mode'];
    $category_name = $data['category_name'];

$sql = "INSERT INTO rental (owner_id, rental_date, rent, mode, category_name, owner_email)
    VALUES (?, ?, ?, ?, ?, ?)";

    $stsm=$conn->prepare($sql);
    $stsm->bind_param("isisss", $owner_id, $rental_date, $rent, $mode, $category_name, $owner_email);
    $success=$stsm->execute();

if ($success) {
    echo json_encode(["message"=>"rentals added successful"]);
} else {
    echo json_encode (["field:" . $stsm->error]);
    exit;
}

mysqli_close($conn);

?>