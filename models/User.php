<?php

namespace app\models;

use app\config\Database;
use PDO;

class User
{
    private $config;
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $email;
    public $emailErr = '';
    public $password;
    public $passwordErr = '';
    public $powers = 'ordinary';
    public function __construct()
    {
        $this->config = require '../config/config.php';
        $database = new Database($this->config);
        $this->conn = $database->getConnection();
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->table_name . " SET username=:username, email=:email, password=:password, powers=:powers";
        $stmt = $this->conn->prepare($query);

        // تنظيف البيانات
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));
        $this->powers = htmlspecialchars(strip_tags($this->powers));

        // ربط القيم بالاستعلام
        $stmt->bindParam(":username", $this->username);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":password", $this->password);
        $stmt->bindParam(":powers", $this->powers);

        // تنفيذ الاستعلام
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll()
    {
        $query = "SELECT id, username, email, powers FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById()
    {
        $query = "SELECT id, username, email, powers FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $this->id);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->username = $user['username'];
            $this->email = $user['email'];
            $this->powers = $user['powers'];
        }
    }



    public function isAdmin()
    {
        return $this->powers == 'manager';
    }

    public function isRegistered()
    {
        $query = "SELECT id FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function authenticate()
    {
        $query = "SELECT id, username, email, password, powers FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(":email", $this->email);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->id = $user['id'];
            $this->username = $user['username'];
            $this->powers = $user['powers'];
            var_dump($user['password']); // Stored hashed password
            var_dump($this->password); // Entered password
            if (password_verify($this->password, $user['password'])) {
                return true;
            } else {
                $this->passwordErr = 'The password is falid';
                return false;
            }
        } else {
            $this->emailErr = 'This email not found';
            return false;
        }
    }
}
