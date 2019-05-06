<?php

require_once(dirname(__DIR__)."/model/CommentaryModel.php");

class CommentaryModel
{
    private $db;

    public function __construct()
    {
        require(ROOT."/config/database.php");
        $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getCommentary($imageId)
    {
        $sql = "SELECT user_name,comment FROM Commentary WHERE img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imageId]);
        $result = $prepare->fetchAll(PDO::FETCH_ASSOC);
        return ($result);
    }

    public function getUserImgMail($imageId)
    {
        $sql = "SELECT user_email FROM Commentary WHERE img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imageId]);
        $result = $prepare->fetch(PDO::FETCH_ASSOC);
        return ($result['user_email']);
    }

    public function getCommentaryNumber($imageId)
    {
        $sql = "SELECT img_id FROM Commentary WHERE img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imageId]);
        $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
        return (count($result));
    }

    public function storeCommentary($imageId, $email, $comment, $username)
    {
        $data = [
            'img_id' => $imageId,
            'user_email' => $email,
            'comment' => $comment,
            'user_name' => $username
        ];
        $sql = "INSERT INTO Commentary (img_id, user_email, user_name, comment) VALUES (:img_id, :user_email, :user_name, :comment)";
        $this->db->prepare($sql)->execute($data);
    }
}


?>
