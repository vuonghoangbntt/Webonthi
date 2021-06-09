<?php
    $id = $_GET['id'];
    if(isset($id)){
		$id = $_GET['id'];
        // $rs= $db->getOne('tblposts',"pos_id={$id}");
        $data["pos_status"] = 1; 
        if($db->update('tblposts',$data,"pos_id={$id}")){
            $f->redir("?m=posts&a=wait");
        }
	}