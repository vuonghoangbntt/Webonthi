<?php
    $xtp = new Xtemplate("views/list_revise.html");
    $class = $_GET['lop'];
    $class = $class-9;
    if($class != 4){
        $sql = "SELECT T.test_id, T.test_title, T.test_description, U.user_name,T.test_date_post,V.cat_name, T.test_source
            FROM tbltest T, tbluser U, tblcategory V
            WHERE T.user_id = U.user_id AND T.cat_id = V.cat_id AND T.type_id = 2 AND V.cat_id = {$class}";
    }else{
        $sql = "SELECT T.test_id, T.test_title, T.test_description, U.user_name,T.test_date_post,V.cat_name, T.test_source
            FROM tbltest T, tbluser U, tblcategory V
            WHERE T.user_id = U.user_id AND T.cat_id = V.cat_id AND T.type_id = 3";
    }
    
    $data = $db->fetchAll($sql);
    $flag = 0;
    $list = "";
    foreach($data as $rs){
        $rs['test_date_post'] = date("d-m-Y", strtotime($rs['test_date_post']));
        $rs['test_source'] = substr($rs['test_source'],3);
        if($flag!=0){
            $flag = 0;
            $list.= "<div class='col-md-2'>
                <img src='pdf_logo.jpg' class='rounded' style='width: 80%;height: 200px;'>
            </div>
            <div class='col-md-4'>
                <h4>{$rs['test_title']}</h4>
                <p>By: {$rs['user_name']}</p>
                <p>On: {$rs['test_date_post']}</p>
                <p>{$rs['test_description']}</p>
                <button type='button' class='btn btn-primary'><span class='fas fa-eye' style='margin-right: 5px;'></span><a href='{$rs['test_source']}' style='color: white;text-decoration: none;'>Xem trước</a></button>
                <button type='button' class='btn btn-danger'><span class='fas fa-download' style='margin-right: 5px;'></span><a href='{$rs['test_source']}' download style='color: white;text-decoration: none;'>Download</a></button>
            </div>
            </div>";
        }else{
            $flag+=1;
            $list.= "<div class='row'>
            <div class='col-md-2'>
                <img src='pdf_logo.jpg' class='rounded' style='width: 80%;height: 200px;'>
            </div>
            <div class='col-md-4'>
                <h4>{$rs['test_title']}</h4>
                <p>By: {$rs['user_name']}</p>
                <p>On: {$rs['test_date_post']}</p>
                <p>{$rs['test_description']}</p>
                <button type='button' class='btn btn-primary'><span class='fas fa-eye' style='margin-right: 5px;'></span><a href='{$rs['test_source']}' style='color: white;text-decoration: none;'>Xem trước</a></button>
                <button type='button' class='btn btn-danger'><span class='fas fa-download' style='margin-right: 5px;'></span><a href='{$rs['test_source']}' download style='color: white;text-decoration: none;'>Download</a></button>
            </div>
            ";
        }
    }
    if($flag!=0){
        $list.= "</div>";
    }
    $class+= 9;
    if($class!=13){
        $xtp->assign("class","lớp {$class}");
    }
    $xtp->assign("list",$list);
    $xtp->parse("LIST");
    $acontent = $xtp->text("LIST");