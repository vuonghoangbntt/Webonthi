<?php
    $xtp = new XTemplate("views/home.html");
    $sql = "SELECT * FROM tbluser WHERE 1=1";
    $rs  = $db->fetchAll($sql);
    $data = $db->getOne('tblgallery',"name='carousel' AND position = 'home'");
    $img = explode(',',$data['image']);
    $carousel = '';
    $counter = 0;
    foreach($img as $rs){
        if($counter==0){
            $image = substr($rs,3);
            $carousel.= "<div class='carousel-item active'>
                                <img src='{$image}' alt='' width='100%' height='600px'>
                                </div>";
            $counter++;
        }else{
            $image = substr($rs,3);
            $carousel.= "<div class='carousel-item'>
                                <img src='{$image}' alt='' width='100%' height='600px'>
                                </div>";
        }
    }
    $xtp->assign("carousel",$carousel);
    $xtp->parse("HOME");
    $acontent = $xtp->text("HOME");