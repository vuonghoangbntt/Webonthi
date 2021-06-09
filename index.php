<?php
    include("libs/bootstrap.php");
    $axtp = new XTemplate("views/index.html");
    // if( $_SESSION['login_user'] == ""){
    //     $f->redir("{$baseUrl}/controlers/index.php");
    // }else{
        //$m = $_GET['m'];//Get Module
        $salt = sha1("a@ajfk");
        $a = $_GET['a'];//Get action
        if($a!='index0'&&(!isset($_SESSION['login_user'])||$_SESSION['login_user']=='')){
            $f->redir('login.php');
        }
        if(file_exists("controlers/{$a}.php")){
            include("controlers/{$a}.php");
            // }
            if(!isset($_SESSION['login_user'])||$_SESSION['login_user']==''){
                $xtp = new XTemplate("views/log/login.html");
                $xtp->parse("LOGIN");
                $log = $xtp->text("LOGIN");
            }else{
                $xtp = new XTemplate("views/log/logout.html");
                $xtp->assign("user_name",$_SESSION['login_user']);
                $xtp->parse("LOGOUT");
                $log = $xtp->text("LOGOUT");
            }
            if(isset($_SESSION['user_type'])&&$_SESSION['user_type']=='1'){
                $axtp->assign("teacher",'visible');
            }else{
                $axtp->assign("teacher",'hidden');
            }
            if(!isset($_SESSION['avatar'])){
                $_SESSION['avatar'] = 'img_avatar2.png';
            }
            $axtp->assign('Log',$log);
            $axtp->assign('acontent',$acontent);
            $axtp->assign('baseUrl',$baseUrl);
            $axtp->parse("LAYOUT");
            $axtp->out("LAYOUT");
        }else{
            echo "404 Not Found";
        }