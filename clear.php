<?php
	//open file to write
	$fp = fopen("/tmp/request.log", "w");
	// clear content to 0 bits
	ftruncate($fp, 0);
	//close file
	fclose($fp);
?>
