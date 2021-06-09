<?php
    include("../libs/bootstrap.php");
    $error = '';
    $flag = 1;
    if(!$valid->isMail($_POST['txtEmail'])){
        $flag = 0;
        $error.='<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Invalid email!!
                </div>';
    }
    if(!$valid->isPhone($_POST['nbrPhone'])){
        $flag = 0;
        $error.='<div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong>Warning!</strong> Invalid phone number!!
                </div>';
    }
    if($flag!=0){
        $data['fb_user_name'] = $_POST['txtName'];
        $data['fb_user_phone'] = $_POST['nbrPhone'];
        $data['fb_user_email'] = $_POST['txtEmail'];
        $data['fb_date'] = date("Y-m-d");
        $data['fb_mess'] = $_POST['txtMessage'];
        if($db->insert('tblfeedback',$data)){
            $error.='<div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Success!</strong> Your feedback is sent.
                    </div>';
        }

    }
    $data = array(
        'error'  => $error,
        'flag' => $flag
    );
    echo json_encode($data);