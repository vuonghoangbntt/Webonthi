<?php
	$id = $_GET['id'];
	if(isset($id)){
		if($db->delete('tbluser',"user_id={$id}")){
			$f->redir("?m=users&a=list");
		}
	}