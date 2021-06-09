<?php
    $xtp = new XTemplate("views/edit_test.html");
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
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbltest WHERE test_id = $id";
    $stmt = $db->execSQL($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $lsType = str_replace("<option value='{$data["type_id"]}'>","<option value='{$data["type_id"]}' selected = 'selected'>",$lsType);
    $lsCategory = str_replace("<option value='{$data["cat_id"]}'>","<option value='{$data["cat_id"]}' selected = 'selected'>",$lsCategory);
    if($_POST){
        $r_data['test_title'] = $_POST['txtPostName'];
        $r_data['test_description'] = $_POST['txtShortContent'];
        //$data['pos_content'] = $_POST['txtContent'];
        $r_data['test_date_post'] = date("Y-m-d",time());
        $r_data['num_of_question'] = $_POST['txtNumOfQuestion'];
        //$data['pos_status'] = -1;
        $r_data['cat_id'] = $_POST['txtCatName'];
        $r_data['type_id'] = $_POST['txtTypeName'];
        if($r_data['num_of_question'] == $data['num_of_question']||$r_data['type_id']!='1'){
            $r_data['answer'] = $data['answer'];
            $r_data['active'] = $data['active'];
        }else{
            $r_data['active'] = -1;
        }
        $r_data['test_source'] = $data['test_source'];
        if($db->update('tbltest',$r_data, "test_id = {$id}")){
            if($r_data['num_of_question'] == $data['num_of_question']||$r_data['type_id']!='1'){
                $f->redir("?a=manage_file");
            }else{
                $f->redir("?a=edit_answer&id={$id}");
            }
            
        };

    }
    $xtp->assign("UPLOAD",$data);
    $xtp->assign("lsCategory",$lsCategory);
    $xtp-> assign("lsType",$lsType);
    $xtp->assign("mess_error",$error);
    $xtp->parse("UPLOAD");
    $acontent = $xtp->text("UPLOAD");
    