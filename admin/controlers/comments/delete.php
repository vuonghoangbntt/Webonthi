<?php
	$id = $_GET['id'];
	if(isset($id)){
        //$rs = $db->getOne('tblcomment',"comment_id={$id}");
        if($db->delete('tblcomment',"comment_id={$id}")){
            $f->redir("?m=comments&a=copo");
        }
    }
   