<?php

!defined('ALPHA_NUM') && define('ALPHA_NUM', '/^[\w-]+$/');
!defined('ALPHA') && define('ALPHA', '/^[a-zA-Z]*$/');
!defined('DIGITS') && define('DIGITS', '/^\d+$/');
!defined('PAGE') && define('PAGE', '/(\d)+(#[A-Za-z_-]+)?/');
!defined('ROOT') && define('ROOT', __DIR__);
!defined('IS_RESET') && define('IS_RESET', 2);
!defined('IS_NOT_RESET') && define('IS_NOT_RESET', 1);
!defined('PASSWORD_WARNING') && define('PASSWORD_WARNING',
"Le mot de passe doit contenir: <br />
- au moins 8 caractéres <br />
- une lettre en minuscule <br />
- une lettre en majuscule <br />
- un chiffre");
$userMessages = [
    'password_link_info' => "Un lien de réinitialisation du mot de passe à été envoyé sur votre boîte mail.",
    'reset_link_info' =>  "Veuillez confirmer votre inscription en cliquant sur le lien envoyé dans votre boîte mail,<br />
    afin de pouvoir modifier votre mot de passe.",
    'confirm_login_info' => "Veuillez confirmer votre inscription en cliquant sur le lien envoyé dans votre boîte mail",
    'reset_login_info' => "Veuillez confirmer le changement du mot de passe en cliquant sur le lien envoyé dans votre boîte mail.",
    'name' => "Le nom doit uniquement contenir des caractéres alphanumériques",
    'mail' => "Ce mail n'est pas valid."
];
/**
 * ---------- Regex Strong Password ----------
 * ^: anchored to beginning of string
 * \S*: any set of characters
 * (?=\S{8,}): of at least length 8
 * (?=\S*[a-z]): containing at least one lowercase letter
 * (?=\S*[A-Z]): and at least one uppercase letter
 * (?=\S*[\d]): and at least one number
 */
!defined('PASSWORD') && define('PASSWORD', '/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/');
