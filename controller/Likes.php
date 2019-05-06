<?php

require_once(dirname(__DIR__)."/model/ImageModel.php");

class Likes extends ImageModel
{

    public function addLike($imgId)
    {
        if (isAuth() && isset($imgId, $_SESSION['name'], $_SESSION['email'])
        && !$this->isLikedByUser($imgId, $_SESSION['email']))
        {
            $this->setLikesCounter("increment", $imgId);
            $this->setUserLike($imgId, $_SESSION['email']);
        }
    }

    public function deleteLike($imgId)
    {
        if (isAuth() && isset($imgId, $_SESSION['name'], $_SESSION['email']))
        {
            $this->setLikesCounter("decrement", $imgId);
            $this->resetLike($imgId, $_SESSION['email']);
        }
    }
}


 ?>
