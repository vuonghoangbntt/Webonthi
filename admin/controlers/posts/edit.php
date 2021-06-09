<?php
    $xtp= new XTemplate("views/posts/edit.html");
    $id = $_GET['id'];
    if(isset($id)){
        $id = $_GET['id'];
        $rs= $db->getOne('tblposts',"pos_id={$id}");
        $rs['pos_date'] = date("Y-m-d",strtotime($rs['pos_date']));
        $rs["pos_img"] = explode(",",$rs['pos_img']);
        $rs["img"] = $rs["pos_img"][0];
        $vFocus = $rs['cat_id'];
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
        $lsCategory = $db->getSelect('tblcategory','cat_id','cat_name','txtCatName','Please select one',$vFocus);
        $xtp->assign('listCat',$lsCategory);
        $xtp->assign("EDIT",$rs);   
    }
    $do_save = 1;
    if($_POST){
        $data['pos_title'] = $_POST['txtPostName'];
        $data['pos_short_content'] = $_POST['txtPostShort'];
        $data['cat_id'] = $_POST['txtCatName'];
        $data['pos_content'] = $_POST['txtPostContent'];
        $file = $_FILES['file'];
        // print_r($file);die;
        $arFileType = array('jpg','png','jpeg');
        $sUrl = "../img/post";
        $maxFileSize = 5000000;
        $i = 0;
        while($i<count($file["name"])){
            $fil = array(
                "name"=>$file["name"][$i],
                'type'=>$file['type'][$i],
                'tmp_name'=>$file['tmp_name'][$i],
                'size'=>$file['size'][$i]
            );
            $dat[$i] = $f->uploadFile($fil,$sUrl,$arFileType,$maxFileSize);
            $i++;
        }   
        $data['pos_img'] = implode(",",$dat);
        if($data['pos_title'] == ""){
            $do_save = -1;
            $xtp->assign("mess_title","This Value must not be null ..");
        }
        if($data['pos_short_content'] == ""){
            $do_save = -1;
            $xtp->assign("mess_short","This Value must not be null ..");
        }
        if($data['pos_content'] == ""){
            $do_save = -1;
            $xtp->assign("mess_content","This Value must not be null ..");
        }
        if(strtotime($_POST['txtPostDate'])== 0){
            $do_save = -1;
            $xtp->assign("mess_date","This Value must not be null ..");
        }
        $xtp->assign("ADD",$_POST);
        if($do_save==1){
            if($db->update('tblposts',$data,"pos_id={$id}")){
                $f->redir("?m=posts&a=list");
            }
        }
    }
    $tit = "Edit Blog Sports";
    $xtp->parse("EDIT");
    $acontent = $xtp->text("EDIT");