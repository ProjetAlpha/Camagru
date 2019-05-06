<?php

require_once(dirname(__DIR__)."/model/UserModel.php");

class Users extends UserModel
{
    public function __construct()
    {

        parent::__construct();
    }

    public function create($param = null)
    {
        if (isset($_POST['email']) && $this->userExist($_POST['email'], $_POST['name'])) {
            view(
                "register.php",
                array("warning" => "Ce mail existe déjà.", "type" => "USER_WARNING")
            );
        }
        $messages = [
            'name' => Message::$userMessages['name'],
            'password' => PASSWORD_WARNING,
            'mail' => Message::$userMessages['mail']
        ];
        if (isset($_POST, $_POST['name'], $_POST['password'], $_POST['name']))
        {
            Validate::check([
                'name' => $_POST['name'],
                'password' => $_POST['password'],
                'mail' => $_POST['email']
                ], "register.php", $messages, "USER_WARNING");
        }
        if (isset($_POST) && keysExist(['name', 'password', 'email'], $_POST)) {
            $hash = password_hash($_POST['password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $_SESSION['token'] = $hash;
            $_SESSION['name'] = $_POST['name'];
            $_SESSION['email'] = $_POST['email'];
            $link = randomPassword();
            $this->createUser($_POST['name'], $hash, $_POST['email'], $link);
            sendHtmlMail($_POST['email'], "<a href=http://localhost:".$_SERVER['SERVER_PORT'].'/confirm/'.$link."> Confirmer votre compte</a>", "Mail de confirmation");
            require_once(dirname(__DIR__)."/views/login_page.php");
        } else {
            require_once(dirname(__DIR__)."/views/register.php");
        }
    }

    public function resetView($param = null)
    {
        view('reset_password.php', ['reset' => 'mailing', 'type' => "USER_CONFIRMATION"]);
    }

    public function reset($param = null)
    {
        if (isset($_POST['email'], $_POST['name']) && $this->userExist($_POST['email'], $_POST['name'])){
            if (!$this->is_confirmed($_POST['email'], "email")) {
                $msg = Message::$userMessages['reset_link_info'];
                view(
                    'login_page.php',
                    array("confirmation" =>
                    $msg,
                    "type" => "USER_CONFIRMATION")
                );
            }
            $_SESSION['email'] = $_POST['email'];
            $link = randomPassword();
            $this->setResetLink($link, $_POST['email']);
            sendHtmlMail(
                $_POST['email'],
                "<a href=http://localhost:".$_SERVER['SERVER_PORT'].'/reset/'.$link.">
                Confirmer la réinitialisation du mot de passe </a>",
                "Réinitialisation du mot de passe"
            );
            $msg = Message::$userMessages['password_link_info'];
            view(
                'login_page.php',
                array("confirmation" =>
                $msg,
                "type" => "USER_CONFIRMATION")
            );
        }
        if (isset($_POST['new_password']) && isset($_SESSION['email'])
        && $this->isValidReset($_SESSION['email']) && !$this->is_auth())
        {
            Validate::check([
                'password' => $_POST['new_password'],
            ], 'reset_password.php', ['password' => PASSWORD_WARNING], "USER_WARNING");
            $hash = password_hash($_POST['new_password'], PASSWORD_BCRYPT, ['cost' => 12]);
            $_SESSION['token'] = $hash;
            $this->storePassword($hash, $_SESSION['email']);
            $this->deleteLink($_SESSION['email']);
            redirect('/');
        } else {
            view('reset_password.php', ['reset' => 'mailing', 'type' => "USER_CONFIRMATION"]);
        }
    }

    public function doConfirm($param = null)
    {
        if (isset($_POST['confirmation_link']) && isset($_SESSION['name'])) {
            if ($this->is_confirmed($_SESSION['name'], "name")) {
                view('all_image.php');
            }
            if ($this->is_auth() && $this->getLink($_SESSION['name']) == $_POST['confirmation_link']) {
                $this->setConfirmation($_SESSION['name']);
            }
        } else {
            view('all_image.php');
        }
    }

    public function confirm($param)
    {
        if ($this->is_auth() && $this->getLink($_SESSION['name']) == $param) {
            $this->setConfirmation($_SESSION['name'], $param);
            view('confirmation.php', array("type" => "confirmed"));
        } else {
            redirect('/');
        }
    }

    public function is_auth($param = null)
    {
        if (keysExist(['name', 'token'], $_SESSION)) {
            $password = $this->getUserHash($_SESSION['name'], "name");
            if (isset($password) && !empty($password) && hash_equals($password, $_SESSION['token'])) {
                return (1);
            }
        }
        return (0);
    }

    public function login($param = null)
    {

        if (isset($_POST) && keysExist(['email', 'password'], $_POST)) {
            if (!$this->userExist($_POST['email'])){
                view(
                    'login_page.php'
                );
            }
            if (!$this->is_confirmed($_POST['email'], "email")) {
                $msg = Message::$userMessages['confirm_login_info'];
                view(
                    'login_page.php',
                    array("confirmation" =>
                    $msg,
                    "type" => "USER_CONFIRMATION")
                );
            }
            if (!$this->is_reset($_POST['email'], "email") && !$this->is_confirmed($_POST['email'], "email")) {
                $msg = Message::$userMessages['confirm_login_info'];
                view(
                    'login_page.php',
                    array("confirmation" =>
                        $msg,
                        "type" => "USER_CONFIRMATION")
                    );
            }
        }
        if (isset($_POST) && keysExist(['email', 'password'], $_POST) && !$this->is_auth()) {
            $request = $_POST;
            $password = $this->getUserHash($_POST['email'], "email");
            if (isset($password) && !empty($password) && password_verify($_POST['password'], $password)) {
                $_SESSION['token'] = $password;
                $_SESSION['name'] = $this->getName($_POST['email']);
                $_SESSION['email'] = $_POST['email'];
                redirect('/');
            } else {
                view("login_page.php", array("credential" => "Mot de passe ou login incorrecte.",
                "type" => "USER_CREDENTIAL"));
            }
        } else {
            view("login_page.php");
        }
    }

    public function resetLink($link = null)
    {
        if (isset($link) && $this->getResetLink($link) == $link) {
            $this->setResetConfirmation($link);
            view(
                'reset_password.php',
                array("reset" =>
                "confirmed",
                "type" => "USER_CONFIRMATION")
            );
        } else {
            redirect('/');
        }
    }

    public function logout($param = null)
    {
        if (isset($_SESSION) && keysExist(['name', 'token'], $_SESSION) && isAuth()) {
            $_SESSION['name'] = "";
            $_SESSION['token'] = "";
            $_SESSION['email'] = "";
            redirect('/');
        }else {
            redirect('/');
        }
    }
}
