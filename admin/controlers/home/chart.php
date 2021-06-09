<?php
    error_reporting(4);
    $xtp = new XTemplate('views/home/chart.html');
    $sql = "SELECT P.pos_title
                ,P.pos_total_view
            FROM tblposts P
            WHERE 1=1
            ORDER BY P.pos_total_view DESC
            LIMIT 10";
    $rs  = $db->fetchAll1($sql);
    $ar  = array(
        array("y"=>$rs[0]["pos_total_view"],"label"=>"'{$rs[0]['pos_title']}'"),
        array("y"=>$rs[1]["pos_total_view"],"label"=>"'{$rs[1]['pos_title']}'"),
        array("y"=>$rs[2]["pos_total_view"],"label"=>"'{$rs[2]['pos_title']}'"),
        array("y"=>$rs[3]["pos_total_view"],"label"=>"'{$rs[3]['pos_title']}'"),
        array("y"=>$rs[4]["pos_total_view"],"label"=>"'{$rs[4]['pos_title']}'"),
        array("y"=>$rs[5]["pos_total_view"],"label"=>"'{$rs[5]['pos_title']}'"),
        array("y"=>$rs[6]["pos_total_view"],"label"=>"'{$rs[6]['pos_title']}'"),
        array("y"=>$rs[7]["pos_total_view"],"label"=>"'{$rs[7]['pos_title']}'"),
        array("y"=>$rs[8]["pos_total_view"],"label"=>"'{$rs[8]['pos_title']}'"),
        array("y"=>$rs[9]["pos_total_view"],"label"=>"'{$rs[9]['pos_title']}'")
    );
    $dataPoints = $ar;
    $dataPoints = json_encode($dataPoints, JSON_NUMERIC_CHECK);
    // print_r ($dataPoints);die;
    $xtp->assign("BJ","<script lang='text/javascript'>window.onload = function() {var chart = new CanvasJS.Chart('chartContainer', {animationEnabled: true,exportEnabled: true,theme: 'dark1',title: {text: 'Blog Sport Views'},axisY: {title: 'Total Views'},data: [{type: 'column',legendMarkerColor: 'white',legendText: 'Titles Blog Sport',dataPoints:{$dataPoints}}]});chart.render();}</script>");

    $xtp->parse("BS");
    $bs = $xtp->text("BS");
    $xtp->parse("CHAR");
    $acontent = $xtp->text("CHAR");