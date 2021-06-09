<?php
    $xtp = new Xtemplate("views/add_post.html");
    $flag = 1;
    $error = "";
    $lsCategory = $db->getSelect('tblcategory','cat_id','cat_name','txtCatName','Please select one');
    //print($_SESSION['login_user']); die;
    if(!isset($_SESSION['login_user'])||$_SESSION['login_user']==''){
        $flag = 0;
        $error.='<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Login to post!!
                </div>';
    }
    if($flag!=0&&$_POST){
            $data['pos_title'] = $_POST['txtPostName'];
            //$data['pos_short_content'] = $_POST['txtShortContent'];
            $data['pos_content'] = $_POST['txtContent'];
            $data['pos_date'] = date("Y-m-d",time());
            $data['pos_status'] = 1;
            $data['cat_id'] = $_POST['txtCatName'];
            $data['pos_approve'] = 0;
            if($_POST['txtCatName'] == '-1'){
                $error.='<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Warning!</strong> Please choose one category!!
                        </div>';
                $flag = 0;
            }
            $data['user_id'] = $_SESSION['login_user_id'];
            $file = $_FILES['file'];
       
            $arFileType = array('jpg','png','jpeg');
            $sUrl = "img/post";
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
                if(!$valid->isNumeric($dat[$i])){
                    $dat[$i] = '../'.$dat[$i];
                }
                $i++;
            }   
            $data['pos_img'] = implode(",",$dat);
            if($flag!=0){
                $db->insert('tblpost',$data);
                $f->redir("{$baseUrl}/?a=blog");
            }
    }
    $xtp->assign("lsCategory",$lsCategory);
    $xtp->assign("mess_error",$error);
    $xtp->parse("NEW");
    $acontent = $xtp->text("NEW");