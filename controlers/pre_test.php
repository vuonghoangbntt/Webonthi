<?php
    $xtp = new Xtemplate("views/pre_test.html");
    $id = $_GET['id'];
    $xtp->assign('post_id',0);
    $xtp->assign('test_id',$id);
    $sql = "SELECT T.test_id, T.test_title, T.test_description, U.user_name,T.test_date_post, T.test_source
            FROM tbltest T, tbluser U
            WHERE T.user_id = U.user_id AND T.test_id = {$id}";
    $stmt = $db->execSQL($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $xtp->assign("title",$data['test_title']);
    $xtp->assign("date",date("d-m-Y",strtotime($data['test_date_post'])));
    $xtp->assign("description",$data['test_description']);
    $xtp->assign("owner", $data['user_name']);
    $sql = "SELECT H.highest_mark, H.total_times, U.user_name, H.highest_total_time
            FROM tblhistory H, tbluser U
            WHERE H.test_id = {$id} AND H.user_id = U.user_id
            ORDER BY H.highest_mark DESC
            LIMIT 5";
    //print_r($sql); die;
    $rs = $db->fetchAll($sql);
    $table = "";
    foreach($rs as $row){
        $table.= "<tr>
            <td>{$row['user_name']}</td>
            <td>{$row['highest_mark']}</td>
            <td>{$row['highest_total_time']}</td>
            <td>{$row['total_times']}</td>
        </tr>";
    }
    $xtp->assign("tbl",$table);
    $xtp->parse("READY");
    $acontent = $xtp->text("READY");
