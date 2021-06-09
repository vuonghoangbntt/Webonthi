<?php
    $xtp = new Xtemplate("views/history.html");
    $sql =  "SELECT H.*, T.test_title FROM tblhistory H, tbltest T 
            WHERE H.test_id = T.test_id AND H.user_id = {$_SESSION['login_user_id']} 
            ORDER BY H.lastest_date";
    $data = $db->fetchAll($sql);
    $history = '';
    $flag = 0;
    foreach($data as $rs){
        $rs['lastest_date'] = date('d-m-Y', strtotime($rs['lastest_date']));
        if($flag!=0){
            $flag = 0;
           $history.= "<div class='col-md-6'>
            <div class='card bg-primary'>
            <div class='card-body'>
                <h4>{$rs['test_title']}</h4>
                <hr>
                <p>Số lượt đã thi: {$rs['total_times']}</p>
                <p>Kết quả cao nhất: {$rs['highest_mark']}</p>
                <p>Kết quả lần gần đây nhất: {$rs['lastest_mark']}</p>
                <p>Ngày thi gần nhất: {$rs['lastest_date']}</p>
            </div>
            </div>
        </div>
        </div>";
        }else{
            $flag+= 1;
            $history.= "<div class='row' style = 'margin-top: 20px;'>
            <div class='col-md-6'>
            <div class='card bg-info'>
            <div class='card-body'>
                <h4>{$rs['test_title']}</h4>
                <hr>
                <p>Số lượt đã thi: {$rs['total_times']}</p>
                <p>Kết quả cao nhất: {$rs['highest_mark']}</p>
                <p>Kết quả lần gần đây nhất: {$rs['lastest_mark']}</p>
                <p>Ngày thi gần nhất: {$rs['lastest_date']}</p>
            </div>
            </div>
        </div>";
        }
    }
    if($flag!=0){
        $history.= "</div>";
    }
    $xtp->assign("history",$history);
    $xtp->parse("HIST");
    $acontent = $xtp->text("HIST");