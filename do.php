<?php
session_start();
include 'database.php';
// FIRSTLY UPDATE REQUEST,CHANGE THE STATUS TO COMPLETED
// SECONDLY INSERT INTO STRIPE
 date_default_timezone_set('Africa/Lagos');



if (isset($_POST['e'])) {
	$e = $_POST['e'];
	function1($_POST['e']);
	# code...
}

function function1($e){
	include 'database.php';
$pay_code = $_SESSION['pay_code'];
// $pay_code ='791-WIFOx' $_SESSION['pay_code'];
// $pay_code ='791-WIFOx';
// echo $pay_code;
$UPDATE1 = mysqli_query($conn,"UPDATE request SET status = 'completed' WHERE pay_code = '".$pay_code."'");
$loga = mysqli_query($conn,"SELECT * FROM `request` WHERE pay_code = '$pay_code'  ");
           $logac = mysqli_num_rows($loga);
            if($logac > 0){
            	while ($row = mysqli_fetch_assoc($loga)) {
                      $request_id = $row['request_id'] ;
                      $user_id = $row['user_id'] ;
                      $foreign_country = $row['foreign_country'] ;
                      $local_country = $row['local_country'] ;
                      $amount = $row['amount'] ;
                      $amount_ngn = $row['amount_ngn'] ;
                      $status = $row['status'] ;
                      $rate = $row['rate'] ;
                      $fee = $row['fee'] ;
                      $real_pay_code = $row['pay_code'] ;
                      $_SESSION['link'] = $row['link_code'] ;
$check = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM `stripe` WHERE pay_code = '$pay_code'  "));
if ($check > 0) {
	echo "alreade in table <br>";
}else{

	$sender_id = bin2hex(openssl_random_pseudo_bytes(5));
		$stripe_date = date('Y-m-d H:s:i');

		$insert = mysqli_query($conn,"INSERT INTO `stripe` (receiver_id, pay_code, sender_id, amount, rate, status, amount_ngn, stripe_date, fee, foreign_country, local_country, stripe_id) VALUES ('$user_id', '$real_pay_code', '$sender_id', '$amount', '$rate', '$status', '$amount_ngn', '$stripe_date', '$fee', '$foreign_country', '$local_country', '$request_id')");
		          if ($insert) {
		          	//UPDATE THE RECEIVERS BALANCE
		          	$Update_receiver = mysqli_query($conn,"UPDATE user SET balance = `balance` + '$amount' WHERE user_id = '$user_id'");
		          	if ($Update_receiver) {
		          		echo  $_SESSION['link'];
		          		 // header("Location: http://127.0.0.1:4242/checkout.php");
		          	}
		          }
		          else{
		          echo $insert;
		          }
}
                  
                }
				
            }
              # check for password match
            
 // $sql = "INSERT INTO stripe (receiver_id, pay_code, sender_id, amount, rate, status, stripe_date, fee, stripe_id) VALUES ("..") "
}