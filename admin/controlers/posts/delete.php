<?php
	$id = $_GET['id'];
	if(isset($id)){
		if($db->delete('tblposts',"pos_id={$id}")){
			$f->redir("?m=posts&a=list");
		}
	}