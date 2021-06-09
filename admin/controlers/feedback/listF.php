<?php
    $xtp = new Xtemplate("views/feedback/listF.html");
    $sql = "SELECT * FROM tblfeedback WHERE 1=1 ORDER BY fb_date DESC";
    $data = $db->fetchAll($sql);
    $nbr = 1;
    $NbrRe = 1;
    foreach($data as $rs){
        $NbrRe++;
    }
    $limit = 30;
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
    $sqli = "SELECT * FROM tblfeedback WHERE 1=1 ORDER BY fb_date DESC
            LIMIT {$start},{$limit}";
    $datap = $db->fetchAll($sqli);
    $nbr =$db->limit($current_page,$start,$limit);
    foreach($datap as $rs){
        if($rs["fb_status"]== 1){
            for($i=5;$i<strlen($rs["fb_user_email"]);$i++){
                    $rs["fb_user_email"][$i] = "*"; 
            }
            $rs['nbr'] = $nbr++;
            $rs["duration"] = "Answered !";
            $rs["fb_date"] = date("d/m/Y",strtotime($rs["fb_date"]));
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
        }
    }
    if($current_page==1){
        $next = $current_page;
        $xtp->assign('next_page',$next);
    }
    $tit = "Feedbacks Answered !";
    $key = "Key21";
    $idtbl = "listing21";
    $xtp->parse("LIST");
    $acontent = $xtp->text("LIST");