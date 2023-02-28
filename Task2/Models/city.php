<?php

class City
{
    private ?PDO $connection;
    private string $table_name = "cities";
    public int $id;
    public string $name;


    public function __construct($db)
    {
        $this->connection = $db;
    }


    public function get(): bool|PDOStatement
    {

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";

        $state = $this->connection->prepare($query);

        $state->execute();

        return $state;
    }


    function create(): bool
    {

        $query = "INSERT INTO " . $this->table_name . " SET name=:name";

        $state = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $state->bindParam(":name", $this->name);

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
        $query = "UPDATE " . $this->table_name . " SET name = :name WHERE id = :id";
        $state = $this->connection->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $state->bindParam(":name", $this->name);
        $state->bindParam(":id", $this->id);

        if($state->execute()){
            return true;
        }

        return false;
    }
}