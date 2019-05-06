<?php

class SettingsModel
{
    private $db;

    public function __construct()
    {
        require(ROOT."/config/database.php");
        $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function changePassword($email, $newpwd)
    {
        $sql = "UPDATE Users SET password=? WHERE email = ?";
        $this->db->prepare($sql)->execute([$newpwd, $email]);
    }

    public function changeUserName($email, $newname)
    {
        $sql = "UPDATE Users SET name=? WHERE email = ?";
        $this->db->prepare($sql)->execute([$newname, $email]);
    }

    public function changeEmail($email, $newmail)
    {
        $sql = "UPDATE Users SET email=? WHERE email = ?";
        $this->db->prepare($sql)->execute([$newmail, $email]);
    }

    public function setCommentary($email, $bool)
    {
        $sql = "UPDATE Users SET is_notified=? WHERE email = ?";
        if ($bool == true)
            $this->db->prepare($sql)->execute(['1', $email]);
        else if ($bool == false)
            $this->db->prepare($sql)->execute(['0', $email]);
    }

    public function isNotified($email)
    {
        $sql = "SELECT is_notified,email FROM Users WHERE email=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$email]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        if (isset($result['is_notified']) && $result['is_notified'] == 1)
            return (true);
        else {
            return (false);
        }
    }
}

?>
