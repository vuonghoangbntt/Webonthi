<?php
    function sanitize_my_email($field) {
        $field = filter_var($field, FILTER_SANITIZE_EMAIL);
        if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }
    $xtp = new Xtemplate("views/feedback/answer.html");
    $id = $_GET["id"];
    $do_send = 1;
    if(isset($id)){
        $id = $_GET["id"];
        $rs = $db->getOne("tblfeedback","fb_id={$id}");
        $rs["fb_date"] = date("d/m/Y",strtotime($rs["fb_date"]));
        $xtp->assign("ANS",$rs);
        $to_email = $rs["fb_user_email"];
        $rsa = $db->getOne("tbladmin","ad_name='{$_SESSION['c1907l_admin_usr']}'");
        // print_r($rsa);die;
        $header = "FROM: ".$rsa["ad_email"];
        if($_POST){
            $subject = $_POST["txtSub"];
            $mesages = $_POST["txtMes"];
            if($subject== ""){
                $do_send = "-1";
                $xtp->assign("er","Subject must be not null");
            }
            if($mesages== ""){
                $do_send = "-1";
                $xtp->assign("err","Message must be not null");
            }
            if($do_send === 1){
                // print_r ($to_email);
                // print_r ($subject);
                // print_r ($mesages);
                // print_r ($header);die;
                if(mail($to_email,$subject,$mesages,$header)){
                    $data["fb_status"] = 1;
                    if($db->update('tblfeedback',$data,"fb_id={$id}")){
                        $f->redir("?m=feedback&a=listF");
                    }
                }
            }
        }
    }
    
    $xtp->parse("ANS");
    $acontent = $xtp->text("ANS");