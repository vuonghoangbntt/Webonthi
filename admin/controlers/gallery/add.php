<?php
    $xtp = new Xtemplate("views/gallery/add.html");
    $do_save = 1;
    $id = $_GET["id"];
    if(isset($id)){
        $id = $_GET["id"];
        $rs = $db->getOne('tblposts',"pos_id={$id}");
        $xtp->assign("ADD",$rs);
    }
    //print_r ($rs);die;
    if(isset($_POST['add'])){
        $file = $_FILES['file'];
        if(isset($file)){
             // while($i<count($file["error"])){
            //     $do_save = "-1";
            // }
            $arFileType = array('jpg','png','jpeg');
            $sUrl = "./../img/post";
            $maxFileSize = 5000000;
            $d = $rs["pos_img"];
            $i = 0;
            while($i<count($file["name"])){
                $fil = array(
                    "name"=>$file["name"][$i],
                    'type'=>$file['type'][$i],
                    'tmp_name'=>$file['tmp_name'][$i],
                    'size'=>$file['size'][$i]
                );
                $da[$i] = $f->uploadFile($fil,$sUrl,$arFileType,$maxFileSize);
                $i++;
            }   
            $data['pos_img'] = implode(",",$da);
            // print_r ($data);die;
            if($do_save == 1){
                if($db->update('tblposts',$data,"pos_id={$id}")){
                  
                    $f->redir("?m=gallery&a=list");
                }
            }
           
        }
        
    }
    $xtp->parse("ADD");
    $acontent = $xtp->text("ADD");