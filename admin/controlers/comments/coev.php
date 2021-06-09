<?php
    $xtp = new Xtemplate("views/comments/coev.html");
    $sql = "SELECT * FROM tblcomment WHERE post_id==0 ORDER BY comment_id DESC";
    $data = $db->fetchAll($sql);
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
    $sqli = "SELECT C.comment_id,C.comment_content,C.comment_date_post,U.user_name,C.post_id FROM tblcomment C INNER JOIN tbluser U ON C.user_id = U.user_id ORDER BY comment_id DESC
                LIMIT {$start},{$limit}";
    $datap = $db->fetchAll($sqli);
    $nbr =$db->limit($current_page,$start,$limit);
    foreach($datap as $rs){
        if($rs["post_id"] !="0"){
            $rs['nbr'] = $nbr++;
            if($rs["comment_date_post"] == "0000-00-00"){
                $rs["comment_date_post"] = "No Validated !";
            }
            if(strtotime($rs["comment_date_post"]) > 0){
                $rs["comment_date_post"] = date("d/m/Y",strtotime($rs["comment_date_post"]));
            }
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
        if($current_page == $i){
            $xtp->assign("bg",'style="background-color:rgb(25, 124, 238)"');
        }
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
    $tit = "Event Comments";
    // $key = "Key21";
    // $idtbl = "listing21";
    $xtp->parse("LIST");
    $acontent = $xtp->text("LIST");