<?php
    $xtp = new XTemplate("views/users/edit.html");
    $do_save = 1;
    $id= $_GET['id'];
    $tit = "Edit Account User";
    if(isset($id)){
        $id = $_GET['id'];
        $rs = $db->getOne('tbluser',"user_id={$id}");
        // print_r ($rs);die;
        $xtp->assign("EDIT",$rs);
    }
    if($_POST){
        $data['user_name']     = $_POST['txtUserName'];
        $data['user_email']    = $_POST['txtUserEmail'];
        $data['user_phone']    = $_POST['txtUserPhone'];
        $pwd                   = $_POST['txtUserPass'];
        $pwd1                  = sha1($pwd);
        $data['user_pwd']      = $salt.$pwd1;
        $conf                  = $_POST['txtUserRePass'];
        $file                  = $_FILES['txtProFile'];
        if($file != ""){
            $arFileType =  array('png','jpg','jpeg','gif');
            $sUrl       =  "./../img/avatar";
            $maxFileSize = 50000000;
            $data['user_avatar'] = $f->uploadFile($file,$sUrl,$arFileType,$maxFileSize); 
        }
        if(!$valid->isStringNum($data['user_name'])){
            $do_save = -1;
            $xtp->assign("mess_user_email","INVALID USER NAME");
        }
        if(!$valid->isPwd($pwd)){
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
        if($pwd !="" && $conf !="" && $pwd != $conf){
            $do_save = -1;
            $xtp->assign("mess_user_pwd","Repeat Password is incorrect");
        }
        $xtp->assign("EDIT",$data);
        if($do_save === 1){
            if($db->update('tbluser',$data,"user_id={$id}")){
                $f->redir("?m=users&a=list");
            }
        }
    }
    $xtp->parse("EDIT");
    $acontent = $xtp->text("EDIT");