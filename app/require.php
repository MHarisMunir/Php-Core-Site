<?php
    //Require libraries from folder libraries
    require_once 'libraries/Core.php';
    require_once 'libraries/Controller.php';
    require_once 'libraries/Database.php';
    require_once 'libraries/jwt_utils.php';

    require_once 'helpers/session_helper.php';

    require_once 'config/config.php';

    require_once 'models/PhpMailer/Exception.php';
    require_once 'models/PhpMailer/PHPMailer.php';
    require_once 'models/PhpMailer/SMTP.php';

    //Instantiate core class
    $init = new Core();
