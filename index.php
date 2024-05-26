<?php
session_start();

//Create a session of username and logging in the user to the chat room
if(isset($_POST['username'])){
	$_SESSION['username']=$_POST['username'];
}

//Unset session and logging out user from the chat room
if(isset($_GET['logout'])){
	unset($_SESSION['username']);
	header('Location:index.php');
}

?>
<html>
<head>
	<title>BP-Chat</title>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300' rel='stylesheet' type='text/css'>

	<link href="../style/bootflat.github.io-master/css/site.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/style.css" />

	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
<!--The following script tag downloads a font from the Adobe Edge Web Fonts server for use within the web page. We recommend that you do not modify it.-->
<script>var __adobewebfontsappname__="dreamweaver"</script>
<script src="http://use.edgefonts.net/baumans:n4:default.js" type="text/javascript"></script>
<meta name="viewport" content="initial-scale=1, maximum-scale=1, user-scalable=no">
</head>
<body>

           <nav class="navbar navbar-default" role="navigation">
                  <div class="container-fluid">
                    
                    <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-3" style="">
                      <p class="navbar-text navbar-right"><a class="navbar-link" href=""><?php if(isset($_SESSION['username'])){
						echo"Signed in as <b>".$_SESSION['username']."</b><br><button href='?logout' type='button' class='btn btn-danger navbar-btn'>Logout</button>";
         
					  }else{
						  echo"
						  Please input a name to start chatting";
					  } ?></a></p>
                    </div>
                  </div>
                </nav>
          

<div>
<?php //Check if the user is logged in or not ?>
<?php if(isset($_SESSION['username'])) { ?>



            <div class="row example-popover">
<div id='result' style="background-color: ;">


              
            </div>
          </div>
        </div>
      
</div>
<div>
	<form method="post" onsubmit="return submitchat();">
	<input type='text' required name='chat' id='chatbox' autocomplete="off" placeholder="ENTER CHAT HERE" />
	<div class="btn-group-vertical"><button class="btn btn-primary btn-block" type='submit' name='send' id='send'  value='Send'>Send</button></div>
	<?php // <input type='button' name='clear' class='btn btn-clear' id='clear' value='X' title="Clear Chat" /> ?>
</form>
<script>
// Javascript function to submit new chat entered by user
function submitchat(){
		if($('#chat').val()=='' || $('#chatbox').val()==' ') return false;
		$.ajax({
			url:'chat.php',
			data:{chat:$('#chatbox').val(),ajaxsend:true},
			method:'post',
			success:function(data){
				$('#result').html(data); // Get the chat records and add it to result div
				$('#chatbox').val(''); //Clear chat box after successful submition
				document.getElementById('result').scrollTop=document.getElementById('result').scrollHeight; // Bring the scrollbar to bottom of the chat resultbox in case of long chatbox
			}
		})
		return false;
};

// Function to continously check the some has submitted any new chat
setInterval(function(){
	$.ajax({
			url:'chat.php',
			data:{ajaxget:true},
			method:'post',
			success:function(data){
				$('#result').html(data);
			}
	})
},10);

// Function to chat history
$(document).ready(function(){
	$('#clear').click(function(){
		if(!confirm('Are you sure you want to clear chat?'))
			return false;
		$.ajax({
			url:'chat.php',
			data:{username:"<?php echo $_SESSION['username'] ?>",ajaxclear:true},
			method:'post',
			success:function(data){
				$('#result').html(data);
			}
		})
	})
})
</script>
<?php } else { ?>
<div>
	<form method="post">
		<input type='text' required  placeholder="Enter your name" name='username' /><br><br>
		<button type='submit' value='START CHAT'>Start</button>
	</form>
</div>
<?php } ?>

</div>
</body>
</html>