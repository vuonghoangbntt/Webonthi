<?php
    $xtp = new Xtemplate("views/users/List.html");
    $sql = "SELECT * FROM tbluser WHERE 1=1";
    $da = $db->fetchAll($sql);
    $NbrRe = 1;
    foreach($da as $rs){
    
            $rs['nbr'] = $NbrRe++;
        
    }
    $limit=30;
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
    $nbr =$db->limit($current_page,$start,$limit);
    $ad_sql = "SELECT * FROM tbluser WHERE 1=1
                LIMIT {$start},{$limit}";
    $data = $db->fetchAll($ad_sql);
    foreach($data as $rs){
        $rs['nbr'] = $nbr++;
        $rs["user_phone"] = "0".$rs["user_phone"];
        for($i=5;$i<strlen($rs["user_email"]);$i++){
                $rs["user_email"][$i] = "*"; 
        }
        for($i=4;$i<strlen($rs["user_phone"]);$i++){
            $rs["user_phone"][$i] = "*"; 
        }
        $xtp->assign("LS",$rs);
        $xtp->parse("LIST.LS");
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
    $tit = "List Account User";
    $key = "Key1";
    $idtbl = "listing1";
    $xtp->parse("LIST");
    $acontent = $xtp->text("LIST");