<?php
    $xtp = new Xtemplate("views/events/List.html");
    $sql = "SELECT even_id
                    ,even_title
                    ,even_date_start
                    ,even_date_end
            FROM tblevents 
            WHERE 1=1
            ORDER BY even_id DESC";
    $data = $db->fetchAll($sql);
    $NbrRe = 1;
    foreach($data as $rs){
        $NbrRe++; 
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
    $sqli = "SELECT even_id
                    ,even_title
                    ,even_date_start
                    ,even_date_end
            FROM tblevents 
            WHERE 1=1
            ORDER BY even_id DESC
            LIMIT {$start},{$limit}";
    $datap = $db->fetchAll($sqli);
    $nbr =$db->limit($current_page,$start,$limit);
    foreach($datap as $rs){
        $rs['nbr'] = $nbr++;
        $rs['even_date_start'] = date("d-m-Y",strtotime($rs['even_date_start']));
        $rs['even_date_end'] = date("d-m-Y",strtotime($rs['even_date_end']));
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
        }
    }
    if($current_page==1){
        $next = $current_page;
        $xtp->assign('next_page',$next);
    }
    $tit = "Events";
    $xtp->parse("LIST");
    $acontent = $xtp->text("LIST");