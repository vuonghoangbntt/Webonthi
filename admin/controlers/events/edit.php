<?php
    $xtp= new XTemplate("views/events/edit.html");
    $id = $_GET['id'];
    if(isset($id)){
        $rs= $db->getOne('tblevents',"even_id={$id}");
        $rs['even_date_start'] = date("Y-m-d",strtotime($rs['even_date_start']));
        $rs['even_date_end']   = date("Y-m-d",strtotime($rs['even_date_end']));
        $xtp->assign("EDIT",$rs);
    }
        $do_save = 1;
        if($_POST){
            $data['even_title']          = $_POST['txtEventName'];
            $data['even_content']        = $_POST['txtEventContent'];
            $data["even_date_start"]     = $_POST["txtEventDateStart"] ;
            $data["even_date_end"]       = $_POST["txtEventDateEnd"] ;
            $data["even_short_content"]  = $_POST["txtEventShort"] ;
            $file                        = $_FILES['efile'];
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
            $xtp->assign("EDIT",$data);
            if($do_save==1){
                if($db->update('tblevents',$data,"even_id={$id}")){
                    $f->redir("?m=events&a=list");
                }
            }
        }
    $tit = "Edit Event";
    $xtp->parse("EDIT");
    $acontent = $xtp->text("EDIT");
