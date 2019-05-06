<?php

require_once("Route.php");

$route = new Route();

$route->add('/', 'get', 'Image@getAllImg');
$route->add('/page/:digits', 'get', 'Image@getAllImg');

$route->add('/register', 'get', 'Users@create');
$route->add('/login/register', 'post', 'Users@create');
$route->add('/login', 'link', 'Users@login');
$route->add('/logout', 'get', 'Users@logout');

$route->add('/reset', 'get', 'Users@resetView');
$route->add('/reset/send', 'post', 'Users@reset');

$route->add('/confirm/:alphanum', 'get', 'Users@confirm');
$route->add('/reset/:alphanum', 'get', 'Users@resetLink');

$route->add('/profil', 'get', 'Image@profil');
$route->add('/profil/img', 'post', 'Image@loadImg');
$route->add('/profil/img/display', 'post', 'Image@getImg');
$route->add('/profil/img/delete', 'post', 'Image@deleteImg');

$route->add('/comments/:digits', 'post', 'Commentary@getImageComments');
$route->add('/comments/add/:digits', 'post', 'Commentary@addComments');

$route->add('/likes/add/:digits', 'post', 'Likes@addLike');
$route->add('/likes/delete/:digits', 'post', 'Likes@deleteLike');

$route->add('/settings', 'post', 'Settings@getSettingsView');
$route->add('/settings/modifName', 'post', 'Settings@setName');
$route->add('/settings/modifEmail', 'post', 'Settings@setEmail');
$route->add('/settings/modifPwd', 'post', 'Settings@setPassword');
$route->add('/settings/modifNotif', 'post', 'Settings@setUserCommentary');
$route->add('/settings/isNotified', 'post', 'Settings@isUserNotified');

$route->loadRoutes();
