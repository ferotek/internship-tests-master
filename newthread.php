
<!-- David Guo davidguo94@gmail.com -->
<html>  
<body>
<!-- Modified to add html submission -->
<form action="newthread.php" method="post">
Title: <input type="text" name="title"><br>
Message: <input type="text" name="message"><br>
<input type="submit">
</form>

</body>
</html>


<?php

require_once(__DIR__ . '/init.php');



$title = $argv[1];
$message = $argv[2];


   


$thread = new Thread();


// Actual implementation below

/*if ($argc != 3)
{
    throw new Exception('Invalid number of arguments provided');
}*/

//Gets values from HTML form

$title = $_POST["title"];
$message = $_POST["message"];


//added validations 


$error1="status”: 432, “error”: “title field is too short";

$error2="status”: 432, “error”: title field is too long";


$error3="status”: 432, “error”: message field is too short";

$error4="status”: 432, “error”: message field is too long";

$error5="status”: 200,";







if (strlen($title) < 3 ) {
	$myJSON = json_encode($error1);
    throw new Exception($myJSON);
}

else if(strlen($title) > 32){
	$myJSON = json_encode($error3);
    throw new Exception($myJSON);

}


else if (strlen($message) < 3 ) {
	$myJSON = json_encode($error3);
    throw new Exception($myJSON);
}

else if(strlen($title) > 52){
	$myJSON = json_encode($error4);
    throw new Exception($myJSON);

}

else {
	$thread->newThread($title, $message, True, time());

}

