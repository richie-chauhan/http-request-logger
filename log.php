<?php

$timeNow = time();
$timeNow = gmdate("Y-m-d\TH:i:s\Z", $timeNow);

$headers = apache_request_headers();

$param = "\r\n===========================================================================================================================\r\n";
$param = $param . $_SERVER['REQUEST_METHOD'] . " URL: " . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "\r\n";
$param = $param . "===========================================================================================================================\r\n";
$param = $param . ":: Headers :: \r\n";

foreach ($headers as $header => $value) {
 $param = $param . "$header: $value \r\n";
}

echo 'User IP Address - '.$_SERVER['REMOTE_ADDR'];


switch($_SERVER['REQUEST_METHOD'])
{
    case 'GET':
        foreach($_GET as $key => $value){
            $param =  $param . "" . $key . ": " . $value . " | "; // "\r\n";
        }
        break;
    //case 'POST': $param = $_POST; break;
    case 'POST':
        //https://stackoverflow.com/questions/8893574/php-php-input-vs-post 
        $contentType = $_SERVER["CONTENT_TYPE"];
	$isFormData = strpos($contentType, "form"); //!!!quite lax - should only look for application/x-www-form-urlencoded OR multipart/form-data
        if($isFormData > 0)
        {
 		$param = $param . " Data starts from next line $contentType:\r\n";
		foreach ($_POST as $_POST => $postVal) {
		  $param = $param . "******************** NEXT ********************\r\n";
		  $param = $param . "$_POST: $postVal \r\n";
		}

		//Should also look for $_FILE and print it out
        }
	else 
	{
        	$param = $param . " Data starts from next line $contentType:\r\n" . file_get_contents("php://input");
	}
        break;
    default:
        $param = $param . " " . $_REQUEST . " Details are not logged yet!!!!";
        break;
}

//foreach($_GET as $key => $value){
//  $param =  $param . "" . $key . ": " . $value . " | "; // "\r\n";
//}

$fp = fopen('/tmp/request.log', 'a');
fwrite($fp, $timeNow);
//fwrite($fp, "\r\n");
fwrite($fp, " | ");
//fwrite($fp, $param);
fwrite($fp, print_r($param, true));
fwrite($fp, "\r\n");
fclose($fp);
echo "Your request has been logged";
?>
