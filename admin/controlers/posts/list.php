<?php
error_reporting(4);
    $xtp = new Xtemplate("views/posts/List.html");
    $sql = "SELECT P.pos_id
                ,P.pos_title
                ,P.user_id
                ,P.ad_id
                ,C.cat_name
                ,P.cat_id
                ,P.pos_date
                ,P.pos_total_view
                ,P.pos_like_and_share
                ,P.pos_status
            FROM tblposts P
            INNER JOIN tblcategory C
            ON C.cat_id = P.cat_id
            WHERE 1=1
            ORDER BY P.pos_id DESC";
    $data = $db->fetchAll($sql);
    // print_r($data);die;
    $NbrRe = 1;
    foreach($data as $rs){
        if($rs["pos_status"]=="1"){
            $rs['nbr'] = $NbrRe++;
        } 
    }
    $limit=15;
    // Tổng số trang dữ liệu
    $total_page = ceil($NbrRe / $limit);
   
   // Tìm Trang hiện tại
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Giới hạn current_page trong khoảng 1 đến total_page
   if ($current_page > $total_page){
        $current_page = $total_page;
    }
   if ($current_page < 1){
       $current_page = 1;
   }
    $start = ($current_page - 1) * $limit;
    $sql = "SELECT P.pos_id
                ,P.pos_title
                ,P.user_id
                ,P.ad_id
                ,C.cat_name
                ,P.cat_id
                ,P.pos_date
                ,P.pos_total_view
                ,P.pos_like_and_share
                ,P.pos_status
            FROM tblposts P
            INNER JOIN tblcategory C
            ON C.cat_id = P.cat_id
            WHERE 1=1
            ORDER BY P.pos_id DESC
            LIMIT {$start},{$limit}";
    $datap = $db->fetchAll($sql);
    $Nbr =$db->limit($current_page,$start,$limit);
    foreach($datap as $rs){
        if($rs["pos_status"]=="1"){
            $rs['nbr'] = $Nbr++;
            if($rs["user_id"] != "" && $rs["ad_id"]==""){
                $rsu = $db->getOne('tbluser',"user_id={$rs['user_id']}");
                $rs["user_name"] = $rsu["user_name"];
            }else{
                $rsa = $db->getOne('tbladmin',"ad_id={$rs["ad_id"]}");
                $rs["user_name"] = $rsa["ad_name"];
            }
            if($rs["cat_id"] == 1){
                $rs["pos_type"] = "Indoor Sports Blog";
            }
            if($rs["cat_id"] == 2){
                $rs["pos_type"] = "Outdoor Sports Blog";
            }
            if($rs["cat_id"]==3){
                $rs["pos_type"] = "Recreation Blog";
            }
            $rs['pos_date'] = date("d-m-Y",strtotime($rs['pos_date']));
            $xtp->assign("LS",$rs);
            $xtp->parse("LIST.LS");
        } 
    }
    if ($current_page > 1 && $total_page > 1){
        $pre = $current_page-1;
        $xtp->assign('pre_page',$pre);
    }
    if($current_page==1){
        $pre = $current_page;
        $xtp->assign('pre_page',$pre);
    }
    for ($i = 1; $i <= $total_page; $i++){
        if($i== ceil($limit/2)){
            $lis="...";
            $xtp->assign('lii',$lis);
            $xtp->parse("LIST.LOP1");
        }
        if($i>$limit){
            $lis="...";
            $xtp->assign('li',$lis);
            $xtp->parse("LIST.LOP");
        }
        // if($current_page == $i){
        //     $xtp->assign("bg",'style="background-color:rgb(25, 124, 238)"');
        // }
        $xtp->assign("page",$i);
        $xtp->assign("i",$i);
        $xtp->parse("LIST.PA");
        
    }
    if ($current_page < $total_page && $total_page > 1){
        $next = $current_page+1;
        $xtp->assign('next_page',$next);
    
    if($next> $total_page){
        $xtp->assign('next_page',$next);
    }}
    if($current_page==1){
        $next = $current_page;
        $xtp->assign('next_page',$next);
    }
    $tit = "Blog Sports";
    $xtp->parse("LIST");
    $key = "Key";
    $idtbl = "listing";
    $acontent = $xtp->text("LIST");
