<?php
    include("../libs/bootstrap.php");
    $error = '';
    $flag= 1;
    if(empty($_POST["comment_content"]))
    {
        $error.= '<p class="text-danger">Comment is required</p>';
        $flag = 0 ;
    }
    if(!isset($_SESSION['login_user'])||$_SESSION['login_user']==''){
        $error.="<p class='text-danger'>Login to post comment</p>";
        $flag = 0 ;
    }
    if($flag==1){
        $data['comment_content'] = $_POST['comment_content'];
        if(isset($_POST['comment_id'])){
            $data['comment_parent_id'] = $_POST['comment_id'];
        }else{
            $data['comment_parent_id'] = 0;
        }
        
        $data['post_id'] = $_POST['post_id'];
        $data['test_id'] = $_POST['test_id'];
        $data['user_id'] = $_SESSION['login_user_id'];
        $data['comment_date_post'] = date("M,d,Y");
        $db->insert('tblcomment',$data);
        $error = '<label class="text-success">Comment Added</label>';
    }
    $data = array(
        'error'  => $error
    );   
    echo json_encode($data);
       