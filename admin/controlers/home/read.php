<?php
    error_reporting(4);
    $xtp = new XTemplate('views/home/read.html');
    $sql = "SELECT P.pos_id
                  ,P.pos_img
            FROM tblposts P
            WHERE 1=1
            ORDER BY pos_id DESC";
    $rs = $db->fetchAll($sql);
    $roq = array();
    foreach($rs as $row){
        $roq = explode(",",$row["pos_img"]);
        // print_r($roq);
        for($i=0;$i<5;$i++){
            if($roq[$i]== ""){
                $xtp->assign("img".$i,"./../img/no_img.png");
            }else{
                $xtp->assign("img".$i,$roq[$i]);
            }
            // $xtp->parse("LIST.LS.LST");
            // $xtp->parse("LIST.LS");  
        }
    }
    
    /* Change url video home */
    $xtp->assign("video","./../video/home.mp4");
    
    // $bg = "./../img/bga.jpg";
    $xtp->parse("READ");
    $acontent = $xtp->text("READ");