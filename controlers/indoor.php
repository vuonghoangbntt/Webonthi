<?php
    $xtp = new Xtemplate("views/indoor.html");
    $data = $db->getOne('tblgallery',"name='image' AND position = 'indoor'");
    $img = explode(',',$data['image']);
    foreach($img as $rs){
        $data['image'] = substr($rs,3);
        $xtp->assign("IMG",$data);
        $xtp->parse("INDOOR.IMG");
    }
    $xtp->parse("INDOOR");
    $acontent = $xtp->text("INDOOR");