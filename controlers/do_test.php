<?php
    $xtp = new Xtemplate("views/do_test.html");
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbltest WHERE test_id={$id}";
    $stmt = $db->execSQL($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $i = 0;
    $answer = "";
    while($i<$data['num_of_question']){
        $i++;
        $answer.="<tr>
        <td>{$i}</td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='1'></label></td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='2'></label></td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='3'></label></td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='4'></label></td>
      </tr>";
    }
    if($_POST){
        $test_answer = explode(",",$data['answer']);
        $i = 0;
        $count = 0;
        while($i<$data['num_of_question']){
            $i+=1;
            if(!isset($_POST["question_{$i}"])) continue;
            if($test_answer[$i-1]==$_POST["question_{$i}"]){
                $count++;
            }
        }
        $score = $count*10/$data['num_of_question'];
        $score = number_format($score,1,'.','');
        //$db->delete("tblhistory", "user_id = {$_SESSION['login_user_id']} AND test_id = {$id}");
        $sql = "SELECT * FROM tblhistory H WHERE H.user_id = {$_SESSION['login_user_id']} AND H.test_id = {$id}";
        $stmt = $db->execSQL($sql);
        $rdata = $stmt->fetch(PDO::FETCH_ASSOC);
        if($stmt->rowCount()>0){
            $rdata['lastest_mark'] = $score;
            $rdata['highest_mark'] = max($rdata['highest_mark'],$score);
            $rdata['lastest_total_time'] = $_POST['minutes']." mins".$_POST['seconds']." seconds";
            if($score==$rdata){
                $rdata['highest_total_time'] = $rdata['lastest_total_time'];
            }
            $rdata['total_times']+= 1;
            $rdata['lastest_date'] = date("Y-m-d",time());
            $db->update('tblhistory',$rdata,"user_id = {$_SESSION['login_user_id']} AND test_id = {$id}");
        }else{
            $rdata['user_id'] = $_SESSION['login_user_id'];
            $rdata['test_id'] = $id;
            $rdata['total_times'] = 1;
            $rdata['highest_mark'] = $score;
            $rdata['lastest_mark'] = $score;
            $rdata['lastest_date'] = date("Y-m-d",time());
            $rdata['lastest_total_time'] = $_POST['minutes']."mins ".$_POST['seconds']." seconds";
            $rdata['highest_total_time'] = $rdata['lastest_total_time'];
            $db->insert('tblhistory',$rdata);
        }
        $f->redir("?a=view_result&id={$id}");
    }
    $xtp->assign("source_test",substr($data['test_source'],3));
    $xtp->assign('Answer',$answer);
    $xtp->parse("TEST");
    $acontent = $xtp->text("TEST");