<?php
    $xtp = new Xtemplate("views/posts/add.html");
    $lsCategory = $db->getSelect('tblcategory','cat_id','cat_name','txtCatName','Please select one');
    $do_save = 1;
    $sql = "SELECT ad_id,ad_name FROM tbladmin WHERE 1=1";
    $rs = $db->fetchAll($sql);
    if($_POST){
        $data['pos_title'] = $_POST['txtPostName'];
        $data['pos_short_content'] = $_POST['txtPostShort'];
        foreach($rs as $row){
            if($row['ad_name'] == $_SESSION['c1907l_admin_usr']){
                $data['ad_id'] = $row['ad_id'];
            break;
            }
        }
        $data["pos_date"]    = $_POST["txtPostDate"]; 
        $data['cat_id']      = $_POST['txtCatName'];
        $data['pos_content'] = $_POST['txtPostContent'];
        $data["pos_status"]  = 1;
        $file = $_FILES['file'];
        $arFileType = array('jpg','png','jpeg');
        $sUrl = "./../img/post";
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
            $do_save = "-1";
            $xtp->assign("mess_title","This Value must not be null ..");
        }
        if($data['pos_short_content'] == ""){
            $do_save = "-1";
            $xtp->assign("mess_short","This Value must not be null ..");
        }
        if($data['pos_content'] == ""){
            $do_save = "-1";
            $xtp->assign("mess_content","This Value must not be null ..");
        }
        if(strtotime($_POST['txtPostDate'])== 0){
            $do_save = "-1";
            $xtp->assign("mess_date","This Value must not be null ..");
        }
        // $xtp->assign("ADD",$data);
        
      
       
        if($do_save== 1){
            if($db->insert('tblposts',$data)){
                // echo "Eror";die;
                // print_r($data);die;
                $f->redir("?m=posts&a=list");
            }
        }
    }
    $tit = "Add Blog Sports";
    $xtp->assign('listCat',$lsCategory);
    $xtp->parse("ADD");
    $acontent = $xtp->text("ADD");