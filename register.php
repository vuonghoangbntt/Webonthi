<?php
include("libs/bootstrap.php");
$xtp = new XTemplate("views/register.html");
$sql = "SELECT * FROM tbluser WHERE 1=1";
$rs = $db->fetchAll($sql);
$do_save = 1;
if($_POST){
    $salt = sha1("a@ajfk");
    $data["user_name"]  = $_POST["txtUsere"];
    $data["user_email"] = $_POST['txtEmaile'];
    $pwd              = $_POST['txtPwde'];
    $pwd1             = sha1($_POST['txtPwde']);
    $data["user_pwd"]   = $pwd1.$salt;
    $conf             = $_POST["txtCone"];
    $data["user_phone"] = $_POST["nbrPhonee"];
    $data["account_type"] = 0;
    foreach($rs as $row){
        if($data["user_name"]==$row['user_name']){
            $do_save = "-1";
            $xtp->assign("mes_log","The User Name already exists");
            break;
        }
        if($data["user_email"]==$row['user_email']){
            $do_save = "-1";
            $xtp->assign("mes_log1","The Email already exists");
            break;
        }
    }
    if(!$valid->isStringNum($data["user_name"])){
        $do_save = "-1";
        $xtp->assign("mes_regi_user","Please enter the correct User Name form");
    }
    if(!$valid->isMail($data["user_email"])){
        $do_save = "-1";
        $xtp->assign("mes_regi_email","Please enter the correct Email form");
    }
    if(($data["user_phone"])==""){
        $do_save = "-1";
        $xtp->assign("mes_regi_phone","Please enter the correct Phone Number form");
    }
    if(!$valid->isPassword($pwd)){
        $do_save = "-1" ;
        $xtp->assign("mes_regi_pwd","Please enter the correct Password form");
    }
    if($pwd != "" && $conf !="" && $pwd != $conf){
        $do_save = "-1";
        $xtp->assign("mes_regi_pwd","Password confirmation does not match");
    }
    $xtp->assign("RES",$_POST);
    if($do_save == 1){
        if($db->insert('tbluser',$data)){
            $f->redir("{$baseUrl}/?a=index0");
            
        }
    }
}
$xtp->assign('baseUrl',$baseUrl);
$xtp->parse("RES");
$xtp->out("RES");