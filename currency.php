<?php 
	
	// echo $id;
	 $p_code = $_SESSION['pay_code'];
	$cur = mysqli_query($conn,"SELECT * FROM `request` WHERE pay_code = '$p_code' AND user_id = '$id'  ");
           $curr = mysqli_num_rows($cur);
            if($curr > 0){
            	while ($row = mysqli_fetch_assoc($cur)) {
            		 $_SESSION['f_currs'] = $row['foreign_country'] ;
                     $_SESSION['l_currs'] = $row['local_country'] ;
                      $_SESSION['status'] = $row['status'] ;
                     $am_ngn = $row['amount_ngn'] ;
                    
                
                     $_SESSION['am_ngn'] = $am_ngn;
                     echo $_SESSION['f_currs'];
            	}
            }
	
?>