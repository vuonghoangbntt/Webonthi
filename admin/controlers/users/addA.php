<?php
    $xtp = new XTemplate("views/users/addA.html");
    $do_save = 1;
    $tit = "Add Account Admin";
    if($_POST){
        $data['ad_name']     = $_POST['txtAdName'];
        $data['ad_email']    = $_POST['txtAdEmail'];
        $data['ad_phone']    = $_POST['txtAdPhone'];   
        $pwd                 = $_POST['txtPwd'];
        $pwd                 = sha1($pwd);
        $data['ad_pwd']      = $salt.$pwd;
        $conf                = $_POST['txtCon'];
        $data['ad_position'] = $_POST['txtAdPo']; 
        $file                = $_FILES['txtProFile'];
        $arFileType          =  array('png','jpg','jpeg','gif');
        $sUrl                =  "./../img/avatar";
        $maxFileSize         = 50000000;
        $data['ad_avatar'] = $f->uploadFile($file,$sUrl,$arFileType,$maxFileSize); 
        if(!$valid->isStringNum($data['ad_name'])){
            $do_save = -1;
            $xtp->assign("mess_ad_email","INVALID USER NAME");
        }
        if(!$valid->isPwd($data['ad_pwd'])){
            $do_save = -1;
            $xtp->assign("mess_ad_pwd","INVALID PASSWORD");
        }
        if($data['ad_position'] == "CEO"){
            $do_save = -1;
            $xtp->assign("mess_ad_po","The position cannot be CEO");
        }
        if(!$valid->isMail($data['ad_email'])){
            $do_save = -1;
            $xtp->assign("mess_ad_email","INVALID EMAIL");
        }
        if(!$valid->isPhone($data['ad_phone'])){
            $do_save = -1;
            $xtp->assign("mess_ad_phone","INVALID PHONE");
        }
        if($pwd !="" && $conf !="" && $pwd != $conf){
            $do_save = -1;
            $xtp->assign("mess_ad_pwd","Repeat Password is incorrect");
        }
        $xtp->assign("ADDA",$data);
        if($do_save === 1){
            if($db->insert('tbladmin',$data)){
                $f->redir("?m=users&a=listA");
            }
        }
    }
    $xtp->parse("ADDA");
    $acontent = $xtp->text("ADDA");