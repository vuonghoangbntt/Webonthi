<?php
    $id = $_GET['id'];
    $v  = $_GET['v'];
    // print_r ($v);die;
	if(isset($id)){
        if(isset($v)){
            if($v== "-1"){
                // $rs= $db->getOne('tblposts',"pos_id={$id}");
                $data["pos_img"] = "";
                if($db->update('tblposts',$data,"pos_id={$id}")){
                    $f->redir("?m=gallery&a=list");
                }
            }
            if($v != "-1"){
                $rs= $db->getOne('tblposts',"pos_id={$id}");
                $rst = explode(",",$rs['pos_img']);
                if(strlen($rst[0])<strlen($v)){
                    $vr = explode(",",$v);
                    $ar = array_diff($rst,$vr);
                    $data['pos_img'] = implode(",",$ar);
                    if($db->update('tblposts',$data,"pos_id={$id}")){
                        $f->redir("?m=gallery&a=list");
                    }
                }else{
                    for($i=0;$i<count($rst);$i++){
                        if($rst[$i]!=$v ){
                            $r[$i] = $rst[$i];
                      
                        }
                    }
                    $data['pos_img'] = implode(",",$r);
                    if($db->update('tblposts',$data,"pos_id={$id}")){
                        $f->redir("?m=gallery&a=list");
                    }
                }
               
            }
        }
	}