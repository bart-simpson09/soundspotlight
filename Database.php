<?php
require_once "config.php";

class Database
{
    private $username;
    private $password;
    private $host;
    private $database;

    private static $instance;
    private $conn;

    public function __construct()
    {
        $this->username = USERNAME;
        $this->password = PASSWORD;
        $this->host = HOST;
        $this->database = DATABASE;
    }

    public static function getInstance(): Database
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function connect()
    {
        if (!$this->conn) {
            try {
                $this->conn = new PDO(
                    "pgsql:host=$this->host;port=5432;dbname=$this->database",
                    $this->username,
                    $this->password,
                    ["sslmode" => "prefer"]
                );

                // set the PDO error mode to exception
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return $this->conn;
    }
}