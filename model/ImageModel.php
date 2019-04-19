<?php

class ImageModel{

    private $db;

    public function __construct()
    {
        require(ROOT."/database.php");
        $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function storeImg($name, $path)
    {
        $sql = "INSERT INTO Gallery (user_name, img_path) VALUES (:user_name, :img_path)";
        $this->db->prepare($sql)->execute(['user_name' => $name, 'img_path' => $path]);
    }

    public function getAllUsersImg($from, $max)
    {
        $sql = "SELECT img_path,current_t,id FROM Gallery ORDER BY current_t DESC LIMIT :src,:max";
        $prepare = $this->db->prepare($sql);
        $prepare->bindValue(':src', (int)($from - 1), PDO::PARAM_INT);
        $prepare->bindValue(':max', (int)$max, PDO::PARAM_INT);
        $prepare->execute();
        $result = $prepare->fetchAll(PDO::FETCH_OBJ);
        return ($result);
    }

    public function countAllimg($param = null)
    {
        $sql = "SELECT count(*) as 'countImg' FROM Gallery";
        $prepare = $this->db->prepare($sql);
        $prepare->execute();
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['countImg']);
    }

    public function getCommentaryNumber($imageId)
    {
        $sql = "SELECT img_id FROM Commentary WHERE img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imageId]);
        $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
        return (count($result));
    }

    public function getUserImg($name)
    {
        $sql = "SELECT img_path FROM Gallery WHERE user_name=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name]);
        $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
        return ($result);
    }

    public function deleteUserImg($name, $path)
    {
        $sql = "DELETE FROM Gallery WHERE user_name=? AND img_path=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$name, $path]);
    }
}



 ?>
