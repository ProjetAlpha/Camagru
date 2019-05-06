<?php

class ImageModel{

    private $db;

    public function __construct()
    {
        require(ROOT."/config/database.php");
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

    public function setLikesCounter($type, $imgId)
    {
        if ($type == "increment")
            $sql = "UPDATE Gallery SET likes=likes + 1 WHERE id=?";
        if ($type == "decrement")
            $sql = "UPDATE Gallery SET likes=likes - 1 WHERE id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imgId]);
    }

    public function getLikesNumber($imageId)
    {
        $sql = "SELECT id,likes FROM Gallery WHERE id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imageId]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return (isset($result['likes']) && $result['likes'] > 0 ? $result['likes'] : 0);
    }

    public function setUserLike($imageId, $email)
    {
        $sql = "INSERT INTO Likes (img_id, user_email) VALUES(:img_id, :user_email)";
        $this->db->prepare($sql)->execute(['img_id' => $imageId, 'user_email' => $email]);
    }

    public function isLikedByUser($imageId, $email)
    {
        $sql = "SELECT img_id,user_email FROM Likes WHERE user_email=? AND img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$email, $imageId]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ((isset($result['user_email']) && $result['user_email'] == $email) ? 1 : 0);
    }

    public function resetLike($imageId, $email)
    {
        $sql = "DELETE FROM Likes WHERE user_email=? AND img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$email, $imageId]);
    }
}

?>
