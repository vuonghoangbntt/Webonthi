<?php
	include("../libs/bootstrap.php");
	$axtp = new XTemplate('views/index.html');
	 if($_SESSION['c1907l_admin_usr']==''){
	 	$f->redir("login.php");
	 }
	 else{
	 	$m = $_GET['m'];//get module;
	 	$a = $_GET['a'];//get module;
	 	if(file_exists("controlers/{$m}/{$a}.php")){
	 		include("controlers/{$m}/{$a}.php");
	 	}
	 	else{
	 		echo 'Not Found 404';
		 }

		$axtp->assign('usr_name',$_SESSION['c1907l_admin_usr']);
		$axtp->assign('acontent',$acontent);
		$rs = $db->getOne("tbladmin","ad_name='{$_SESSION['c1907l_admin_usr']}'");
		if($rs["ad_avatar"] != "101" && $rs["ad_avatar"] != ""){
			if($rs["ad_avatar"][0] == "." && $rs["ad_avatar"][1] == "/"){
				$axtp->assign("img",$rs["ad_avatar"]);
			}else{
				$axtp->assign("img","./".$rs["ad_avatar"]);
			}
			$axtp->parse("LAYOUT.AVA");
		}
		if($rs["ad_avatar"] == "101" || $rs["ad_avatar"] == ""){
			$axtp->parse("LAYOUT.ICON");
		}
		 if(isset($js)){
			for($i=0;$i<count($js);$i++){
				// if((count($js))>0){
					
					$axtp->assign('js',$js[$i]);
					$axtp->parse("LAYOUT.CK");
				// }
			}
		 }
		if(isset($tit)){
			$axtp->assign("title",$tit);
		}
		$keyCom = ["fuck","asshole","bastard","Bitch","shit","Chink","Cunt","Dickhead","Dyke","Dork","Dog","dawg","Fag","faggot","Freak","Geek","Gook","Ho","Idiot","Jerk","Limey","Loser","Moron","Motherfucker","Mofo","Nigger","Pig","Queer","Slut","Swine","Sucker","Whore"];
		$sqli = "SELECT * FROM tblcomment WHERE 1=1 ORDER BY comment_id DESC";
		$rsi = $db->fetchAll($sqli);
		foreach($rsi as $row){
			// if(is_array($row["com_content"])){
				$row["comment_content"] = explode(" ",$row["comment_content"]);
				if(in_array($keyCom,$row["comment_content"])){	
					$db->delete('tblcomment',"comment_id={$row["comment_id"]}");
					
				}
			// }
		}
		/*Key search */
		
		if(isset($key)){
			// $axtp->parse("LAYOUT.JS");
			$axtp->assign('key',$key);
			$axtp->assign('idtbl',$idtbl);
		}
		if(isset($key1)){
			$axtp->parse("LAYOUT.JS");
			$axtp->assign('key1',$key1);
			$axtp->assign('idtbl1',$idtbl1);
		}

		/*Change url Background-image */
		// if(isset($bg)){
		// 	$axtp->assign('BG',$bg);
		// }

		if(isset($bs)){
			$axtp->assign('BS',$bs);
		}
		// $axtp->assign('idtbl',$idtbl);
		$axtp->assign('baseUrl',$baseUrl);
		
	 	$axtp->parse("LAYOUT");
	 	$axtp->out("LAYOUT");
	 }
	//  $m = $_GET['m'];//get module;
	//  $a = $_GET['a'];//get module;
	//  if(file_exists("controlers/{$m}/{$a}.php")){
	//  	include("controlers/{$m}/{$a}.php");
	//  }
	//  else{
	//  	echo 'Not Found 404';
	//  }
	//  $axtp->assign('acontent',$acontent);
	//  $axtp->assign('baseUrl',$baseUrl);
	//  $axtp->parse("LAYOUT");
	//  $axtp->out("LAYOUT");