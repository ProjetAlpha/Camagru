<?php

require_once(dirname(__DIR__)."/model/CommentaryModel.php");

class CommentaryModel
{
    private $db;

    public function __construct()
    {
        require(ROOT."/database.php");
        $this->db = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getCommentary($imageId)
    {
        $sql = "SELECT comment FROM Commentary WHERE img_id=?";
        $prepare = $this->db->prepare($sql);
        $prepare->execute([$imageId]);
        $result = $prepare->fetchAll(PDO::FETCH_COLUMN);
        return ($result);
    }

    public function getUserImgName($imageId)
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

    public function storeCommentary($imageId, $email, $comment)
    {
        // faut se baser sur le user_id et pas le user_name, car si le meme nom = fucked.
        // sinon affiche : ce nom est deja prit.
        /*$sql = "CREATE TABLE IF NOT EXISTS Commentary(
        id INT(11) AUTO_INCREMENT PRIMARY KEY,
        img_id INT(11),
        user_id INT(11) NOT NULL,
        comment TEXT,
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";*/
        $data = [
            'img_id' => $imageId,
            'user_email' => $email,
            'comment' => $comment,
        ];
        $sql = "INSERT INTO Commentary (img_id, user_email, comment) VALUES (:img_id, :user_email, :comment)";
        $this->db->prepare($sql)->execute($data);
    }
}


?>
