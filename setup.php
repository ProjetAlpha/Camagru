<?php

include_once("database.php");
include_once("ManageSetup.php");


if ($argv[1] == "create" && $argc == 2) {
    $info['host'] = $DB_DSN;
    $info['username'] = $DB_USER;
    $info['password'] = $DB_PASSWORD;
    $info['db_name'] = "Camagru";
    $setup = new Setup($argv, $argc, $info, ['user', 'gallery', 'commentary'], SETUP::CREATE);
}

if ($argv[1] == "reset" && $argc == 2) {
    $info['host'] = $DB_DSN;
    $info['username'] = $DB_USER;
    $info['password'] = $DB_PASSWORD;
    $info['db_name'] = "Camagru";
    $setup = new Setup($argv, $argc, $info, ['user', 'gallery', 'commentary'], SETUP::RESET);
}

if ($argv[1] == "modif" && $argc == 2) {
    $info['host'] = $DB_DSN;
    $info['username'] = $DB_USER;
    $info['password'] = $DB_PASSWORD;
    $info['db_name'] = "Camagru";
    $setup = new Setup($argv, $argc, $info, ['user', 'gallery', 'commentary'], SETUP::MODIF);
}
