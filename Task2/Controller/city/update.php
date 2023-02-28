<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


include_once '../../Config/database.php';
include_once '../../Models/user.php';

$database = new Database();
$db = $database->getConnection();

$city = new City($db);

$city->id = $_POST['id'];
$city->name = $_POST['name'];

if ($city->update()) {
    http_response_code(204);

    echo json_encode(array("message" => "Город успешно обновлен"));
} else {

    http_response_code(503);

    echo json_encode(array("message" => "Не удалось обновить город"));
}
