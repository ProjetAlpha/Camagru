<?php

require_once(ROOT."/utils.php");

class UserModel
{
    private $db;

    public function __construct()
    {
        require(ROOT."/database.php");
        $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function userExist($mail, $name = null)
    {
        if ($name !== null)
            $sql = "SELECT email,name FROM Users WHERE email=? AND name=?";
        else
            $sql = "SELECT email,name FROM Users WHERE email=?";
        $prepare = $this->db->prepare($sql);
        if ($name !== null){
            $prepare->execute([$mail, $name]);
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            return (isset($result['email']) && isset($result['name'])
                && !empty($result['email']) && !empty($result['name']));
        }
        else {
            $prepare->execute([$mail]);
            $result = $prepare->fetch(PDO::FETCH_ASSOC);
            return (isset($result['email']) && !empty($result['email']));
        }
    }

    public function userNameExist($name)
    {
        $sql = "SELECT name FROM Users WHERE name=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return (isset($result['name']) && !empty($result['name']));
    }

    public function createUser($name, $password, $mail, $confirmationLink)
    {
        $data = [
          'is_confirmed' => false,
          'confirmation_link' => $confirmationLink,
          'name' => $name,
          'password' => $password,
          'email' => $mail
        ];
        $sql = "INSERT INTO Users (is_confirmed, confirmation_link, name, password, email)
        VALUES (:is_confirmed, :confirmation_link, :name, :password, :email)";
        $this->db->prepare($sql)->execute($data);
    }

    public function getName($email)
    {
        $sql = "SELECT name FROM Users WHERE email=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$email]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['name']);
    }

    public function is_confirmed($name, $type)
    {
        if ($type == "name") {
            $sql = "SELECT is_confirmed FROM Users WHERE name=?";
        }
        if ($type == "email") {
            $sql = "SELECT is_confirmed FROM Users WHERE email=?";
        }
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return (isset($result['is_confirmed']) && !empty($result['is_confirmed']) && $result['is_confirmed'] == 1);
    }

    public function is_reset($email, $type)
    {
        if ($type == "name") {
            $sql = "SELECT is_reset FROM Users WHERE name=?";
        }
        if ($type == "email") {
            $sql = "SELECT is_reset FROM Users WHERE email=?";
        }
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$email]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['is_reset'] == IS_RESET);
    }

    public function getUserHash($name, $type)
    {
        if ($type == "name") {
            $sql = "SELECT password FROM Users WHERE name=?";
        }
        if ($type == "email") {
            $sql = "SELECT password FROM Users WHERE email=?";
        }
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['password']);
    }

    public function setConfirmation($name, $link, $uncheck = null)
    {
        $sql = "UPDATE Users SET is_confirmed=? WHERE name=?";
        if ($uncheck !== null) {
            $this->db->prepare($sql)->execute(['0', $name]);
        } else {
            $this->db->prepare($sql)->execute(['1', $name]);
        }
    }

    public function setResetConfirmation($link)
    {
        $sql = "UPDATE Users SET is_reset=? WHERE change_link=?";
        $this->db->prepare($sql)->execute([IS_RESET, $link]);
    }

    public function isValidReset($mail)
    {
      $sql = "SELECT is_reset FROM Users WHERE email=?";
      $prepare = $this->db->prepare($sql);
      $prepare->execute([$mail]);
      $result = $prepare->fetch(PDO::FETCH_ASSOC);
      return ($result['is_reset'] == IS_RESET);
    }

    public function getLink($name)
    {
        $sql = "SELECT confirmation_link FROM Users WHERE name=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['confirmation_link']);
    }

    public function setResetLink($link, $mail)
    {
        $sql = "UPDATE Users SET change_link=?,is_reset=? WHERE email=?";
        $this->db->prepare($sql)->execute([$link, IS_NOT_RESET, $mail]);
    }

    public function deleteLink($email)
    {
        $sql = "UPDATE Users SET change_link=? WHERE email=?";
        $this->db->prepare($sql)->execute(["expired", $email]);
    }

    public function getPasswordReset($link)
    {
        $sql = "SELECT password FROM Users WHERE change_link=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$link]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['password']);
    }

    public function storePassword($passwd, $email)
    {
        $sql = "UPDATE Users SET password=? WHERE email=?";
        $this->db->prepare($sql)->execute([$passwd, $email]);
    }

    public function getResetLink($link)
    {
        $sql = "SELECT change_link FROM Users WHERE change_link=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$link]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['change_link']);
    }

    public function getUserMail($name)
    {
        $sql = "SELECT email FROM Users WHERE name=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result);
    }

    public function mailExist($mail)
    {
        $sql = "SELECT email FROM Users WHERE email=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return (isset($result['email']));
    }

    public function modifPassword($new_password, $name)
    {
        $sql = "UPDATE Users SET password=? WHERE name=?";
        $this->db->prepare($sql)->execute([$new_password, $name]);
    }

    public function modifEmail($new_mail, $id)
    {
        $sql = "UPDATE Users SET email=? WHERE id=?";
        $this->db->prepare($sql)->execute([$new_mail, $id]);
    }

    public function modifLogin($new_login, $id)
    {
        $sql = "UPDATE Users SET login=? WHERE id=?";
        $this->db->prepare($sql)->execute([$new_login, $id]);
    }
}
