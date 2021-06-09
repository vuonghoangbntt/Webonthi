<?php
    $xtp = new XTemplate("views/manage_file.html");
    $sql = "SELECT t.*, u.user_name
            FROM tbltest t, tbluser u
            WHERE t.user_id = u.user_id";
    $data = $db->fetchAll($sql);
    $script = "";
    $flag = 0;
    foreach($data as $rs){
        $rs['test_date_post'] = date("d-m-Y", strtotime($rs['test_date_post']));
        $rs['test_source'] = substr($rs['test_source'],3);
        if($rs['active']==1){
            $rs['status'] = 'Yes';
        }else{
            $rs['status'] = 'No (Chưa có đáp án)';
        }
        $flag++;
        $xtp->assign("LS",$rs);
        $xtp->parse("MANAGE.LIST.LS");
        if($flag==3){
            $flag = 0;
            $xtp->parse("MANAGE.LIST");
        }
    }
    if($flag!=0){
        $xtp->parse("MANAGE.LIST");
    }
    $xtp->parse("MANAGE");
    $acontent = $xtp->text("MANAGE");