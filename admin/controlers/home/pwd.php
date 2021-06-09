<?php
    $xtp = new XTemplate("views/home/pwd.html");
    $rs = $db->getOne('tbladmin',"ad_name='{$_SESSION['c1907l_admin_usr']}'");
    $do_save = 1;
    $tit = "Change Password";
    if($_POST){
        $cpwd             = $_POST["txtCPwd"];
        $cpwd             = sha1($cpwd);
        $cpwd1            = $salt.$cpwd;
        $npw              = $_POST["txtNPwd"];
        $npw1             = sha1($npw);
        $data["ad_pwd"]   = $salt.$npw1;
        $con              = $_POST["txtCon"];
        if($cpwd1 != $rs["ad_pwd"]){
            $do_save = "-1";
            $xtp->assign("er_cp","Current password incorrect");
        }
        if($valid->isPwd($npw)){
            $do_save = "-1";
            $xtp->assign("er_np","Password form incorrect");
        }
        if($npw != $con){
            $do_save = "-1";
            $xtp->assign("er_co","Confirm Password incorrect");
        }
        if($do_save === 1){
            if($db->update('tbladmin',"ad_id={$rs['ad_id']}")){
                $f->redir("?m=home&a=read");
            }
        }
    }
    $xtp->parse("PWD");
    $acontent = $xtp->text("PWD");