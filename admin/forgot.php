<?php
    include("../libs/bootstrap.php");
    $xtp = new Xtemplate("views/forgot/forgot.html");
    $do_save = 1;
    $id = "";
    $sql = "SELECT ad_id,ad_email,ad_phone FROM tbladmin WHERE 1=1";
    $rs = $db->fetchAll($sql);
    if($_POST){
        $sr = $_POST["txtSearch"];
        foreach($rs as $row){
            if(strlen($sr)==10){
                if($row['ad_phone']==$sr){
                    $id = $row["ad_id"];
                    $do_save = 1;
                    break;
                }
            }
            if(strlen($sr)>10){
                if($row['ad_email']==$sr){
                    $id = $row["ad_id"];
                    $do_save = 1;
                    break;
                }
            }
            if($sr != $row['ad_email'] && $sr !=$row['ad_phone']){
                $do_save = "-1";
                $xtp->assign("mes_user","Your Email/Your Phone Incorrect");
            }   
        }
        // print_r ($id);die;
        if($do_save== 1){
            $f->redir("pwd.php?id={$id}");
        }
    }
    $xtp->parse("FOR");
    $xtp->out("FOR");