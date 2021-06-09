<?php
    session_start();
    include("XTemplate.class.php");
    include("Model.class.php");
    include("Func.class.php");
    include("Validate.class.php");
    $db    = new Model('cnpm','root','');
    $f     = new Func; 
    $valid = new Validate;
    $salt  = sha1("ahh23");
    $baseUrl = "http://".$_SERVER['HTTP_HOST'].'/CNPM';