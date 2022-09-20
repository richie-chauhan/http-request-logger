<?php
header("Content-Type: text/plain");
header("Access-Control-Allow-Origin: *");
echo file_get_contents( "/tmp/request.log" ); // get the contents, and echo it out.
?>
