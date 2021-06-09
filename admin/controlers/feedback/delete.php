<?php
	$id = $_GET['id'];
	if(isset($id)){
		if($db->delete('tblfeedback',"fe_id={$id}")){
			$f->redir("?m=feedback&a=list");
		}
	}