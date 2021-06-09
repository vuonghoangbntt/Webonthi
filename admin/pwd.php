<?php
    include("../libs/bootstrap.php");
    $xtp = new Xtemplate("views/forgot/pwd.html");
    $do_save = 1;
    
    $id = $_GET["id"];
    if(isset($id)){
        $id = $_GET["id"];
        $rs = $db->getOne("tbladmin","id={$id}");
        if($_POST){
            $pwd = $_POST["txtPwd"];
            $con = $_POST["txtCon"];
           if($pwd === ""){
               $do_save = "-1";
               $xtp->assign("mes_pwd","New Password not null");
           }
           if($con === ""){
                $do_save = "-1";
                $xtp->assign("mes_con","Confirm Password not null");
            }
            if($pwd != $con){
                $do_save = "-1";
                $xtp->assign("mes_con","Confirm Password incorrect");
            }
            if($do_save== 1){
                $data["ad_pwd"] = $salt.$pwd;
                if($db->update("tbladmin",$data,"id={$id}")){
                    $f->redir("login.php");
                } 
            }
        }
    }
    $xtp->parse("PW");
    $xtp->out("PW");