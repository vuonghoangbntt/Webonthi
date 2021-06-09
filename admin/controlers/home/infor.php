<?php
    $xtp = new XTemplate("views/home/infor.html");
    $rs = $db->getOne('tbladmin',"ad_name='{$_SESSION['c1907l_admin_usr']}'");
    // print_r($rs["ad_email"][0]);
    if($rs["ad_avatar"] != "" && $rs["ad_avatar"] != "101"){
        if($rs["ad_avatar"][0] == "." && $rs["ad_avatar"][1] == "/" ){
            $xtp->assign("ava",$rs["ad_avatar"]);
        }if($rs["ad_avatar"][1] != "/" ){
            $xtp->assign("ava","./".$rs["ad_avatar"]);
        }
        $xtp->parse("INF.AVA");
    }
    else{
        $xtp->assign("ava","./../img/no_img.png");
        $xtp->parse("INF.ICO");
    }
    if(isset($_POST["Change"])){
        $file = $_FILES['txtProFile'];
        if(isset($file)){
            $file              = $_FILES['txtProFile'];
            $arFileType        =  array('png','jpg','jpeg','gif');
            $sUrl              =  "./../img/avatar";
            $maxFileSize       = 50000000;
            $data['ad_avatar'] = $f->uploadFile($file,$sUrl,$arFileType,$maxFileSize); 
            $db->update("tbladmin",$data,"ad_id={$rs['ad_id']}");
        }
    }
  
    $rs["ad_phone"] = "0".$rs["ad_phone"];
    $xtp->assign("INF",$rs);
    $xtp->parse("INF");
    $acontent = $xtp->text("INF");