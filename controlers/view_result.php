<?php
    $xtp = new Xtemplate("views/view_result.html");
    $id = $_GET['id'];
    $sql = "SELECT H.*,T.test_title FROM tblhistory H, tbltest T
            WHERE H.user_id = {$_SESSION['login_user_id']} AND H.test_id = {$id} AND H.test_id=T.test_id";
    $stmt = $db->execSQL($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $xtp->assign('lastest', $data['lastest_mark']);
    $xtp->assign('highest', $data['highest_mark']);
    $xtp->assign('title', $data['test_title']);
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
    $xtp->parse("RESULT");
    $acontent = $xtp->text("RESULT");