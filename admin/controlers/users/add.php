<?php
    $xtp = new XTemplate("views/users/add.html");
    $do_save = 1;
    $tit = "New Account User";
    if($_POST){
        $data['user_name']     = $_POST['txtUserName'];
        $data['user_email']    = $_POST['txtUserEmail'];
        $data['user_phone']    = $_POST['txtUserPhone'];
        $data['user_pwd']      = $_POST['txtUserPass'];
        $conf                  = $_POST['txtUserRePass'];
        $file                  = $_FILES['txtProFile'];
        $arFileType =  array('png','jpg','jpeg','gif');
        $sUrl       =  "./../img/avatar";
        $maxFileSize = 50000000;
        $data['user_avatar'] = $f->uploadFile($file,$sUrl,$arFileType,$maxFileSize); 
        if(!$valid->isStringNum($data['user_name'])){
            $do_save = -1;
            $xtp->assign("mess_user_email","INVALID USER NAME");
        }
        if(!$valid->isPwd($data['user_pwd'])){
            $do_save = -1;
            $xtp->assign("mess_user_pwd","INVALID PASSWORD");
        }
        if(!$valid->isMail($data['user_email'])){
            $do_save = -1;
            $xtp->assign("mess_user_email","INVALID EMAIL");
        }
        if(!$valid->isPhone($data['user_phone'])){
            $do_save = -1;
            $xtp->assign("mess_user_phone","INVALID PHONE");
        }
        if($data['user_pwd'] !="" && $conf !="" && $data['user_pwd']!= $conf){
            $do_save = -1;
            $xtp->assign("mess_user_pwd","Repeat Password is incorrect");
        }
        $xtp->assign("ADD",$_POST);
        if($do_save === 1){
            if($db->insert('tbluser',$data)){
                $f->redir("?m=users&a=list");
            }
        }
    }
    $xtp->parse("ADD");
    $acontent = $xtp->text("ADD");