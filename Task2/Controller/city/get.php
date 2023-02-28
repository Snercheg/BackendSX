<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../Config/database.php';
include_once '../Models/city.php';

$database = new Database();
$db = $database->getConnection();

$city = new City($db);

$state = $city->get();

$num = $state->rowCount();

if ($num > 0) {

    $city_arr = array();
    $city_arr["items"] = array();

    while ($row = $state->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $city_item = array(
            "id" => $id,
            "name" => $name,
        );

        $city_arr["items"][] = $city_item;

    }

    http_response_code(200);

    echo json_encode($city_arr);

} else {
    http_response_code(404);

    echo json_encode(["message" => "Города не найдены."]);
}