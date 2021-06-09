<?php
$xtp = new Xtemplate("views/gallery/list.html");
$sql = "SELECT P.pos_id
                ,P.pos_title
                ,P.pos_img
        FROM tblposts P
        WHERE 1=1
        ORDER BY pos_id DESC";
    $rs = $db->fetchAll($sql);
    $nbr = 1;
    $roq = array();
    // $rot = array();
    // foreach($rs as $idd){
    //     $rot[] = $idd["pos_id"];
    // } 
    foreach($rs as $row){
        $roq = explode(",",$row["pos_img"]);
        $row["nbr"] = $nbr++;
        for($i=0;$i<count($roq);$i++){
            if($roq[$i]!="101" || $roq[$i]!="Array" || $roq[$i]!=""){
                $xtp->assign("pos_img",$roq[$i]);
                $xtp->assign("pos_id",$row['pos_id']);
                $xtp->parse("LIST.LS.LST");
            }
           
        }
     
        //  for($i=0;$i<count($rot);$i++){
           
        // }
        $xtp->assign("pos_id",$row["pos_id"]);
        $xtp->assign("LS",$row);
        $xtp->parse("LIST.CKJS");  
        $js[] = $xtp->text("LIST.CKJS");
        $xtp->parse("LIST.LS");  
     
        if(isset($_POST["d".$row["pos_id"]])){
            if(isset($_POST["cka".$row["pos_id"]])){
                $cka  = $_POST["cka".$row["pos_id"]];
                if($cka == "all"){
                    $f->redir("?m=gallery&a=delete&id={$row["pos_id"]}&v=-1");
                }
            }
            if(isset($_POST["ck".$row["pos_id"]])){
                $ck   = $_POST["ck".$row["pos_id"]];
                // print_r ($ck);die; 
                if(is_array($ck)==true){
                    $ct = implode(",",$ck);
                    $f->redir("?m=gallery&a=delete&id={$row["pos_id"]}&v={$ct}");
                }else{
                    if($ck != ""){
                        $f->redir("?m=gallery&a=delete&id={$row["pos_id"]}&v={$ck}");
                    }
                }        
            } 
        }
    }
    $xtp->parse("LIST.BS");
    $bs = $xtp->text("LIST.BS");
    $xtp->parse("LIST");
    $acontent = $xtp->text("LIST");