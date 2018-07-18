<?php

use \App\Libraries\Database;

/**
 * Class UserManager
 */
class UserManager extends Database
{
    /**
     * @param $data mixed
     * @return mixed
     */
    public function register($data)
    {
        $stmt = $this->pdo->prepare(
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

    /**
     * @param $email
     * @param $password string
     * @return bool
     */
    public function login($email, $password)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM members WHERE email = :email');
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

    /**
     * Vérifie si l'email entré existe déjà dans la BDD
     * @param $email string
     * @return bool
     */
    public function findUserByEmail($email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM members WHERE email = :email');

        $stmt->execute(array(':email' => $email));
        $row = $stmt->rowCount();
        // vérifie si l'email est déjà enregistré dans la db
        if($row > 0) {
            return true; // l'email existe déjà
        } else {
            return false;
        }
    }

    /**
     * Vérifie si le nom de l'utilisateur entré existe déjà dans la BDD
     * @param $name string
     * @return bool
     */
    public function findUserByName($name)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM members WHERE name = :name');

        $stmt->execute(array(':name' => $name));
        $row = $stmt->rowCount();
        // vérifie si l'email est déjà enregistré dans la db
        if($row > 0) {
            return true; // l'email existe déjà
        } else {
            return false;
        }
    }

    /**
     * trouve l'utilisateur par id
     * @param $id int
     * @return mixed
     */
    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM members WHERE id = :id');

        $stmt->execute(array(':id' => $id));

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        return $result;
    }
}