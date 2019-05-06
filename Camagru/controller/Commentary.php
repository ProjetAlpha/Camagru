<?php

class Commentary extends Models
{

    public function __construct()
    {
        parent::__construct(createClassArray('model'));
    }

    public function getImageComments($imageId = null)
    {
        if (isset($imageId) && !empty($imageId))
        {
            $result = $this->commentary->getCommentary($imageId);
            echo (json_encode($result));
        }
    }

    public function addComments($imageId = null)
    {
        if (isset($imageId) && isset($_POST['comment']) && isAuth() && isset($_SESSION['email'], $_POST['user']))
        {
            $data = json_decode(json_encode($_POST), true);
            $sanitize = filter_var($data['comment'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $result = $this->commentary->storeCommentary($imageId, $_SESSION['email'], $sanitize, $_POST['user']);
            $isNotified = $this->settings->isNotified($_SESSION['email']);
            if ($this->commentary->getUserImgMail($imageId) == $_SESSION['email'] && $isNotified == true)
            {
                if (isset($_POST['page']))
                {
                    sendHtmlMail(
                        $_SESSION['email'], "<a href=http://localhost:".$_SERVER['SERVER_PORT']."/page/".$_POST['page']."#".$imageId.">
                        Un nouveau commentaire a était ajoute à votre image </a>", "Notification : nouveau commentaire.");
                }
            }
        }
    }
}
