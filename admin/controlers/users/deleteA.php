<?php
	$id = $_GET['id'];
	if(isset($id)){
		if($db->delete('tbladmin',"ad_id={$id}")){
			$f->redir("?m=users&a=listA");
		}
	}