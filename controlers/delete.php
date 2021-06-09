<?php
    $id = $_GET['id'];
    $sql = "DELETE FROM tbltest WHERE test_id = {$id}";
    $db->execSQL($sql);
    $f->redir("?a=manage_file");