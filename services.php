<?php
require_once "./config.php";

/*
definition of returned numbers:

    0 = no error
    1 = user not found
    2 = user already exist
    3 = wronge attribute
    
*/

class UserDatabaseService extends Database
{
    // Create (C in CRUD)
    public function createUser($username, $email, $password)
    {
        $user = $this->readUser($username);
        if (empty($user)) {
            $stmt = $this->connect()->prepare("INSERT INTO users (id, username, email, password) VALUES (NULL, ?, ?, ?)");
            $stmt->execute([$username, $email, $password]);
            return 0;
        } else {
            return 2;
        }
    }

    // Read (R in CRUD)
    public function readUser($username)
    {
        $stmt = $this->connect()->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if (!empty($user)) {
            return [
                "username" => $user["username"],
                "email" => $user["email"],
                "password" => $user["password"] // !!! not safe !!!
            ];
        } else {
            return [];
        }
    }

    public function readAllUsers()
    {
        $stmt = $this->connect()->query("SELECt * FROM users");
        return $stmt->fetchAll();
    }

    //Update (U in CRUD)
    public function updateUser($username, $attr, $value)
    {
        $user = $this->readUser($username);
        if (!empty($user)) {
            # because i check attribute(attr) in switch statment i will be sure that script don't face " SQL Injection " 
            $query = "UPDATE users SET $attr = ? WHERE username = ?";
            switch ($attr) {
                case "username":
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$value, $username]);
                    return true;
                    break;
                case "email":
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$value, $username]);
                    return true;
                    break;
                case "password":
                    $stmt = $this->connect()->prepare($query);
                    $stmt->execute([$value, $username]);
                    return true;
                    break;
                default:
                    return 3;
            }
        } else {
            return 1;
        }
    }

    //DELETE (D in CRUD)
    public function deleteUser($username)
    {
        $user = $this->readUser($username);
        if (!empty($user)) {
            $stmt = $this->connect()->prepare("DELETE FROM users WHERE username = ?");
            $stmt->execute([$username]);
            return 0;
        } else {
            return 1;
        }
    }
}
