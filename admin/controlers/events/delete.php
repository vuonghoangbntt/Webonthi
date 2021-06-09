<?php
	$id = $_GET['id'];
	if(isset($id)){
		if($db->delete('tblevents',"even_id={$id}")){
			$f->redir("?m=events&a=list");
		}
	}