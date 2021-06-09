<?php
include("../libs/bootstrap.php");
$xtp = new XTemplate("views/signin/regis.html");
$sql = "SELECT ad_name,ad_pwd FROM tbladmin WHERE 1=1";
$rs = $db->fetchAll($sql);
$do_save = 1;
if($_POST){
    $data["ad_name"]  = $_POST["txtUsere"];
    $data["ad_email"] = $_POST['txtEmaile'];
    $pwd              = $_POST['txtPwde'];
    $pwd1             = sha1($pwd);
    $data["ad_pwd"]   = $salt.$pwd1;
    $conf             = $_POST["txtCone"];
    $data["ad_phone"] = $_POST["nbrPhonee"];
    foreach($rs as $row){
        if($data["ad_name"]==$row['ad_name']){
            $do_save = "-1";
            $xtp->assign("mes_log","The User Name already exists");
            break;
        }
    }
    if(!$valid->isStringNum($data["ad_name"])){
        $do_save = "-1";
        $xtp->assign("mes_regi_user","Please enter the correct User Name form");
    }
    if(!$valid->isMail($data["ad_email"])){
        $do_save = "-1";
        $xtp->assign("mes_regi_email","Please enter the correct Email form");
    }
    if(($data["ad_phone"])==""){
        $do_save = "-1";
        $xtp->assign("mes_regi_phone","Please enter the correct Phone Number form");
    }
    if(!$valid->isPwd($pwd)){
        $do_save = "-1" ;
        $xtp->assign("mes_regi_pwd","Please enter the correct Password form");
    }
    if($pwd != "" && $conf !="" && $pwd != $conf){
        $do_save = "-1";
        $xtp->assign("mes_regi_pwd","Password confirmation does not match");
    }
    if($do_save == 1){
        if($db->insert('tbladmin',$data)){
            $f->redir("{$baseUrl}/admin/login.php");
            
        }
    }
}
$xtp->assign('baseUrl',$baseUrl);
$xtp->parse("RES");
$xtp->out("RES");