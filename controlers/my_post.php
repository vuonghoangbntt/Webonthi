<?php
    $xtp = new Xtemplate("views/my_post.html");
    $sql = "SELECT * FROM tblpost WHERE user_id = {$_SESSION['login_user_id']}";
    $data = $db->fetchAll($sql);
    foreach($data as $rs){
        $img = explode(',',$rs['pos_img']);
        $rs['pos_img'] = $img[0]; 
        if(!$valid->isNumeric($rs['pos_img'])&&$rs['pos_img']!=''){
            $rs['pos_img'] = substr($rs['pos_img'],3);
        }else{
            $rs['pos_img'] = 'no_image.jpg';
        }
        if($rs['pos_status']==-1){
            $rs['pos_status'] = "Waiting";
        }else{
            $rs['pos_status'] = "Uploaded";
        }
        $xtp->assign("LS",$rs);
        $xtp->parse("MYPOST.LS");
    }
    $xtp->parse("MYPOST");
    $acontent = $xtp->text("MYPOST");