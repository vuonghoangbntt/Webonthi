<?php
    $xtp = new Xtemplate("views/upload_file.html");
    $flag = 1;
    $error = "";
    $lsCategory = $db->getSelect('tblcategory','cat_id','cat_name','txtCatName','Please select one');
    $lsType = $db->getSelect('tbltype','type_id','type_name','txtTypeName','Please select one');
    //print($_SESSION['login_user']); die;
    if(!isset($_SESSION['login_user'])||$_SESSION['login_user']==''){
        $flag = 0;
        $error.='<div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Login to post!!
                </div>';
    }
    if($flag!=0&&$_POST){
            $data['test_title'] = $_POST['txtPostName'];
            $data['test_description'] = $_POST['txtShortContent'];
            //$data['pos_content'] = $_POST['txtContent'];
            $data['test_date_post'] = date("Y-m-d",time());
            $data['num_of_question'] = $_POST['txtNumOfQuestion'];
            //$data['pos_status'] = -1;
            $data['cat_id'] = $_POST['txtCatName'];
            $data['type_id'] = $_POST['txtTypeName'];
            $data['active'] = -1;
            if($data['type_id']!=1){
                $data['active'] = 1;
            }
            
            if($_POST['txtCatName'] == '-1'){
                $error.='<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>Warning!</strong> Please choose one category!!
                        </div>';
                $flag = 0;
            }
            $data['user_id'] = $_SESSION['login_user_id'];
            $file = $_FILES['file'];
            $arFileType = array('pdf');
            $sUrl = "pdf";
            $maxFileSize = 500000000;
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
            $data['test_source'] = implode(",",$dat);
            if($flag!=0){
                $db->insert('tbltest',$data);
                $class = $data['cat_id']+9;
                if($data['type_id']!=1){
                    $f->redir("{$baseUrl}/?a=list_revise&lop={$class}");
                }else{
                    $f->redir("{$baseUrl}/?a=manage_file");
                }
            }
    }
    $xtp->assign("lsCategory",$lsCategory);
    $xtp-> assign("lsType",$lsType);
    $xtp->assign("mess_error",$error);
    $xtp->parse("UPLOAD");
    $acontent = $xtp->text("UPLOAD");