<?php


class Settings extends Models
{
    public function __construct()
    {

        parent::__construct(createClassArray('model'));
    }

    public function getSettingsView()
    {
        if (isAuth())
            view('settings.php');
        else {
            redirect ('/');
        }
    }

    public function setName()
    {
        if (isset($_POST, $_POST['newname']) && isAuth()){
            Validate::validName(
                $_POST['newname'],
                'settings.php',
                 ['name' => Message::$userMessages['name']],
                 'USER_WARNING_NAME'
                );
            if ($this->user->userNameExist($_POST['newname'])){
                view(
                    "settings.php",
                    array("warning" => "Ce nom existe déjà.", "type" => "USER_WARNING_NAME")
                );
            }
            $this->settings->changeUserName($_SESSION['email'], $_POST['newname']);
            $this->settings->updateName($_SESSION['name'], $_POST['newname']);
            $_SESSION['name'] = $_POST['newname'];
            redirect ('/settings');
        }else {
            redirect ('/');
        }
    }

    public function setPassword()
    {

        if (isset($_POST, $_POST['newpwd'], $_POST['oldpwd'], $_SESSION['email']) && isAuth()){
            Validate::validPassword(
                $_POST['newpwd'],
                'settings.php',
                 ['password' => PASSWORD_WARNING],
                 'USER_WARNING_PWD'
                );
            $password = $this->user->getUserHash($_SESSION['email'], "email");
            if (password_verify($_POST['oldpwd'], $password)){
                $hash = password_hash($_POST['newpwd'], PASSWORD_BCRYPT, ['cost' => 12]);
                $this->settings->changePassword($_SESSION['email'], $hash);
                $_SESSION['name'] = "";
                $_SESSION['token'] = "";
                $_SESSION['email'] = "";
                redirect ('/login');
            }else {
                view(
                    "settings.php",
                    array("warning" =>
                    "L'ancien et le nouveau mot de passe sont différents.",
                    "type" => "USER_WARNING_PWD")
                );
            }
        }else {
            redirect ('/');
        }
    }

    public function setEmail()
    {
        if (isset($_POST, $_POST['newemail'], $_SESSION['email']) && isAuth()){
            Validate::validMail(
                $_POST['newemail'],
                'settings.php',
                 ['mail' => Message::$userMessages['mail']],
                 'USER_WARNING_EMAIL'
            );
            if ($this->user->userExist($_POST['newemail'])){
                view(
                    "settings.php",
                    array("warning" => "Ce mail existe déjà.", "type" => "USER_WARNING_EMAIL")
                );
            }
            $link = randomPassword();
            sendHtmlMail(
                $_SESSION['email'],
                "<a href=http://localhost:".$_SERVER['SERVER_PORT'].'/resetEmail/'.$link.">
                Confirmer la réinitialisation du mail </a>",
                "Réinitialisation du mail"
            );
            $_SESSION['resetEmailHash'] = password_hash($link, PASSWORD_DEFAULT);
            $_SESSION['newmail'] = $_POST['newemail'];
            view(
                "settings.php",
                array("warning" => "Un mail de confirmation a été envoyé.", "type" => "USER_WARNING_EMAIL")
            );
        }else {
            redirect ('/');
        }
    }

    public function isUserNotified()
    {
        if (isset($_SESSION) && isAuth()){
            $result = $this->settings->isNotified($_SESSION['email']);
            if ($result == true)
                echo json_encode(['is_notified' => 1]);
            else {
                echo json_encode(['is_notified' => 0]);
            }
        }
    }

    public function setUserCommentary()
    {
        if (isset($_POST))
            $data = json_decode(json_encode($_POST), true);
        if (isset($_POST, $data['notification']) && isAuth()){
            if ($data['notification'] == 'activate'){
                $this->settings->setCommentary($_SESSION['email'], true);
            }
            else if ($data['notification'] == 'disable'){
                $this->settings->setCommentary($_SESSION['email'], false);
            }else {
                redirect('/');
            }
        }else {
            redirect('/');
        }
    }

    public function confirmReset($link = null)
    {
        if (isset($link, $_SESSION['resetEmailHash'], $_SESSION['newmail'])
        && isAuth() && password_verify($link, $_SESSION['resetEmailHash'])){
            $msg = Message::$userMessages['reset_email'];
            $this->settings->changeEmail($_SESSION['email'], $_SESSION['newmail']);
            $this->settings->updateEmail($_SESSION['email'], $_SESSION['newmail']);
            $_SESSION['email'] = $_SESSION['newmail'];
            $_SESSION['newmail'] = "";
            $_SESSION['resetEmailHash'] = "";
            view(
                'login_page.php',
                array("confirmation" =>
                $msg,
                "type" => "USER_CONFIRMATION")
            );
            redirect ('/settings');
        }else {
            redirect ('/');
        }
    }
}

?>
