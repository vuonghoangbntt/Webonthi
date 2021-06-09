<?php
    include("../libs/bootstrap.php");
    $xtp = new XTemplate("views/signin/login.html");
    $sql = "SELECT ad_name,ad_pwd FROM tbladmin WHERE 1=1";
    $rs = $db->fetchAll($sql);
    $_SESSION['c1907l_admin_usr']='';
    $flag = 0;
    // if()
    // $xtp->parse("LOG");
    if(isset($for)){
        $xtp->assign("for",$for);
    }else{
        $xtp->parse("LOGIN.LOG");
    }
    if($_POST){
        $usr = $_POST['txtUserName'];
        $pwd = $_POST['txtPwd'];
        $pwd2 = sha1($pwd);
        $pwd1 = $salt.$pwd2;
        if(!$valid->isStringNum($usr)){
            //$flag = "-1";
            $xtp->assign("mes_user","User Name Incorrect");
        }
        if(!$valid->isPwd($pwd)){
           // $flag = "-1" ;
            $xtp->assign("mes_pwd","Password Incorrect");
        }
        foreach($rs as $row){
           
                // if($usr==$row['ad_name'] && $pwd==$row['ad_pwd']){
                //     $_SESSION['c1907l_admin_usr'] = $usr;
                //     $flag=1;
                //     break;
                // }
           
            // if(strlen($row['ad_pwd'])>20){
                if($usr==$row['ad_name'] && $pwd1==$row['ad_pwd']){
                    $_SESSION['c1907l_admin_usr'] = $usr;
                    $flag=1;
                    break;
                
                }
                if($usr != $row['ad_name']){
                    $flag = "-1";
                    $xtp->assign("mes_user","User Name Incorrect");
                }
            // }
           
        }
        if($flag==0){
            $xtp->assign('err_login','UserName or Password invalid!');
        }
        if($flag==1){
            $f->redir("{$baseUrl}/admin/?m=home&a=read");
        }
    }
    $xtp->assign('baseUrl',$baseUrl);
    $xtp->parse("LOGIN");
    $xtp->out("LOGIN");