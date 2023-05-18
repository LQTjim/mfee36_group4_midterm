<?php
include './connectdb.php';

//insert lession price and sid
$sql_input = "SELECT cl.sid, cl.price FROM c_l_lession AS cl";
$stmt_input = $pdo->query($sql_input);
$rows_input = $stmt_input->fetchAll();
// print_r($rows_input);
// $a = count($rows_input) - 1; //抓陣列長度
// print_r($rows_input[$a]["sid"] . "</br>");
// print_r($rows_input[$a]["price"]);
// exit;


// insert member sid
$sql_member = "SELECT member.sid FROM member";
$stmt_member = $pdo->query($sql_member);
$rows_member = $stmt_member->fetchAll();
// print_r($rows_member);
// shuffle($rows_member); 
// print_r($rows_member[0]['sid']);


//insert member sid from order main
$sql_main = "SELECT member_sid,sid FROM `order_main`";
$stmt_main = $pdo->query($sql_main);
$rows_main = $stmt_main->fetchAll();
// print_r($rows_main);



// SELECT 
// 	od.*,om.sid,om.member_sid 
// FROM 
// 	`order_detail` as od 
// LEFT JOIN 
// 	order_main as om 
// ON
// 	om.sid = od.order_sid
