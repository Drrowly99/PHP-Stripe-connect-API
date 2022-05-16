<?php

$conn = mysqli_connect('localhost', 'root', '', 'cashout');
//check connnection	
		if(!$conn) {
			die("connection failed: ".mysqli_connect);
		}
		
?>