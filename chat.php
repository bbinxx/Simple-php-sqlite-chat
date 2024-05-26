<?php
session_start();
$user = $_SESSION['username'];
//$msg = $_POST['chat'];
$d = new DateTime();
$time = $d->format('h:i A');
$date = $d->format('F,N Y');

if(isset($_POST['ajaxsend']) && $_POST['ajaxsend']==true){
 $pdo = new PDO('sqlite:Chatdb.db');
 $pdo->setAttribute(PDO::ATTR_ERRMODE,
 PDO::ERRMODE_EXCEPTION);
 $user_name = $_SESSION['username'];
 $msg = $_POST['chat'];
 $insert = "INSERT INTO Chat (user_name,msg,time,date)VALUES('$user_name','$msg','$time','$date')
 ";
 $pdo->query($insert);

}

try{
$db = new PDO('sqlite:Chatdb.db');
 $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$result = $db->query("SELECT `user_name`, `msg`,`time`,`date` FROM `Chat`");
 
 while ($row = $result->fetch()) {
 $user_name=$row['user_name'];
 $msg = $row['msg'];
 $time=$row['time'];
 $date=$row['date'];
 $style="";
 //$tm = "<div style='color: #FFFFFF;' align='.$arrow.'>".$time."</div>";
 if($user==$user_name){
	$style="right";
	$arrow="left";
}else{
	$style="left";
	$arrow="right";
}
echo "<div align=".$style." class='col-md-6'>
                <div class='popover ".$arrow."'>
                  <div class='arrow'></div>
                  <h3 class='popover-title'>".$user_name."</h3>
                  <div class='popover-content'>
                    <p style='color: #FFFFFF;'>".$msg."</p>
					<div style='color: #FFFFFF;' align=".$arrow.">".$time."</div>
					
                  </div>
                </div>
              </div><br><br>";
 } 
 }
 catch (PDOException $e) {
 echo "Under maintainance";
}

?>