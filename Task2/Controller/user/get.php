<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");


include_once '../../Config/database.php';
include_once '../../Models/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$state = $user->get();

$num = $state->rowCount();

if ($num > 0) {

    $user_arr = array();
    $user_arr["items"] = array();

    while ($row = $state->fetch(PDO::FETCH_ASSOC)) {

        extract($row);

        $user_item = array(
            "id" => $id,
            "username" => $username,
            "city" => $city_name,
            "name" => $name,
        );

        $user_arr["items"][] = $user_item;

    }

    http_response_code(200);

    echo json_encode($user_arr);

} else {
    http_response_code(404);

    echo json_encode(["message" => "Пользователи не найдены."]);
}