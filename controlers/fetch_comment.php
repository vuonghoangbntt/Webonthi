<?php

    //fetch_comment.php

    include("../libs/bootstrap.php");
    $id = $_POST['post_id'];
    $tid = $_POST['test_id'];
    $query = "
        SELECT C.comment_id,C.user_id,C.comment_date_post,C.comment_content,U.user_name,U.user_avatar FROM tblcomment C INNER JOIN tbluser U
        ON C.user_id=U.user_id
        WHERE comment_parent_id = '0' AND post_id ={$id} AND test_id = {$tid} 
        ORDER BY comment_id DESC";


    $result = $db->fetchAll($query);
    $output = '';
    foreach($result as $row)
    {
        if($row['user_avatar']!=''){
            $row['user_avatar'] = substr($row['user_avatar'],3);
        }else{
            $row['user_avatar'] = 'img_avatar2.png';
        }
        //  $output .= '
        //  <div class="card card-default">
        //  <div class="card-header">By <b>'.$row["user_name"].'</b> on <i>'.$row["comment_date_post"].'</i></div>
        //  <div class="card-body">'.$row["comment_content"].'</div>
        //  <div class="card-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
        //  </div>
        //  ';
         $output.="
         <div class='media border p-3'>
            <img src= {$row['user_avatar']} class='align-self-start mr-3' style='width: 60px;'>
            <div class='media-body'>
            <h4>{$row['user_name']} <small><i>Posted on {$row['comment_date_post']}</i></small></h4>
            <p>{$row['comment_content']}</p>
            <button type='button' class='btn btn-default reply' id={$row['comment_id']}>Reply</button>
            </div>
         </div>";
        $output .= get_reply_comment($db, $row["comment_id"]);
    }

    echo $output;

    function get_reply_comment($connect, $parent_id = 0, $marginleft = 0)
    {
        $query = "
        SELECT C.*,U.user_name,U.user_avatar FROM tblcomment C INNER JOIN tbluser U ON C.user_id=U.user_id WHERE comment_parent_id = '".$parent_id."'
        ";
        $output = '';
        $result = $connect->fetchAll($query);
        $count = count($result);
        if($parent_id == 0)
        {
            $marginleft = 0;
        }
        else
        {
            $marginleft = $marginleft + 48;
        }
        if($count > 0)
        {
            foreach($result as $row)
            {
                if($row['user_avatar']!=''){
                    $row['user_avatar'] = substr($row['user_avatar'],3);
                }else{
                    $row['user_avatar'] = 'img_avatar2.png';
                }
                // $output .= '
                // <div class="card card-default" style="margin-left:'.$marginleft.'px">
                //     <div class="card-header">By <b>'.$row["user_name"].'</b> on <i>'.$row["comment_date_post"].'</i></div>
                //     <div class="card-body">'.$row["comment_content"].'</div>
                //     <div class="card-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
                // </div>
                // ';
                $output.="
                <div class='media border p-3' style='margin-left: {$marginleft}px'>
                   <img src= {$row['user_avatar']} class='align-self-start mr-3' style='width: 60px;'>
                   <div class='media-body'>
                   <h4>{$row['user_name']} <small><i>Posted on {$row['comment_date_post']}</i></small></h4>
                   <p>{$row['comment_content']}</p>
                   <button type='button' class='btn btn-default reply' id={$row['comment_id']}>Reply</button>
                   </div>
                </div>";
                $output .= get_reply_comment($connect, $row["comment_id"], $marginleft);
            }
        }
        return $output;
    }

?>