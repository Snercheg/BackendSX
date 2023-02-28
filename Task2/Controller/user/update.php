<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");


include_once '../../Config/database.php';
include_once '../../Models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->id = $_POST['id'];
$user->city_Id = $_POST['city_id'];
$user->name = $_POST['name'];
$user->username = $_POST['username'];

if ($user->update()) {
    http_response_code(204);

    echo json_encode(array("message" => "Пользователь успешно обновлен"));
} else {

    http_response_code(503);

    echo json_encode(array("message" => "Не удалось обновить пользователя"));
}
