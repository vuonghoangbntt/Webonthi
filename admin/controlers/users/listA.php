<?php
    $xtp = new Xtemplate("views/users/listA.html");
    $ad_sql = "SELECT ad_name,ad_email,ad_phone,ad_position 
                FROM tbladmin 
                WHERE 1=1";
    $data = $db->fetchAll($ad_sql);
    // $Nbr=1;
    $tit = "List Account Admin";
    $NbrRe = 1;
    foreach($data as $rs){
    
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
    $ad_sql = "SELECT ad_name,ad_email,ad_phone,ad_position 
                FROM tbladmin 
                WHERE 1=1
                LIMIT {$start},{$limit}";
    $ad_data = $db->fetchAll($ad_sql);
    $Nbr =$db->limit($current_page,$start,$limit);
    foreach($ad_data as $rs){
        if($rs["ad_position"] != "CEO"){
            $rs['nbr'] = $Nbr++;
            $rs["ad_phone"] = "0".$rs["ad_phone"];
            for($i=5;$i<strlen($rs["ad_email"]);$i++){
                    $rs["ad_email"][$i] = "*"; 
            }
            for($i=4;$i<strlen($rs["ad_phone"]);$i++){
                $rs["ad_phone"][$i] = "*"; 
            }
            
                // $axtp->parse("LISTA.ADA");
                
            
            $rse = $db->getOne('tbladmin',"ad_name='{$_SESSION['c1907l_admin_usr']}'");
            if($rse["ad_position"] == "CEO"){
                // $xtp->parse("LISTA.ADA");
                $xtp->parse("LISTA.LST.DEA");   
            }
            $xtp->assign("LST",$rs);
            $xtp->parse("LISTA.LST");
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
            $xtp->parse("LISTA.LOP1");
        }
        if($i>$limit){
            $lis="...";
            $xtp->assign('li',$lis);
            $xtp->parse("LISTA.LOP");
        }
        // if($current_page == $i){
        //     $xtp->assign("bg",'style="background-color:rgb(25, 124, 238)"');
        // }
        $xtp->assign("page",$i);
        $xtp->assign("i",$i);
        $xtp->parse("LISTA.PA");
        
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
    $rst = $db->getOne('tbladmin',"ad_name='{$_SESSION['c1907l_admin_usr']}'");
    if($rst["ad_position"] == "CEO"){
        $xtp->parse("LISTA.ADA");
        // $axtp->parse("LISTA.LST.DEA");   
    }
    $key = "Key2";
    $idtbl = "list";
    $xtp->parse("LISTA");
    $acontent = $xtp->text("LISTA");