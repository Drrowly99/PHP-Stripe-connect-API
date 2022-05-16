<?php
// NOTE THE LENNGTH OF THE USER ID AND PAY CODE IS REALLY IMPORTANT
// SHOULD ANYTHING BE WRONG WITH PAYMENTS,
// CHECK THE USER ID LENGTH AND PAYCODE. SOMETHING MUST HAVE CHANGED
session_start();
include 'database.php';
$cypher = "9112001" + 0; //9 11

	$sing = htmlspecialchars(mysqli_real_escape_string($conn, $_GET['sing']));
	$user = htmlspecialchars(mysqli_real_escape_string($conn, $_GET['cleanse']));
$leng = $user / $cypher;
$am_len = substr($leng, 3);
$id_len = substr($leng, 0, 2);
$pay_len = substr($leng, 2, -1);

// echo $am_len,"<br>";
// echo $id_len,"<br>";
// echo $pay_len,"<br><br><br>";

$id = substr($sing, 0, $id_len);
$_SESSION['pay_code'] = substr($sing, (-1 * $pay_len));
$_SESSION['am'] = substr($sing, $id_len, $am_len);
echo $id,"<br>";
// echo $pay_code,"<br>";
// echo $am,"<br>";
include 'currency.php';


$token =  bin2hex(openssl_random_pseudo_bytes(7));
$_SESSION['fee'] = $_SESSION['am'] * 0.015;
$_SESSION['total'] = ($_SESSION['fee'] + $_SESSION['am']) * 100;


$UPDATE1 = mysqli_query($conn,"UPDATE REQUEST SET status = 'pending' WHERE pay_code = '".$_SESSION['pay_code']."'");




	 header("Location: http://127.0.0.1:4242/checkout.php");

	