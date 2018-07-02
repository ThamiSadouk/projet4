<?php
use \App\Libraries\Database;

class UserManager extends Database
{
    public function register($data)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare(
            'INSERT INTO members (name, email, password, registration_date) 
                      VALUES (:name, :email, :password, NOW())');
        // bind values
        $registered = $stmt->execute(array(
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => $data['password']
        ));

        return $registered;
    }
    // login User
    public function login($email, $password)
    {
        $db = $this->dbConnect();
        $stmt = $db->prepare(
            'SELECT * 
                      FROM members 
                      WHERE email = :email ');
        $stmt->execute(array(
            ':email' => $email
        ));

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        $hashed_password = $result->password;
        if(password_verify($password, $hashed_password)) {
            return $result;
        } else {
            return false;
        }
    }

    // trouve l'utilisateur par mail
    public function findUserByEmail($email)
    {
        // appelle des methodes query et bind dans libraries/Controller
        $db = $this->dbConnect();
        $stmt = $db->prepare(
            'SELECT * 
                      FROM members 
                      WHERE email = :email');
        $stmt->execute(array(':email' => $email));
        $row = $stmt->rowCount();
        // vérifie si l'email est déjà enregistré dans la db
        if($row > 0) {
            return true; // l'email existe déjà
        } else {
            return false;
        }
    }

    // trouve l'utilisateur par id
    public function getUserById($id)
    {
        // appelle des methodes query et bind dans libraries/Controller
        $db = $this->dbConnect();
        $stmt = $db->prepare(
            'SELECT * 
                      FROM members 
                      WHERE id = :id');
        $stmt->execute(array(
            ':id' => $id
        ));

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }
}