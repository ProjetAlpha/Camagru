<?php

require_once(dirname(__DIR__)."/model/CommentaryModel.php");

class Commentary extends CommentaryModel
{
    public function getImageComments($imageId = null)
    {
        if (isset($imageId) && !empty($imageId))
        {
            // avec le user name stp O_O.
            $result = $this->getCommentary($imageId);
            echo (json_encode($result));
        }else {
            echo (json_encode("error"));
        }
    }

    public function addComments($imageId = null)
    {
        if (isset($imageId) && isset($_POST['comment']) && isAuth() && isset($_SESSION['email']))
        {
            $data = json_decode(json_encode($_POST), true);
            $sanitize = filter_var($data['comment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $result = $this->storeCommentary($imageId, $_SESSION['email'], $sanitize);
        }
    }
}
