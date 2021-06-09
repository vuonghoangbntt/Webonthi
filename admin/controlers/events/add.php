<?php
    $xtp = new Xtemplate("views/events/add.html");
    $do_save = 1;
    $sql = "SELECT ad_id,ad_name FROM tbladmin WHERE 1=1";
    $rs = $db->fetchAll($sql);
    if($_POST){
        foreach($rs as $row){
            if($row['ad_name'] == $_SESSION['c1907l_admin_usr']){
                $data['ad_id'] = $row['ad_id'];
            break;
            }
        }
        $data['even_title']          = $_POST['txtEventName'];
        $data['even_content']        = $_POST['txtEventContent'];
        $data["even_date_start"]     = $_POST["txtEventDateStart"] ;
        $data["even_date_end"]       = $_POST["txtEventDateEnd"] ;
        $data["even_short_content"]  = $_POST["txtEventShort"] ;
        $file = $_FILES['efile'];
        $arFileType = array('jpg','png','jpeg');
        $sUrl = "./../img/event";
        $maxFileSize = 5000000;
        $i = 0;
        while($i<count($file["name"])){
            $fil = array(
                "name"=>$file["name"][$i],
                'type'=>$file['type'][$i],
                'tmp_name'=>$file['tmp_name'][$i], 
                'size'=>$file['size'][$i]
            );
            $data['even_img'][$i] = $f->uploadFile($fil,$sUrl,$arFileType,$maxFileSize);
            $i++;
        }   
        $data['even_img'] = implode(",",$data['even_img']);
        if($data['even_title'] == ""){
            $do_save = "-1";
            $xtp->assign("mess_title","This Value must not be null ..");
        }
        if($data['even_short_content'] == ""){
            $do_save = "-1";
            $xtp->assign("mess_short","This Value must not be null ..");
        }
        if($data['even_content'] == ""){
            $do_save = "-1";
            $xtp->assign("mess_content","This Value must not be null ..");
        }
        if(strtotime($data["even_date_start"])== 0){
            $do_save = "-1";
            $xtp->assign("mess_date_start","This Value must not be null ..");
        }
        if(strtotime($data["even_date_end"])== 0){
            $do_save = "-1";
            $xtp->assign("mess_date_end","This Value must not be null ..");
        }
        if(strtotime($data["even_date_end"])<strtotime($data["even_date_start"])){
            $do_save = "-1";
            $xtp->assign("mess_date_end","Date Start must be smaller than Date End");
        }
        $xtp->assign("ADD",$data);
        if($do_save==1){
            if($db->insert('tblevents',$data)){
                $f->redir("?m=events&a=list");
            }
        }
    }
    $tit = "Add Event";
    $xtp->parse("ADD");
    $acontent = $xtp->text("ADD");

    
