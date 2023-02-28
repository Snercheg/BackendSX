<?php

require_once '../vendor/autoload.php';


Class Database
{
    private string $host;
    private string $port;
    private string $db_name;
    private string $username;
    private string $password;

    public ?PDO $connection = null;

    public function getConnection(): PDO{

        $dotenv = Dotenv\Dotenv::createImmutable("../");
        $dotenv->load();

        $this->host = $_ENV["POSTGRES_HOST"];
        $this->port = $_ENV["POSTGRES_PORT"];
        $this->db_name = $_ENV["DATABASE_NAME"];
        $this->username = $_ENV["POSTGRES_USER"];
        $this->password = $_ENV["POSTGRES_PASSWORD"];
        echo $this->host;
        var_dump($this->host);
        try{
            $this ->connection = new PDO("pgsql:host=" . $this->host. ";port=" . $this->port . ";dbname=" . $this->db_name . ";user=" . $this->username . ";password=" . $this->password);
            $this->connection->exec("set names utf8");
        } catch (PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->connection;
    }

}
$database = new Database();
var_dump($database->getConnection());
