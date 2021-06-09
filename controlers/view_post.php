<?php
    $xtp = new Xtemplate("views/view_post.html");
    $id = $_GET['id'];
    $xtp->assign("id",$id);
    $xtp->assign('post_id',$id);
    $xtp->assign('test_id',0);
    $sql = "SELECT P.pos_id,P.pos_status,P.pos_title,P.pos_date,P.pos_content,P.pos_img,U.user_name,U.user_avatar
            FROM tblpost P INNER JOIN tbluser U ON P.user_id=U.user_id 
            WHERE P.pos_id = {$id}";
    $stmt = $db->execSQL($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    /*if(isset($_SESSION['login_user'])&&$_SESSION['login_user']!=$data['user_name']&&$data['pos_status']!=-1){
        $data['pos_total_view']++;
        $sql = "UPDATE tblposts SET pos_total_view = {$data['pos_total_view']} WHERE pos_id = {$id}";
        $db->execSQL($sql);
    }*/
    $img = explode(',',$data['pos_img']);
    $val = 'no_image.jpg';
    foreach($img as $row){
        if(!$valid->isNumeric($row)){
            $row = substr($row,3);
            $val = $row;
        }else{
            $row = 'no_image.jpg';
        }
        $dat = array('image' => $row);
        $xtp->assign("IMG",$dat);
        $xtp->parse("VIEW.LS.IMG"); 
    }
    $data['pos_img'] = $val;
    //print_r($data); die;
    if(isset($_SESSION['avatar'])){
        $xtp->assign("user_image",$_SESSION['avatar']);
    }else{
        $xtp->assign("user_image",'img_avatar2.png');
    }
    if($valid->isNumeric($data['user_avatar'])||$data['user_avatar']==''){
        $data['user_avatar'] = 'img_avatar2.png';
    }
    $data['pos_date'] = date("M,d,Y",strtotime($data['pos_date']));
    $xtp->assign("LS",$data);
    $xtp->parse("VIEW.LS");
    $xtp->parse("VIEW");
    $acontent = $xtp->text("VIEW");
    