<?php
    $xtp = new Xtemplate("views/posts/read.html");
    $id = $_GET['id'];
    if(isset($id)){
        $id = $_GET['id'];
        $rs= $db->getOne('tblposts',"pos_id={$id}");
        $rs['pos_date'] = date("d/m/Y",strtotime($rs['pos_date']));
        // $rs["pos_img"] = explode(",",$rs['pos_img']);
        // $rs["img"] = $rs["pos_img"][0];
        // $vFocus = $rs['cat_id'];
        // $ext = array();
        // $arExt = array();
        // for($i=0;$i<count($rs['pos_img']);$i++){
        //     $arExt[$i]          = explode('_',$rs['pos_img'][$i]);
        //     $rs['pos_img'][$i]  = end($arExt[$i]);
        //     $rs['pos_img'][$i]  = strtolower($rs['pos_img'][$i]);
        // }
        // print_r($rs["pos_img"]);
        // $rs["pos_img"] = implode('" "',$rs['pos_img']);
        // $rs["pos_img"] = '"'.$rs["pos_img"].'"';
        // print_r($rs["pos_img"]);
        $xtp->assign("READ",$rs);   
    }
    $xtp->parse("READ");
    $acontent = $xtp->text("READ");