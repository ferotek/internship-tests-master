<?php

require_once(__DIR__ . '/init.php');

$thread = new Thread();
$bannedWords = 'banana apple mongoose pear duck';

// Actual implementation below

//Checks for banned words
$success ="status”: 200," ;
$threadsarray = $thread->getRecentThreads(3, False);

$bannedArray = explode (" ", $bannedWords);

//Prints values 

foreach($threadsarray as $thread){
	$threadlist = array();
	$threadlist['status'] = 200;
	foreach($thread as $key => $value){
		$replace = str_replace($bannedArray, '****', $value);
		$threadlist[$key] = $value;
		


	}
	//echo $thread->{'message_html'};
	//$threadlist['message_html'] = $thread->{'message_html'};
	//echo json_encode($success);
	//echo json_encode($thread);
	echo json_encode($threadlist);
	echo "\n";
}