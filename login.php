<?php
    include("libs/bootstrap.php");  
    $salt = sha1("a@ajfk");
    $xtp = new XTemplate("views/login.html");
    $sql = "SELECT * FROM tbluser WHERE 1=1";
    $rs  = $db->fetchAll($sql);
    $_SESSION["login_user"] = "";
    $_SESSION["user_type"] = "";
    if($_POST){
        $user = $_POST['txtUserName'];
        $pwd  = $_POST['txtPwd'];
        $pwd1  = sha1($pwd);
        $pwd1  =  $pwd1.$salt; 
        $xtp->assign("user",$user);
        foreach($rs as $row){
            if($user==$row["user_name"] && $pwd1==$row[ "user_pwd"]){
                $_SESSION["login_user"] = $user;
                $_SESSION["login_user_id"] = $row['user_id'];
                $_SESSION["user_type"] = $row['account_type'];
                if(strlen($row['user_avatar'])>3){
                    $_SESSION["avatar"] = substr($row['user_avatar'],3);
                }
                break;
            }
        }
        if($_SESSION["login_user"] != ""){
            $f->redir("{$baseUrl}/?a=index0");
              
        }else{
            $xtp->assign("mess_error","UserName or Password is incorrect!!");
        }
    }
    $xtp->parse("LOGIN");
    $xtp->out("LOGIN");