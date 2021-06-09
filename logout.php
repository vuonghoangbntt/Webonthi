<?php
    include("libs/bootstrap.php");
    $_SESSION['login_user']='';
    $_SESSION['user_type']='0';
    session_destroy();
    $f->redir("{$baseUrl}/?a=index0");