<?php

require_once(dirname(__DIR__).'/config.php');
require_once(dirname(__DIR__).'/database.php');
require_once(dirname(__DIR__)."/Session.php");
require_once(dirname(__DIR__)."/Utils.php");
require_once(dirname(__DIR__)."/ManageSetup.php");
//require_once(dirname(__DIR__).'/views/header.php');
require_once(dirname(__DIR__)."/controller/Validate.php");
require_once(dirname(__DIR__)."/controller/Message.php");
require_once(dirname(__DIR__)."/RegisterModel.php");
//


startSession();
?>


<?php
    require_once(dirname(__DIR__).'/Router.php');
?>
