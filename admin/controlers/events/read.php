<?php
    $xtp = new Xtemplate("views/events/read.html");
    $id = $_GET['id'];
    if(isset($id)){
        $id = $_GET['id'];
        $rs= $db->getOne('tblevents',"even_id={$id}");
        if($rs['ad_id'] != ""){
            $rsa = $db->getOne("tbladmin","ad_id={$rs['ad_id']}");
            $rs["ad_name"] = $rsa["ad_name"];
        }
        // print_r($rs);
        $rs['even_date_start'] = date("d/m/Y",strtotime($rs['even_date_start']));
        $rs['even_date_end']   = date("d/m/Y",strtotime($rs['even_date_end']));
        $xtp->assign("READ",$rs);   
    }
    $xtp->parse("READ");
    $acontent = $xtp->text("READ");