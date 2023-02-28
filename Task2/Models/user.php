<?php

use JetBrains\PhpStorm\NoReturn;

class User
{
    private ?PDO $connection;
    private string $table_name = "users";
    public int $id;
    public string $username;
    public int $city_id;

    public  string $name;

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function get(): bool|PDOStatement
    {

        $query = "SELECT cities.name as city_name, user.id, user.name, user.username FROM " . $this->table_name . "  LEFT JOIN cities ON user.city_id = city.id ORDER BY user.id DESC;";

        $state = $this->connection->prepare($query);

        $state->execute();

        return $state;
    }

    function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET name=:name, city_id=:city_id, username=:username";

        $state = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->city_id = htmlspecialchars(strip_tags($this->city_id));
        $this->username = htmlspecialchars(strip_tags($this->username));


        $state->bindParam(":name", $this->name);
        $state->bindParam(":city_id", $this->city_id);
        $state->bindParam(":username", $this->username);

        if ($state->execute()) {
            return true;
        }

        return false;
    }

    function delete(): bool{
        $query = "DELETE FROM " . $this->table_name . "WHERE SET id = :id";
        $state = $this->connection->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $state->bindParam(":id", $this->id);

        if($state->execute()){
            return true;
        }

        return false;
    }

    function update(): bool{
        $query = "UPDATE " . $this->table_name . " SET name = :name, username = :username, city_id = :city_id WHERE id = :id";
        $state = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->city_Id = htmlspecialchars(strip_tags($this->city_Id));
        $this->username = htmlspecialchars(strip_tags($this->username));

        $state->bindParam(":name", $this->name);
        $state->bindParam(":id", $this->id);
        $state->bindParam(":city_id", $this->city_Id);
        $state->bindParam(":username", $this->username);

        if($state->execute()){
            return true;
        }

        return false;
    }

}