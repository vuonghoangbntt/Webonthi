<?php
    $xtp = new Xtemplate("views/profile.html");
    $row = $db->getOne('tbluser',"user_id = {$_SESSION['login_user_id']}");
    if($valid->isNumeric($row['user_avatar'])||$row['user_avatar']==''){
        $row['user_avatar'] = 'img_avatar2.png';
    }else{
        $row['user_avatar'] = substr($row['user_avatar'],3);
    }
    $xtp->assign("LS",$row);
    $xtp->parse("PROFILE.LS");
    $xtp->parse("PROFILE");
    $acontent = $xtp->text("PROFILE");