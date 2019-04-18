<?php

require_once(dirname(__DIR__)."/model/ImageModel.php");

class Image extends ImageModel
{
    public function profil($param = null)
    {
        if (isAuth())
            view('profil.php');
        else
            redirect('/');
    }

    public function getAllImg($pageNumber = null)
    {
        // prendre les commentaires + les likes associes avec les images.
        // triées par date de création...
        // img id="real_id" ==> avec js on recupere l'id de l'image et on ajoute les commentaires associes.
        // [1 img] = nav bottom : 1 2 3 4 5 6 ...
        if (isset($pageNumber) && !empty($pageNumber)){
            $countImg = $this->countAllimg();
            if ($pageNumber == 1)
                $images = $this->getAllUsersImg(1, 5);
            else {
                $images = $this->getAllUsersImg((($pageNumber * 5) - 5) + 1, 5);
            }
            $pagination = calc_pagination($countImg);
            if (isset($images) && isset($images[0]))
                view('all_image.php', array('images' => $images, 'pagination' => $pagination, 'current' => $pageNumber));
            else {
                view('all_image.php');
            }
        }else {
            $images = $this->getAllUsersImg(1, 5);
            $countImg = $this->countAllimg();
            $pagination = calc_pagination($countImg);
            if (isset($images) && isset($images[0]))
                view('all_image.php', array('images' => $images, 'pagination' => $pagination, 'current' => '1'));
            else {
                view('all_image.php');
            }
        }
    }

    public function getImg($param = null)
    {
        if (isset($_POST['get']) && isAuth())
        {
            $user_img = $this->getUserImg($_SESSION['name']);
            echo json_encode($user_img);
        }
    }

    public function deleteImg($param = null)
    {
        // verifier que c'est un path valide : se trouve bien dans ressources/user.
        if (isset($_POST['delete']) && isset($_POST['path']) && isAuth())
        {
            $data = json_decode(json_encode($_POST), true);
            $path = str_replace('\\', '', $data['path']);
            $this->deleteUserImg($_SESSION['name'], $path);
            $realpath = dirname(__DIR__).'/public'.$path;
            if (file_exists($realpath))
            {
                unlink($realpath);
            }
        }
    }

    public function loadImg($param = null)
    {
        if ((isset($_POST, $_POST['img']) || isset($_POST['path']) || isset($_POST['get'])) && isAuth() && isset($_SESSION['name']))
        {
            $data = json_decode(json_encode($_POST), true);
            if (isset($data['img'])){
                $base64 = $data['img'];
                Validate::check(['image' => $base64], 'profil.php', ['image' => "Ce format d'image n'est pas supportee."], "USER_WARING");
                if (!file_exists(dirname(__DIR__).'/public/ressources/images/'.$_SESSION['name']))
                {
                    mkdir(dirname(__DIR__).'/public/ressources/images/'.$_SESSION['name']);
                }
                $pos  = strpos($base64, ';');
                $type = explode('/', explode(':', substr($base64, 0, $pos))[1])[1];
                if (isset($type)){
                    $random = randomPassword();
                    $path = dirname(__DIR__).'/public/ressources/images/'.$_SESSION['name'].'/'.$random.'.'.$type;
                    $js_path = '/ressources/images/'.$_SESSION['name'].'/'.$random.'.'.$type;
                    $this->storeImg($_SESSION['name'], $js_path);
                    base64ToImage($base64, $path);
                    echo json_encode($js_path);
                }
            }
        }
    }
}
