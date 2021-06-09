<?php
    $xtp = new Xtemplate("views/all_post.html");
    $sql = "SELECT P.pos_id,P.pos_title,P.pos_date,P.pos_content,P.pos_img,U.user_name
            FROM tblpost P INNER JOIN tbluser U ON P.user_id=U.user_id
            WHERE P.pos_status = 1
            ORDER BY P.pos_date DESC";
    $data = $db->fetchAll($sql);
    foreach($data as $rs){
        $img = explode(',',$rs['pos_img']);
        $rs['pos_img'] = $img[0]; 
        if(strlen($rs['pos_content'])>300){
            $rs['pos_content'] = substr($rs['pos_content'],300);
            $rs['pos_content'].= '...';
        }
        if(!$valid->isNumeric($rs['pos_img'])&&$rs['pos_img']!=''){
            $rs['pos_img'] = substr($rs['pos_img'],3);
        }else{
            $rs['pos_img'] = 'no_image.jpg';
        }
        $xtp->assign("LS",$rs);
        $xtp->parse("ALL.LS");
    }
    if(isset($_SESSION['avatar'])){
        $xtp->assign("user_image",$_SESSION['avatar']);
    }else{
        $xtp->assign("user_image",'img_avatar2.png');
    }
    $xtp->parse("ALL");
    $acontent = $xtp->text("ALL");