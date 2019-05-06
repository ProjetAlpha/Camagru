<?php

require_once(__DIR__.'/config/database.php');

if (!function_exists('randomPassword')) {
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $token = "";
        $max = strlen($alphabet) - 1;
        for ($i = 0; $i < 32; $i++) {
            $token .= $alphabet[random_int(0, $max)];
        }
        return $token;
    }
}

if (!function_exists('filterData')) {
    function filterData($data, $type)
    {
        if ($type == "mail") {
            return (filter_var($data, FILTER_VALIDATE_EMAIL));
        }
        if ($type == "name" || $type == "password") {
            return (filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        }
    }
}
// 100.
// Lien vers la ressource cible de l'image, Lien vers la ressource source de l'image, coordonnée du point de destination, coordonnée du point de destination
if (!function_exists('imagecopymerge_alpha'))
{
    function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
        // creating a cut resource
        $cut = imagecreatetruecolor($src_w, $src_h);

        // copying relevant section from background to the cut resource
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);

        // copying relevant section from watermark to the cut resource
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);

        // insert cut resource to destination image
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }
}

if (!function_exists('keysExist')) {
    function keysExist($required, $data)
    {
        return (count(array_intersect_key(array_flip($required), $data)) === count($required));
    }
}


if (!function_exists('sendHtmlMail')) {
    function sendHtmlMail($to, $content, $subject)
    {
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        $message = "
        <html>
        <head>
        <title>Mail confirmation</title>
        </head>
        <body>";
        $message.= $content;
        $message.= "</body></html>";
        mail($to, $subject, $message, implode("\r\n", $headers));
    }
}

if (!function_exists('startSession')) {
    function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}

if (!function_exists('redirect')) {
    function redirect($url)
    {
        header("location: " . $url);
    }
}

if (!function_exists('isValidRegex')) {
    function isValidRegex($pattern, $string)
    {
        return (preg_match($pattern, $string));
    }
}

if (!function_exists('view')) {
    function view($path, $data = null)
    {
        if ($data !== null) {
            extract($data, EXTR_SKIP);
        }
        require_once(__DIR__.'/views/'.$path);
        die();
    }
}

if (!function_exists('isAuth')) {
    function isAuth()
    {
        if (keysExist(['name', 'token'], $_SESSION)) {
            $db = new PDO('mysql:dbname=Camagru;host=mysql;port=3306', 'root', 'rootpass');
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT password FROM Users WHERE name=?";
            $prepare = $db->prepare($sql);
            $prepare->execute([$_SESSION['name']]);
            $result = $prepare->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT is_confirmed FROM Users WHERE name=?";
            $prepare = $db->prepare($sql);
            $prepare->execute([$_SESSION['name']]);
            $confirmed = $prepare->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT is_reset FROM Users WHERE name=?";
            $prepare = $db->prepare($sql);
            $prepare->execute([$_SESSION['name']]);
            $reset = $prepare->fetch(PDO::FETCH_ASSOC);
            if (isset($result, $result['password']) && hash_equals($result['password'], $_SESSION['token'])
            && isset($confirmed['is_confirmed'], $reset['is_reset']) && !empty($confirmed['is_confirmed'])
            && ($confirmed['is_confirmed'] == 1 || ($reset['is_reset'] == IS_RESET && $confirmed['is_confirmed'] == 1))) {
                return (1);
            }
        }
        return (0);
    }
}

if (!function_exists('checkBase64Format')){
    function checkBase64Format($value) {
        $explode = explode(',', $image);
        $allow = ['png', 'jpg', 'jpeg'];
        $format = str_replace(
            [
                'data:image/',
                ';',
                'base64',
            ],
            [
                '', '', '',
            ],
            $explode[0]
        );
        // check file format
        if (!in_array($format, $allow)) {
            return false;
        }
        // check base64 format
        if (!preg_match('%^[a-zA-Z0-9/+]*={0,2}$%', $explode[1])) {
            return false;
        }
        return true;
    }
}

if (!function_exists('isXmlHttpRequest')){
    function isXmlHttpRequest()
    {
        return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest');
    }
}

if (!function_exists('base64ToImage'))
{
    function base64ToImage($base64_string, $path) {
        $ifp = fopen($path, 'wb');
        $data = explode(',', $base64_string);
        $str = str_replace(' ', '+', trim($data[1]));
        fwrite($ifp, base64_decode($str));
        fclose($ifp);
        chmod($path, 0777);
        return $path;
    }
}

if (!function_exists('calc_pagination'))
{
    function calc_pagination($count){
        $pagination = 0;
        if ($count > 0)
        {
            $pagination = (int)($count / 5);
            $count % 5 !== 0 ? $pagination++ : 0;
        }
        return ($pagination);
    }
}

if (!function_exists('createClassArray'))
{
    function createClassArray($path)
    {
        $arrayClass = [];
        foreach (new DirectoryIterator(__DIR__.'/'.$path) as $file) {
            if ($file->isFile()) {
                $fullName = $file->getFilename();
                $name = strtolower(str_replace(['.php', ucfirst($path)], '', $fullName));
                $className = str_replace('.php', '', $fullName);
                if (!array_key_exists($name, $arrayClass)){
                    require_once($file->getRealPath());
                    $arrayClass[$name] = new $className();
                }
            }
        }
        return ($arrayClass);
    }
}
if (!function_exists('extract_base64') ){
    function extract_base64($base64)
    {
        $data = explode(',', $base64);
        $str = str_replace(' ', '+', trim($data[1]));
        return (base64_decode($str));
    }
}
