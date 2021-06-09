<?php
    $xtp = new XTemplate("views/edit_answer.html");
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbltest WHERE test_id = $id";
    $id = $_GET['id'];
    $sql = "SELECT * FROM tbltest WHERE test_id = $id";
    $stmt = $db->execSQL($sql);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);
    $i = 0;
    $answer = '';
    while($i<$data['num_of_question']){
        $i++;
        $answer.="<tr>
        <td>{$i}</td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='1' required></label></td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='2'></label></td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='3'></label></td>
        <td><label class='radio-inline'><input type='radio' name='question_{$i}' value='4'></label></td>
      </tr>";
    }
    if($_POST){
        $i = 1;
        $r_data['active'] = 1;
        $r_data['answer'] = '';
        $value = $_POST['question_1'];
        $r_data['answer'].= "$value";
        while($i<$data['num_of_question']){
            $i++;
            $value = $_POST["question_{$i}"];
            $r_data['answer'].= ",$value";
        }
        if($db->update('tbltest',$r_data,"test_id={$id}")){
            $f->redir("?a=manage_file");
        }
        
    }
    $xtp->assign("Answer",$answer);
    $xtp->assign("title",$data['test_title']);
    $xtp->parse("ANSWER");
    $acontent = $xtp->text("ANSWER");