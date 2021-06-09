<?php
    include("../libs/bootstrap.php");
    $_SESSION['c1907l_admin_usr']='';
    session_destroy();
    $f->redir("{$baseUrl}/admin/login.php");