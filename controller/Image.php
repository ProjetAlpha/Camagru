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
        if (isset($pageNumber) && !empty($pageNumber)){
            $countImg = $this->countAllimg();
            if ($pageNumber == 1)
                $images = $this->getAllUsersImg(1, 5);
            else {
                $images = $this->getAllUsersImg((($pageNumber * 5) - 5) + 1, 5);
            }
            $pagination = calc_pagination($countImg);
            // ---- get likes counter / images.
            if (isset($images) && isset($images[0]))
                view('all_image.php', array('images' => $images, 'pagination' => $pagination, 'current' => $pageNumber, 'util' => $this));
            else {
                view('all_image.php');
            }
        }else {
            $images = $this->getAllUsersImg(1, 5);
            $countImg = $this->countAllimg();
            $pagination = calc_pagination($countImg);
            if (isset($images) && isset($images[0]))
            view('all_image.php', array('images' => $images, 'pagination' => $pagination, 'current' => '1', 'util' => $this));
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
        }else {
            redirect ('/');
        }
    }

    public function deleteImg($param = null)
    {
        if (isset($_POST['delete']) && isset($_POST['path']) && isAuth())
        {
            $data = json_decode(json_encode($_POST), true);
            $path = str_replace('\\', '', $data['path']);
            $splitPath = explode('/', $path);
            if ($splitPath[1] == "ressources" && $splitPath[2] == "images" && $splitPath[3] == $_SESSION['name'])
            {

                $this->deleteUserImg($_SESSION['name'], $path);
                $realpath = dirname(__DIR__).'/public'.$path;
                if (file_exists($realpath))
                {
                    unlink($realpath);
                }
            }
        }else {
            redirect ('/');
        }
    }

    public function loadImg($param = null)
    {
        if ((isset($_POST, $_POST['img']) || isset($_POST['path']) || isset($_POST['get'])) && isAuth() && isset($_SESSION['name']))
        {
            $data = json_decode(json_encode($_POST), true);
            if (isset($data['img']) && isset($data['item'], $data['posX'], $data['posY'], $data['width'], $data['height'])){
                $base64 = $data['img'];
                $item64 = $data['item'];

                Validate::check(['image' => $base64], 'profil.php', ['image' => "Ce format d'image n'est pas supportee."], "USER_WARING");
                Validate::check(['image' => $item64], 'profil.php', ['image' => "Ce format d'image n'est pas supportee."], "USER_WARING");

                if (!file_exists(dirname(__DIR__).'/public/ressources/images/'.$_SESSION['name']))
                    mkdir(dirname(__DIR__).'/public/ressources/images/'.$_SESSION['name']);
                $pos  = strpos($base64, ';');
                //if ()
                $type = explode('/', explode(':', substr($base64, 0, $pos))[1])[1];
                if (isset($type)){
                    $random = randomPassword();
                    $path = dirname(__DIR__).'/public/ressources/images/'.$_SESSION['name'].'/'.$random.'.png';
                    $js_path = '/ressources/images/'.$_SESSION['name'].'/'.$random.'.png';
                    $this->storeImg($_SESSION['name'], $js_path);
                    $dst = imagecreatefromstring(extract_base64(trim($base64)));
                    $src = imagecreatefromstring(extract_base64(trim($item64)));
                    imagecopymerge_alpha($dst,
                    $src, $data['posX'], $data['posY'], 0, 0, $data['width'], $data['height'], 100);
                    imagepng($dst, $path);
                    echo json_encode($js_path);
                }
            }
        }else {
            redirect ('/');
        }
    }
}
