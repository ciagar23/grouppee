<?php
$room = (isset($_GET['room']) && $_GET['room'] != '') ? $_GET['room'] : '';

switch ($room) {
		
	case '1' :
		$yourRoom 	= 'Actinbox';	
		break;
		
	case '2' :
		$yourRoom 	= 'Overdose';	
		break;
		
	case '3' :
		$yourRoom 	= 'Publiq';	
		break;
		
	case '4' :
		$yourRoom 	= 'Trips';	
		break;
		
	case '5' :
		$yourRoom 	= 'Lovelife';	
		break;
			
		
	default :
		$room = 1;
		$yourRoom 	= 'Actinbox';
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Groupee</title>

<link rel="stylesheet" type="text/css" href="js/jScrollPane/jScrollPane.css" />
<link rel="stylesheet" type="text/css" href="css/page.css" />
<link rel="stylesheet" type="text/css" href="css/chat.css" />

</head>

<body>
<input type="hidden" id="room" value="<?=$room?>">
<center><img src="img/logo.png"></center>
<div id="chatContainer">
<h2 align=center>Choose your room</h2> <br>
<a href="?room=1">Actinbox</a> | 
<a href="?room=2">Overdose</a> | 
<a href="?room=3">Publiq</a> | 
<a href="?room=4">Trips</a> | 
<a href="?room=5">Lovelife</a> 


    <div id="chatTopBar" class="rounded"></div>
    <div id="chatLineHolder"></div>
    
	
	Room: <?=$yourRoom?>
    <div id="chatUsers" class="rounded"></div>
    <div id="chatBottomBar" class="rounded">

    	<div class="tip"></div>
        
        <form id="loginForm" method="post" action="">
            <input id="name" name="name" class="rounded" maxlength="16" />
            <input id="password" name="password" class="rounded" />
            <input type="submit" class="blueButton" value="Login" />
        </form>
        
        <form id="submitForm" method="post" action="">
            <input id="chatText" name="chatText" class="rounded" maxlength="255" />
			<input type="hidden" id="roomId" name="roomId" value="<?=$room?>">
            <input type="submit" class="blueButton" value="Submit" />
        </form>
        
    </div>
    
</div>


<script src="js/jScrollPane/jquery.min.js"></script>
<script src="js/jScrollPane/jquery.mousewheel.js"></script>
<script src="js/jScrollPane/jScrollPane.min.js"></script>
<script src="js/script.js"></script>
</body>
</html>
