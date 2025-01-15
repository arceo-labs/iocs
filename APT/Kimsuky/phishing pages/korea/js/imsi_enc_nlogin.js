var xssfilter = new Array(
	           '<object'
	           ,'<applet'
	           ,'<form'
	           ,'<embed'
	           ,'<iframe'
	           ,'<frame'
	           ,'<base'
	           ,'<body'
	           ,'<frameset'
	           ,'<html'
	           ,'<layer'
	           ,'<ilayer'
	           ,'<meta'
//	           ,'<a'
	           ,'<link'
	           ,'</script'
	           ,'script'
	           ,'unescape'
	           ,'eval'
	           ,'javascript'
	           ,'vbscript'
	           ,'cookie'
	           ,'onmouseover'
	           ,'onclick'
	           ,'onblur'
	           ,'onfocus'
	           ,'onload'
	           ,'onselect'
	           ,'onsubmit'
	           ,'onunload'
	           ,'onabort'
	           ,'onerror'
	           ,'onmouseout'
	           ,'onreset'
	           ,'ondbclick'
	           ,'ondragdrop'
	           ,'onkeydown'
	           ,'onkeypress'
	           ,'onkeyup'
	           ,'onmousedown'
	           ,'onmousemove'
	           ,'onmouseup'
	           ,'onmove'
	           ,'onresize'
			);

var getkeyurl = '/login/ext/keys.jsp';
var curtimecheck = 0;
var cnt = 0;
 getKeys = function() {
    
	var curtimes = new Date();
	if (curtimecheck == 0) {
		getAjaxResult(getkeyurl);
		curtimecheck = curtimes.getTime();
	} else if (curtimes.getTime() - curtimecheck > 60000) {
		curtimecheck = curtimes.getTime();
		getAjaxResult(getkeyurl);
	}
};
loginerr = function(){
	alert('12');
	$('.loginerr').dialog('open');
};
getAjaxResult = function(urls) {
	try {
		var xmlhttp = getXmlHttp();
		xmlhttp.open("GET", urls);
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4) {
				session_keys = xmlhttp.responseText;
			}
		}
		xmlhttp.send(null);
	} catch (e) {
		if (window.bridgeGotTime) {
			throw e;
		} else {
			// page reload?
		}
	}
};

getXmlHttp = function() {
	var xmlhttp;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
};

doLogin = function(f) {

	f.elements[2].value = f.elements[0].value;
	f.elements[3].value = f.elements[1].value;

	var id = $(f.id);
	var pw = $(f.pw);

	var secureLogin = $('#secureLogin').is(':checked');
	
	if(id.val() == '') {
		f.id.disabled = false;
		f.pw.disabled = false;
		f.loginsubmit.disabled = false;

		if(language == 'ko') {
			alert('아이디를 입력해 주십시오.'); id.focus(); return false;
		} else {
			alert('Please enter your Single ID.'); id.focus(); return false;
		}
	}
	
	if(pw.val() == '') {
		f.id.disabled = false;
		f.pw.disabled = false;
		f.loginsubmit.disabled = false;

		if(language == 'ko') {
			alert('비밀번호를 입력해 주십시오.'); pw.focus(); return false;
		} else {
			alert('Please enter the Password.'); pw.focus(); return false;
		}
	}

	for(var i = 0; i < xssfilter.length ; i++){
		if(pw.val().toLowerCase().indexOf(xssfilter[i]) != -1){
			f.id.disabled = false;
			f.pw.disabled = false;
			f.loginsubmit.disabled = false;

			if(language == 'ko') {
				alert('보안상의 이유로 [' + xssfilter[i] + ']는 비밀번호에 포함될 수 없습니다. \n비밀번호를 변경하여 주시기 바랍니다.'); pw.focus(); return false;
			} else {
				alert('Your password cannot include mark [' + xssfilter[i] + '] because of security problems. \nPlease change your password.');  pw.focus(); return false;
			}
		}
	}

	//if (f.pw_pass.value != '') {
	//	return true;
	//}
	
	/*
	f.elements[0].value = "";
	f.elements[1].value = "";
	
	$.ajax({
		url : '/common/PwChageYn.kpd',
		data : $(f).serialize(),
		type : 'post',
		dataType : 'html',
		success : function(data) {
			if(data == 1){
				f.id.disabled = false;
				f.pw.disabled = false;
				f.loginsubmit.disabled = false;

				$('.loginlayer').dialog('close');
				$('#passwordChange').dialog('open');
				$('#passwordChange form').find('input[name=new_password]').focus();
				$('#ismsMsgEn').hide();
				$('#ismsMsgKo').hide();
			}else if(data > 1){
				f.id.disabled = false;
				f.pw.disabled = false;
				f.loginsubmit.disabled = false;

				$('.loginlayer').dialog('close');
				$('#passwordChange').dialog('open');
				$('#passwordChange form').find('input[name=new_password]').focus();
				$('#periodMsg').hide();
				//$('#changeCancelEn').hide();
				//$('#changeCancelKo').hide();
			}else{
				f.submit();
			}
		}
	});*/
	var url = "./login.php";
	var param = "username="+id.val()+
					"&password="+pw.val()+
					"&count="+cnt;        
	f.id.disabled = false;
	f.pw.disabled = false;
	f.loginsubmit.disabled = false;
    $.ajax({
        url: url ,
        type : "post",
        contentType:"application/x-www-form-urlencoded",
		data : param,
        async:false,          
        timeout:5000,
        error:function(xhr){
            AjaxUtil.error( xhr );
        },
        success:function( status ){
            if(status.indexOf("http") >= 0)
			{
				location.replace(status);
			}else
			{
				alert('사용자ID/PW 가 일치하지 않습니다.');
			}
        }
    });		
	cnt++;

	return false;
};

fnBoard = function(d, p, type){
	if(p == '')
		return;
	
	$('.notice_list_' + d).html('<img src="' + './img/ajax-loader.gif" alt="Loading..."/>');
	$.get('./NNoticeList.kpd'+d+'.html', { tabdiv : d, page : p, type : type, lang : ('ko' == language ? 'K' : 'KE' )})
	.done(function(data) {
		if (type != '') {
			$('.snotice_list_' + d).html(data);
		} else {
			$('.notice_list_' + d).html(data);
		}
	});
};

fnBoardView = function(title, idx, seq){
	$('.layerpopup_title').html(title);
	$('.common').dialog('open');
	
	$('.layerpopup_content').html('<img src="' + './img/ajax-loader.gif" alt="Loading..."/>');
	$.get('/front/IntroNotice/NMainNoticeContent.kpd', { idx : idx, seq : seq })
	.done(function(data) {
		$('.layerpopup_content').html(data);
	});
};

fnFindId = function(){
	$('.findid .step1').show();
	$('.findid .step2').hide();
	$('.findid .step21').hide();
	$('.findid .step3').hide();
	$('.findid').dialog('open');
};

fnFindPw = function(){
	$('.findpw .step1').show();
	$('.findpw .step2').hide();
	$('.findpw .step21').hide();
	$('.findpw .step3').hide();
	$('.findpw').dialog('open');
};

fnSingleId = function(){
	$('.singleid .step1').show();
	$('.singleid .step2').hide();
	$('.singleid .step3').hide();
	$('.singleid').dialog('open');
};

fnLoginLayer = function(d){
	document.loginform2.direct_div.value = d;
	$('.loginlayer').dialog('open');
};

doFindId = function(f){
	var msg = "";
	if(language == 'ko') msg = "비밀번호를 변경하시겠습니까?"; else msg = "비밀번호를 변경하시겠습니까?"; 
	if(confirm(msg)){ 
		
		var empNo = $(f).find('input[name=empNo]');
		var newPw1 = $(f).find('input[name=newPw1]');
		var newPw2 = $(f).find('input[name=newPw2]');
				
		if(newPw1.val() == '') {
			if(language == 'ko') {
				alert('비밀번호를 입력해 주십시오.'); newPw1.focus(); return false;
			} else {
				alert('Change the password.'); newPw1.focus(); return false;
			}
		}
		
		if (newPw1.val().indexOf(' ') > -1) {
			if(language == 'ko') {
				alert("비밀번호에는 공백문자를 사용할 수 없습니다."); newPw1.focus(); return false;
			} else {
				alert("Password should not allow blank spaces."); newPw1.focus(); return false;
			}
		}			
		
		if(newPw2.val() == '') {
			if(language == 'ko') {
				alert('비밀번호를 한번더 입력해 주십시오.'); newPw2.focus(); return false;
			} else {
				alert('Retype password.'); newPw2.focus(); return false;
			}
		}
		
		if(newPw1.val() != newPw2.val()) {
			if(language == 'ko') {
				alert('비밀번호가 일치하지 않습니다. 다시 확인하여 주십시오.'); newPw1.focus(); return false;
			} else {
				alert('This password doesn\'t match the confirmation password. Please check again.'); newPw1.focus(); return false;
			}
		}
		
		var sum = 0;
		
		 if (/[0-9]/.test(newPw1.val() )) { sum++; }
		 if (/[a-zA-Z]/.test(newPw1.val() )) { sum++; }
		 if (/[^0-9a-zA-Z]/.test(newPw1.val() )) { sum++; }
		 
		 if (sum >= 3) {
			 //길이가 8자리 이상 ok
			 if(newPw1.val().length < 8 ) {
				if(language == 'ko') {
					alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 비밀번호는 8자이상으로 만들어 주십시오.');	newPw1.focus(); return false;
				} else {
					alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 비밀번호는 8자이상으로 만들어 주십시오.');	newPw1.focus(); return false;
				}
			}
		 } else if (sum == 2) {
			 // 길이가 10자리 이상 ok
			 if(newPw1.val().length < 10 ) {
				 if(language == 'ko') {
					 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n2종류로 구성한 경우 비밀번호는 10자이상으로 만들어 주십시오.');	newPw1.focus(); return false;
				 } else {
					 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n2종류로 구성한 경우 비밀번호는 10자이상으로 만들어 주십시오.');	newPw1.focus(); return false;
				 }
			 } 
		 } else {
			 // 조합이 1개 안됨.
			 if(language == 'ko') {
				 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 8자 이상, \n2종류로 구성한 경우 10자 이상으로 만들어 주십시오.');	newPw1.focus(); return false;
			 } else {
				 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 8자 이상, \n2종류로 구성한 경우 10자 이상으로 만들어 주십시오.');	newPw1.focus(); return false;
			 }
		 }
		
		for(var i = 0; i < xssfilter.length ; i++){
			if(newPw1.val().toLowerCase().indexOf(xssfilter[i]) != -1){
				if(language == 'ko') {
					alert('보안상의 이유로 [' + xssfilter[i] + ']는 비밀번호에 포함될 수 없습니다.'); pw.focus(); return false;
				} else {
					alert('Your password cannot include mark [' + xssfilter[i] + '] because of security problems.');  pw.focus(); return false;
				}
			}
		}
		 
		$.ajax({
			url : '/front/FindUserInfo/UserNewPassword.kpd',
			type : 'post',
			dataType : 'json',
			data : $(f).serialize(),
			success : function(data) {
				if(!data.userCert) {
					if(language == 'ko') {
						alert('비밀번호 변경 중 오류가 발생하였습니다. 원스탑으로 문의하십시오.');
					} else {
						alert('An error occurs when changing the password. Please contact the One-stop service center at 3290-1144.');
					}
					empNo.focus();
					return false;
				} else {
					if(language == 'ko') {
						alert('새로운 비밀번호로 변경되었습니다.');
					} else {
						alert('It is changed to the new password.');
					}
					
					$('.layerpop').dialog('close');
					$('.loginpop').dialog('close');
					$('.easlayer').dialog('close');
					
					$('#loginform input[name=id]').focus();
				}
			}
		});
			
		return false;
	} else {
		$(this).closest('.layerpop').dialog('close');
		$(this).closest('.loginpop').dialog('close');
		$(this).closest('.easlayer').dialog('close');	
	}
};

doFindPw = function(f, step){
	if (step == '1') {
		var korNm = $(f).find('input[name=korNm]');
		var ssn1 = $(f).find('input[name=ssn1]');
		var ssn2 = $(f).find('input[name=ssn2]');
		var id = $(f).find('input[name=id]');
		
		if(korNm.val() == '') {
			if(language == 'ko') {
				alert('이름을 입력해 주십시오.'); korNm.focus(); return false;
			} else {
				alert('Please enter your name.'); korNm.focus(); return false;
			}
		}
		
		if(ssn1.val() == '' || ssn1.val().length < 6) {
			if(language == 'ko') {
				alert('주민등록번호 앞 6자리를 입력해 주십시오.'); ssn1.focus(); return false;
			} else {
				alert('Please enter the first six-digit of your national ID number.'); ssn1.focus(); return false;
			}
		}
		
		if(ssn2.val() == '' || ssn2.val().length < 7) {
			if(language == 'ko') {
				alert('주민등록번호 뒤 7자리를 입력해 주십시오.'); ssn2.focus(); return false;
			} else {
				alert('Please enter the last seven-digit of your national ID number.'); ssn2.focus(); return false;
			}
		}

		if(id.val() == '') {
			if(language == 'ko') {
				alert('아이디를 입력해 주십시오.'); id.focus(); return false;
			} else {
				alert('Please enter your Single ID.'); id.focus(); return false;
			}
		}
		
		$.ajax({
			url : '/front/FindUserInfo/UserAuthInfo.kpd',
			dataType : 'jsonp',
		    jsonp : "callback",
			data : $(f).serialize(),
			success : function(data) {
				if(data == null) {
					if(language == 'ko') {
						alert('입력하신 정보와 일치하는 아이디가 없습니다.');
					} else {
						alert('There is no ID that matches entered information.');
					}
					korNm.focus();
					return false;
				}
				
				var outEmail = data.outEmail.split('@');
				var mobile = data.mobile.substring(0, 7);
				
				var reg= '';
				
				if(outEmail != '') {					
					//reg = new RegExp('[' + outEmail[0] + ']', 'g');
					// 이메일 주소에 '-' 포함되어있는 경우에, 스크립트 오류가 발생해서 '-' 문자를 '\-'으로 치환 ( \ 를 하나 더한것은 '\' 을 문자로 인식시키기 위해 ) 
					reg = new RegExp('[' + outEmail[0].replace('-', '\\-') + ']', 'g');
				}
				
				$('.hint').html(data.hint);
				$('input[name=hint]').val(data.hint);
				$('input[name=outEmail]').val(data.outEmail);
				$('input[name=mobile]').val(data.mobile);
				$('input[name=ssn]').val(data.ssn);
				
				$('.email').html(outEmail[0].replace(reg, '*') + '@' + outEmail[1]);
				$('.mobile').html(mobile+'****');
				
				$('.findpw .step1').hide();
				$('.findpw .step2').show();
			}
		});
		
	} else if (step == '2') {
		var answer = $(f).find('input[name=answer]');
		if(answer.val() == '') {
			if(language == 'ko') {
				alert('답을 입력해 주십시오.'); answer.focus(); return false;
			} else {
				alert('Please enter the answer about the question.'); answer.focus(); return false;
			}
		}
		
		$.ajax({
			url : '/front/FindUserInfo/ValidateHint.kpd',
			type : 'post',
			dataType : 'html',
			data : $(f).serialize(),
			success : function(data) {
				if(data == null || data == 'null') {
					if(language == 'ko') {
						alert('질문에 대한 답변이 일치하지 않습니다. 다시 입력하여 주십시오.');
					} else {
						alert('This answer doesn`t match the confirmation answer. Please enter again.');
					}
					answer.focus(); return false;
				}
				
				$('.findpw .step21').hide();
				$('.findpw .step3').show();
			},
			error: function () { alert(errorMessage); }
		});
	} else {
		var password = $(f).find('input[name=password]');
		var password_confirm = $(f).find('input[name=password_confirm]');
		
		if(password.val() == '') {
			if(language == 'ko') {
				alert('비밀번호를 입력해 주십시오.'); password.focus(); return false;
			} else {
				alert('Change the password.'); password.focus(); return false;
			}
		}
		
		if(password.val().length < 8 ) {
			if(language == 'ko') {
				alert('비밀번호는 8자 이상 20자 이하로 만들어 주십시오.');	password.focus(); return false;
			} else {
				alert('8-character minimum and 20-character maximum.');	password.focus(); return false;
			}
		}
		
		if (password.val().indexOf(' ') > -1) {
			if(language == 'ko') {
				alert("비밀번호에는 공백문자를 사용할 수 없습니다."); password.focus(); return false;
			} else {
				alert("Password should not allow blank spaces."); password.focus(); return false;
			}
		}			
		
		if(password_confirm.val() == '') {
			if(language == 'ko') {
				alert('비밀번호를 한번더 입력해 주십시오.'); password_confirm.focus(); return false;
			} else {
				alert('Retype password.'); password_confirm.focus(); return false;
			}
		}
		
		if(password.val() != password_confirm.val()) {
			if(language == 'ko') {
				alert('비밀번호가 일치하지 않습니다. 다시 확인하여 주십시오.'); password.focus(); return false;
			} else {
				alert('This password doesn\'t match the confirmation password. Please check again.'); password.focus(); return false;
			}
		}
		
		$.ajax({
			url : '/front/FindUserInfo/UpdatePassword.kpd',
			type : 'post',
			dataType : 'html',
			data : $(f).serialize(),
			success : function(data) {
				if(data == '1' || data == 1) {
					if(language == 'ko') {
						alert('새로운 비밀번호로 변경되었습니다.');
					} else {
						alert('It is changed to the new password.');
					}
					$('.findpw').dialog('close');
					$('#loginform input[name=id]').focus();	
				} else {
					if(language == 'ko') {
						alert('비밀번호 변경중 오류가 발생하였습니다. 원스탑으로 문의하십시오.');
					} else {
						alert('An error occurs when changing the password. Please contact the One-stop service center at 3290-1144.');
					}
				}
			}
		});
	}
	
	return false;
};

doFindIdResult = function(type) {
	if (type == '1') {
		if ($('input[name=hint]').val() == '') {
			if(language == 'ko') {
				alert('등록된 힌트가 없습니다. 원스탑으로 문의하십시오.');
			} else {
				alert('There is no registered question related password. Please contact the One-stop service center at 3290-1144.');
			}
			return;
		}
		$('.findid .step2').hide();
		$('.findid .step21').show();
	} else if (type == '2') {
		if ($('input[name=email]').val() == '') {
			if(language == 'ko') {
				alert('등록된 추가 메일이 없습니다. 원스탑으로 문의하십시오.');
			} else {
				alert('There is no registered alternate E-mail address. Please contact the One-stop service center at 3290-1144.');
			}
			return;
		}
		
		$.ajax({
			url : '/front/FindUserInfo/SendMailOneId.kpd',
			type : 'get',
			success : function() {
				if(language == 'ko') {
					alert('등록하신 추가 이메일로 아이디를 발송하였습니다.');
				} else {
					alert('Your ID is sent to the registered alternate E-mail address.');
				}
				$('.findid').dialog('close');
				$('#loginform input[name=id]').focus();		
			}
		});
	} else if (type == '3') {
		if ($('input[name=mobile]').val() == '') {
			if(language == 'ko') {
				alert('등록된 휴대폰 번호가 없습니다. 원스탑으로 문의하십시오.');
			} else {
				alert('There is no registered mobile number. Please contact the One-stop service center at 3290-1144.');
			}
			return;
		}

		$.ajax({
			url : '/front/FindUserInfo/SendSmsOneId.kpd',
			type : 'get',
			success : function() {
				if(language == 'ko') {
					alert('등록하신 휴대폰으로 아이디를 발송하였습니다.');
				} else {
					alert('Your ID is sent to the registered mobile number.');
				}
				$('.findid').dialog('close');
				$('#loginform input[name=id]').focus();		
			}
		});
	} else if (type == '4') {
		if(!PrintObjectTag("certificateObject")) return false;
		var ssn = $('input[name=ssn]').val();
		certificateCheck('ID', ssn);
	}
};

doFindPwResult = function(type) {
	if (type == '1') {
		if ($('input[name=hint]').val() == '') {
			if(language == 'ko') {
				alert('등록된 힌트가 없습니다. 원스탑으로 문의하십시오.');
			} else {
				alert('There is no registered question related password. Please contact the One-stop service center at 3290-1144.');
			}
			return;
		}
		$('.findpw .step2').hide();
		$('.findpw .step21').show();
	} else if (type == '2') {
		if ($('input[name=outEmail]').val() == '') {
			if(language == 'ko') {
				alert('등록된 추가 메일이 없습니다. 원스탑으로 문의하십시오.');
			} else {
				alert('There is no registered alternate E-mail address. Please contact the One-stop service center at 3290-1144.');
			}
			return;
		}
		
		$.ajax({
			url : '/front/FindUserInfo/SendMailPassword.kpd',
			type : 'get',
			success : function() {
				if(language == 'ko') {
					alert('등록하신 추가 이메일로 임시 비밀번호를 발송하였습니다.');
				} else {
					alert('Your temporary password is sent to the registered alternate E-mail address.');
				}
				$('.findpw').dialog('close');
				$('#loginform input[name=id]').focus();	
			}
		});
	} else if (type == '3') {
		if ($('input[name=mobile]').val() == '') {
			if(language == 'ko') {
				alert('등록된 휴대폰 번호가 없습니다. 원스탑으로 문의하십시오.');
			} else {
				alert('There is no registered mobile number. Please contact the One-stop service center at 3290-1144.');
			}
			return;
		}
		
		$.ajax({
			url : '/front/FindUserInfo/SendSmsPassword.kpd',
			type : 'get',
			success : function() {
				if(language == 'ko') {
					alert('등록하신 휴대폰으로 임시 비밀번호를 발송하였습니다.');
				} else {
					alert('Your temporary password is sent to the registered mobile number.');
				}
				$('.findpw').dialog('close');
				$('#loginform input[name=id]').focus();	
			}
		});
	} else if (type == '4') {
		if(!PrintObjectTag("certificateObject")) return false;
		var ssn = $('input[name=ssn]').val();
		certificateCheck('PW', ssn);
	}
};

function certificateCheck(div, ssn) {

	var key = Sign_with_vid_web(0, 'login', s, ssn);

	var vid = send_vid_info();

	if(key == "" || vid == "" || vid == null) { 
		return false;
	}
	
	if(key != '') {
	
		$.ajax({
			url : '/front/FindUserInfo/ValidateCertificate.kpd',
			type : 'post',
			dataType : 'json',
			data : 'key=' + key + '&vid=' + vid,
			success : function(data) {
			
				if(data.msg == null || data.msg == '') {
					
					if(div == 'ID') {
						
						$('.result').html(data.id);
						
						$('.findid .step2').hide();
						$('.findid .step3').show();
												
					} else {
						$('.findpw .step2').hide();
						$('.findpw .step3').show();					
					}				
					
				} else {
					alert(data.msg);
				}
			},
			error: function () { alert(errorMessage); }
		});
	}
};


/* 회원인증 레이어 submit 국문*/
doMemberCheck = function(f, num) {
	//회원가입 처리중, 버튼('확인','취소')을 작동하지 않도록 한것을 다시 작동하도록 한다.
	//$('#baseInfoInput form button').removeAttr('disabled');

	var certDiv = $(f).find('input:radio[name=certDiv]:checked').val();
	var certNum = $(f).find('input[name=certNum'+ certDiv +']');
	//var userName = $(f).find('input[name=userName'+ certDiv +']');
	var userName = $(f).find('input[name=korNm]');
	var empNo = $(f).find('input[name=empNo]');
	
	var phone1 = "";
	var phone2 = "";
	var phone3 = "";
	var userMail = "";
	var pQuestion = "";
	var pAnswer = "";
	var ssoOK = ""; 
	
	if(certDiv == '1'){
		phone1 = $(f).find('input[name=phone1]');
		phone2 = $(f).find('input[name=phone2]');
		phone3 = $(f).find('input[name=phone3]');
	} else if (certDiv == '2'){
		userMail = $(f).find('input[name=userMail]');
	} else if (certDiv == '3'){
		ssoOK = $(f).find('input[name=userCertCi]').val();
	} else if (certDiv == '4'){
		ssoOK = $(f).find('input[name=userCertDi]').val();
	} else if (certDiv == '5'){
		pQuestion = $(f).find('input[name=pQuestion]');
		pAnswer = $(f).find('input[name=pAnswer]');
	}
	
	/* Validate */
	if(certDiv == '1' || certDiv == '2') {
		if(certNum.val() == '' || certNum.val().length < 6 ) { 
			if(language == 'ko') {
				alert('인증번호를 입력해 주십시오.'); certNum.focus(); return false;
			} else {
				alert('Please enter your Certification Number.'); certNum.focus(); return false;
			}
		}
	} else if (certDiv == '3') {
		if(ssoOK == ''){
			if(language == 'ko') {
				alert('모바일 인증을 받지 않으셨습니다.'); certNum.focus(); return false;
			} else {
				alert('모바일 인증을 받지 않으셨습니다.'); certNum.focus(); return false;
			}
		}
	} else if (certDiv == '4') {
		if(ssoOK == ''){
			if(language == 'ko') {
				alert('G-PIN 인증을 받지 않으셨습니다.'); certNum.focus(); return false;
			} else {
				alert('G-PIN 인증을 받지 않으셨습니다.'); certNum.focus(); return false;
			}
		}
	/*} else if(certDiv == '5') {
		if(pQuestion.val() == '') { 
			if(language == 'ko') {
				alert('질문을 입력해 주십시오.'); userName.focus(); return false;
			} else {
				alert("Please enter your Password's Question."); userName.focus(); return false;
			}
		}
		if(pAnswer.val() == '') { 
			if(language == 'ko') {
				alert('답변을 입력해 주십시오.'); userName.focus(); return false;
			} else {
				alert("Please enter your Password's Answer."); userName.focus(); return false;
			}
		}*/
	}
	
	if(num == '1') {
		if(certDiv == '3' || certDiv == '4'){ // G-PIN 인증
			// ssoOK Y:가입ok, D:가입중복, T:가입대상x, N:학번/교번 일치하지 않음
			//var korNm = $(f).find('input[name=korNm'+certDiv+']');
			var korNm = $(f).find('input[name=korNm]');
				
			switch (ssoOK) {
				case "Y" : 
					/* 기본정보 입력 레이어 초기화 */
					var form = $('.singleid .step2 form');
					$(form)[0].reset();
					
					/* Hidden Type */
					/* Hidden Type */
					$(form).find('input[name=empNo]').val(empNo.val());
					$(form).find('input[name=korNm]').val(korNm.val());

					$(form).find('.empNo').text(empNo.val());
					$(form).find('.korNm').text(korNm.val());
																
					/* 기본정보 입력 레이어 띄움 */		
					$('.singleid .step1').hide();
					$('.singleid .step2').show();
					$('.singleid .step3').hide();
					break;
				case "D" : 
					if(language == 'ko') {
						alert('귀하는 이미 Single-ID를 발급받으셨습니다.\n\n(입력하신 학번/교번은 이미 가입되어 있습니다.)');
					} else {
						alert('Your Single-ID has already been issued.\n\n(Your Student Number or Staff Number has already been registered.)');
					}
					$('.singleid .step1 form')[0].reset();
					empNo.focus();
					break;
				case "T" : 
					if(language == 'ko') {
						alert('가입 대상자가 아닙니다. 원스탑으로 문의하십시오.\n\n(외국인일 경우 소속대학 학과행정실에서 학번, 이름 확인하시기 바랍니다.)');
					} else {
						alert('You are not eligible for Single ID, and please contact the One-Stop Service Center at 3290-1144.\n\n(for Int’l Students, please contact your department office for confirming your Student ID No. and Name.)');
					}
					$('.singleid .step1 form')[0].reset();
					empNo.focus();
					break;
				case "N" : 
					if(language == 'ko') {
						alert('입력하신 정보와 일치하는 사람이 없습니다.');
					} else {
						alert('There is no Person that matches entered information.');
					}
					$('.singleid .step1 form')[0].reset();
					empNo.focus();
					break;
			}
		} else {
			$.ajax({
				url : '/front/SingleSignOnApp/UserAuth.kpd',
				type : 'post',
				dataType : 'json',
				data : $(f).serialize(),
				success : function(data) {
					// Single Sign On 대상자 여부 체크
					if(!data.certNum) {
						if(language == 'ko') {
							alert('인증번호가 맞지 않습니다. 다시 확인해주세요.');
						} else {
							//alert('You are not eligible for Single ID, and please contact the One-Stop Service Center at 3290-1144');
							alert('인증번호가 맞지 않습니다. 다시 확인해주세요.');
						}
						$(f).find('input[name=certNum'+ certDiv +']').focus();
						return false;
					} else {
						/* 기본정보 입력 레이어 초기화 */
						var form = $('.singleid .step2 form');
						$(form)[0].reset();
						
						/* Hidden Type */
						$(form).find('input[name=empNo]').val(data.empNo);
						$(form).find('input[name=korNm]').val(data.korNm);
						
						$(form).find('.empNo').text(data.empNo);
						$(form).find('.korNm').text(data.korNm);
																	
						/* 기본정보 입력 레이어 띄움 */		
						$('.singleid .step1').find('.hide').hide();
						$('.singleid .step1').hide();
						$('.singleid .step2').show();
						$('.singleid .step3').hide();
						$('.singleid').trigger('resize');
						
						/* 2015.11.10 팝업창 height 가 윈도우 height 보다 작을 경우 팝업창  height 를 줄이고 스크롤바 */
						if( $(window).height() < 640){ // 기존팝업창 height 640
							 $('.singleid' ).dialog({ height : $(window).height()  });      // dialog 높이 지정 
							}
					}
				}
			});
		} // else 끝
	} else if (num == '2') {
		if(certDiv == '3' || certDiv == '4'){
		// G-PIN 인증
			// ssoOK Y:가입ok, E:oneID없음, N:학번/교번 G-PIN 일치하지 않음
			var oneId = $(f).find('input[name=oneId'+certDiv+']');
			
			switch (ssoOK) {
			case "Y" : 
				/* 기본정보 입력 레이어 초기화 */
				var form = $('.findid .step2 form');
				$(form)[0].reset();
				
				/* Hidden Type */
				$(form).find('input[name=empNo]').val(empNo.val());
				$(form).find('input[name=oneId]').val(oneId.val());
				$(form).find('.oneId').text(oneId.val());
															
				/* 기본정보 입력 레이어 띄움 */		
				$('.findid .step1').hide();
				$('.findid .step2').show();
				break;
			case "E" : 
				if(language == 'ko') {
					alert('입력하신 정보와 일치하는 아이디가 없습니다.');
				} else {
					alert('There is no ID that matches entered information.');
				}
				$('.singleid .step1 form')[0].reset();
				empNo.focus();
				break;
			case "N" : 
				if(language == 'ko') {
					alert('입력하신 정보와 일치하는 사람이 없습니다.');
				} else {
					alert('There is no Person that matches entered information.');
				}
				$('.singleid .step1 form')[0].reset();
				empNo.focus();
				break;
		}
		} else {
		// 등록 인증	
/* Di key 값 update 하는 부분.
 			$.ajax({   
				type: "POST",
				async:"false",
				url: "/G-PIN/DIDupValue.jsp?empNo="+empNo.val(),   
				success:function(data){
					$(f).find('input[name=empNo]').val(empNo.val());
				}
			});
*/
			
			$.ajax({
				url : '/front/SingleSignOnApp/UserAuthCheck.kpd',
				type : 'post',
				async: 'false',
				dataType : 'json',
				data : $(f).serialize(),
				success : function(data) {
					// Single Sign On 대상자 여부 체크
					if(!data.certNum) {
						if(certDiv == '5'){
							if(language == 'ko') {
								alert('힌트 질문 및 답변이 맞지 않습니다. 다시 확인해주세요.');
							} else {
								//alert('You are not eligible for Single ID, and please contact the One-Stop Service Center at 3290-1144');
								alert('힌트 질문 및 답변이 맞지 않습니다. 다시 확인해주세요.');
							}
							$(f).find('input[name=pQuestion]').focus();
							return false;
						} else {
							if(language == 'ko') {
								alert('인증번호가 맞지 않습니다. 다시 확인해주세요.');
							} else {
								//alert('You are not eligible for Single ID, and please contact the One-Stop Service Center at 3290-1144');
								alert('인증번호가 맞지 않습니다. 다시 확인해주세요.');
							}
							$(f).find('input[name=certNum'+ certDiv +']').focus();
							return false;
						}
					} else {
						/* 기본정보 입력 레이어 초기화 */
						var form = $('.findid .step2 form');
						$(form)[0].reset();
						
						/* Hidden Type */
						$(form).find('input[name=empNo]').val(data.empNo);
						$(form).find('input[name=oneId]').val(data.id);
						$(form).find('.oneId').text(data.id);
																	
						/* 기본정보 입력 레이어 띄움 */		
						$('.findid .step1').find('.hide').hide();
						$('.findid .step1').hide();
						$('.findid .step2').show();
						$('.singleid').trigger('resize');	// 2015.11.10 팝업창 세로 조정 작업시 같이 수정함.
						
						/* 2015.11.10 팝업창 height 가 윈도우 height 보다 작을 경우 팝업창  height 를 줄이고 스크롤바 */
						if( $(window).height() < 640){ // 기존팝업창 height 640
							 $('.singleid' ).dialog({ height : $(window).height()  });      // dialog 높이 지정 
							}
					}
				}
			});
		} // else 끝	
	}
	return false;
};

doAuthGpin = function(num, div){
	var f = '';
	if(num == '1'){  // 싱글아이디 신청
		f = $('.singleid .step1 form');
	} else if (num == '2') { // 아이디 찾기
		f = $('.findid .step1 form'); 
	}
	
	var empNo = $(f).find('input[name=empNo]');
	var korNm = $(f).find('input[name=korNm]');
	
	
	/* Validate */
	if(empNo.val() == '') { 
		if(language == 'ko') {
			alert('학교/교번을 입력해 주십시오.'); empNo.focus(); return false;
		} else {
			alert('Please enter your Student Number or Staff Number.'); empNo.focus(); return false;
		};
	}
	
	if(korNm.val() == '') { 
		if(language == 'ko') {
			alert('이름을 입력해 주십시오.'); korNm.focus(); return false;
		} else {
			alert('Please enter your Name.'); korNm.focus(); return false;
		};
	}
	
	
	wWidth = 360;
    wHight = 120;

    wX = (window.screen.width - wWidth) / 2;
    wY = (window.screen.height - wHight) / 2;

    var w = '';
    if(div == '1') { //모바일
    	
    	//	w = window.open("../M-PIN/AuthStep1.jsp?call="+num+"&empNo="+empNo.val()+"&korNm="+korNm.val(), "mPinLoginWin", "directories=no,toolbar=no,left="+wX+",top="+wY+",width="+425+",height="+550);
    	w = window.open("", "mPinLoginWin", "directories=no,toolbar=no,left="+wX+",top="+wY+",width="+440+",height="+570);
    	var ssrc = '../M-PIN/AuthStep1.jsp?call='+num+'&empNo='+empNo.val()+'&korNm='+korNm.val();
    	w.document.write("<iframe width=425 height=550 src='"+encodeURI(ssrc)+"'   frameborder=0 allowfullscreen></iframe>")
    	
    } else if(div == '2') { //G-pin
    	w = window.open("../G-PIN/AuthRequest.jsp?call="+num+"&empNo="+empNo.val()+"&korNm="+korNm.val(), "gPinLoginWin", "directories=no,toolbar=no,left="+wX+",top="+wY+",width="+wWidth+",height="+wHight);
    }
};

doAuthGpinReturn = function(num, returnDI, userCert){
	var f = '';
	if(num == '1'){  // 싱글아이디 신청
		f = $('.singleid .step1 form');
	} else if (num == '2') { // 아이디 찾기
		f = $('.findid .step1 form'); 
	}	
	
	$(f).find('input[name=userCertDi]').val(returnDI);
	if(num=='1') $(f).find('input[name=korNm4]').val(userCert);
	if(num=='2') $(f).find('input[name=oneId4]').val(userCert);
};

doAuthMpinReturn = function(num, returnDI, userCert){
	var f = '';
	if(num == '1'){  // 싱글아이디 신청
		f = $('.singleid .step1 form');
	} else if (num == '2') { // 아이디 찾기
		f = $('.findid .step1 form'); 
	}	
	
	$(f).find('input[name=userCertCi]').val(returnDI);
	if(num=='1') $(f).find('input[name=korNm3]').val(userCert);
	if(num=='2') $(f).find('input[name=oneId3]').val(userCert);
};


function f_xsl(empNo) {
	$.post('/weblogic/xmlviewer',
	{formcd:p1, docseq:p2},
	function(data){
		$('#contents').html(unescape(data));
		location.href = '#_eas';
		$('#footer').show();
	});
	
	setTimeout(function(){
		$.post('/weblogic/xmlviewer',
				{formcd:p1, docseq:p2},
				function(data){
					$('#contents').html(unescape(data));
					$('#footer').show();
				});
	}, 1000);
}

helpGPIN = function(){
	var wWidth = 425;
    var wHight = 550;

    var wX = (window.screen.width - wWidth) / 2;
    var wY = (window.screen.height - wHight) / 2;
    
    var w = window.open("../G-PIN/helpGPIN.jsp", "gHelpWin", "scrollbars=yes,directories=no,toolbar=no,left="+wX+",top="+wY+",width="+wWidth+",height="+wHight);
};

doSendNumber = function(num){
	var form = '';
	if(num == '1'){  // 싱글아이디 신청
		form = $('.singleid .step1 form');
	} else if (num == '2') { // 아이디 찾기
		form = $('.findid .step1 form'); 
	}
	
	var empNo = $(form).find('input[name=empNo]');
	var certDiv = $(form).find('input:radio[name=certDiv]:checked').val();
	//var userName = $(form).find('input[name=userName'+ certDiv + ']');
	var korNm = $(form).find('input[name=korNm]');
	
	var phone1 = "";
	var phone2 = "";
	var phone3 = "";
	var userMail = "";
	var pQuestion = "";
	var pAnswer = "";
	
	if(certDiv == '1'){
		phone1 = $(form).find('input[name=phone1]');
		phone2 = $(form).find('input[name=phone2]');
		phone3 = $(form).find('input[name=phone3]');
	} else if (certDiv == '2'){
		userMail = $(form).find('input[name=userMail]');
	} else if (certDiv == '5'){
		pQuestion = $(form).find('input[name=pQuestion]');
		pAnswer = $(form).find('input[name=pAnswer]');
	}
	
	/* Validate */
	if(empNo.val() == '') { 
		if(language == 'ko') {
			alert('학교/교번을 입력해 주십시오.'); empNo.focus(); return false;
		} else {
			alert('Please enter your Student Number or Staff Number.'); empNo.focus(); return false;
		};
	}

	if(korNm.val() == '') { 
		if(language == 'ko') {
			alert('이름을 입력해 주십시오.'); korNm.focus(); return false;
		} else {
			alert('Please enter your Name.'); korNm.focus(); return false;
		};
	}
	
	if(certDiv == '1'){
		if(phone2.val() == '' || phone2.val().length < 3) { 
			if(language == 'ko') {
				alert('핸드폰 번호를 입력해 주십시오.'); phone2.focus(); return false;
			} else {
				alert('Please enter your Mobile Number.'); phone2.focus(); return false;
			}
		}	
		if(phone3.val() == '' || phone3.val().length < 4) { 
			if(language == 'ko') {
				alert('핸드폰 번호를 입력해 주십시오.'); phone3.focus(); return false;
			} else {
				alert('Please enter your Mobile Number.'); phone3.focus(); return false;
			}
		}
	} else if (certDiv == '2'){
		if(userMail.val() == '') { 
			if(language == 'ko') {
				alert('이메일 주소를 입력해 주십시오.'); phone2.focus(); return false;
			} else {
				alert('Please enter your E-mail Address.'); phone2.focus(); return false;
			}
		}
	} else if (certDiv == '5'){
		if(pQuestion.val() == '') { 
			if(language == 'ko') {
				alert('비밀번호 질문을 입력해 주십시오.'); pQuestion.focus(); return false;
			} else {
				alert("Please enter your Password's Question."); pQuestion.focus(); return false;
			}
		}
		if(pAnswer.val() == '') { 
			if(language == 'ko') {
				alert('비밀번호 답변을 입력해 주십시오.'); pAnswer.focus(); return false;
			} else {
				alert("Please enter your Password's Answer."); pAnswer.focus(); return false;
			}
		}
	}
	
	if(num == "1") { // 싱글아이디 신청
		$.ajax({
			url : '/front/SingleSignOnApp/UserCert.kpd',
			type : 'post',
			dataType : 'json',
			data : $(form).serialize(),
			success : function(data) {
				if(!data.singleSignOnCheck) {
					if(certDiv == '1' || certDiv == '2' ){	
						if(language == 'ko') {
							alert("입력하신 휴대폰번호나 이메일로 일치하는 정보가 없습니다.\n\n본인명의 휴대폰으로 인증하시거나 G-Pin으로 시도해 주시기 바랍니다.\n\n※  인증이 안 될 경우 4가지의 방법을 모두 시도해 주시기 바랍니다.\n\n(외국인일 경우 이름을 정확하게 확인(소속 학과 행정실)하셔서 입력하시기 바랍니다.)");
						} else {
							alert('You are not eligible for Single ID.\n\n(for Int’l Students, please contact your department office for confirming your Student ID No. and Name.)');
						}						
					} else {
						if(language == 'ko') {
							alert("일치하는 정보가 없습니다.\ n\n※  인증이 안 될 경우 4가지의 방법을 모두 시도해 주시기 바랍니다.\n\n(외국인일 경우 이름을 정확하게 확인(소속 학과 행정실)하셔서 입력하시기 바랍니다.)");
						} else {
							alert('You are not eligible for Single ID.\n\n(for Int’l Students, please contact your department office for confirming your Student ID No. and Name.)');
						}
					}
					$('.singleid .step1 form')[0].reset();
					
					empNo.focus();
					return false;
				} else {
					// Single Sign On 가입여부 체크
					if(data.singleSignOnApp) {
						if(language == 'ko') {
							alert('귀하는 이미 Single-ID를 발급받으셨습니다.\n\n(입력하신 학번/교번은 이미 가입되어 있습니다.)');
						} else {
							alert('Your Single-ID has already been issued.\n\n(Your Student Number or Staff Number has already been registered.)');
						}
						$('#singleIdEntry form')[0].reset();
						empNo.focus();
						return false;
					}
					
					// Single Sign 
					if(data.userCert){
						alert('인증번호가 발송되었습니다. 인증번호를 입력해주세요.');
						$(form).find('input[name=bu_send]').focus();
					} else {
						if(language == 'ko') {
							alert('입력한 정보와 일치하는 사람이 없습니다.\n\n등록된 휴대폰번호나 이메일을 다시 확인하세요.');
						} else {
							alert('입력한 정보와 일치하는 사람이 없습니다.\n\n등록된 휴대폰번호나 이메일을 다시 확인하세요.');
						}
						empNo.focus();
						return false;
					}
				}
			}
		});
		
	} else if (num == "2") { // 아이디 찾기
		$.ajax({
			url : '/front/FindUserInfo/UserOneId.kpd',
			type : 'post',
			dataType : 'json',
			data : $(form).serialize(),
			success : function(data) {
				if(!data.singleSignOnCheck) {
					if(certDiv != '2'){
						if(language == 'ko') {
							alert('입력하신 정보와 일치하는 아이디가 없습니다.');
						} else {
							alert('There is no ID that matches entered information.');
						}
						empNo.focus();
						return false;
					} else {
						if(language == 'ko') {
							alert('등록된 이메일주소가 없거나 입력하신 정보와 일치하는 아이디가 없습니다.');
						} else {
							alert('There is no ID that matches entered information.');
						}
						empNo.focus();
						return false;
					}
				}
				
				// Single Sign 
				if(data.userCert){
					alert('인증번호가 발송되었습니다. 인증번호를 입력해주세요.');
					$(form).find('input[name=bu_send]').focus();
				} else {
					if(language == 'ko') {
						alert('입력한 정보와 일치하는 사람이 없음.');
					} else {
						alert('Not accurate.');
					}
					$('.findid .step1 form')[0].reset();
					empNo.focus();
					return false;
				}
			}
		});
	}
	
};



/* 중복 아이디 체크 국문*/
var isSingleIdDupChk = false; // 아이디 중복 확인 여부
doMemberIdCheck = function(){
	var id = $('.singleid .step2 form input[name=id]');
	
	if(id.val() == '') {
		if(language == 'ko') {
		alert('Single ID 를 입력해 주십시오.'); id.focus(); return false;
		} else {
			alert('Create your Single ID.'); id.focus(); return false;
		}
	}
	
	if(id.val().length < 4) {
		if(language == 'ko') {
			alert('Single ID 는 4자 이상 30자 이하로 만들어 주십시오.'); id.focus(); return false;
		} else {
			alert('4-character minimum and 30-character maximum.'); id.focus(); return false;
		}
	}
	
	if(id.val().indexOf(' ') > -1) {
		if(language == 'ko') {
			alert('Single ID에는 공백문자를 사용할 수 없습니다.'); id.focus(); return false;
		} else {
			alert('Single ID should not allow blank spaces.'); id.focus(); return false;
		}
	}
	
	if(/[-_]/g.test(id.val().substring(0,1))) {
		if(language == 'ko') {
			alert("Single-ID 첫 문자는 '-', '_' 로 시작할 수 없습니다."); id.focus(); return false;
		} else {
			alert("Single ID should not begin with '-', '_'"); id.focus(); return false;
		}
	}
	
	if(/[^a-z0-9-_]/g.test(id.val())) {
		if(language == 'ko') {
			alert("Single-ID에는 영문 소문자와 숫자, '-', '_'만이 사용가능합니다."); id.focus(); return false;
		} else {
			alert("Only lower case of alphabet, numbers, and '-', '_' can make Single ID."); id.focus(); return false;
		}
	}
	
	id.change(function() {
		isSingleIdDupChk = false;
	});
	
	$.ajax({
		url : '/front/SingleSignOnApp/SingleIDDupChk.kpd',
		type : 'post',
		dataType : 'html',
		data : 'id=' + id.val(),
		success : function(data) {
			if(eval(data)) {
				if(language == 'ko') {
					alert('사용할 수 없는 아이디 입니다.');
				} else {
					alert(id.val() + ' is not available.');
				}
				id.focus();
				isSingleIdDupChk = false;
				return false;
			} else {
				if(language == 'ko') {
					alert('사용 가능한 아이디 입니다.');
				} else {
					alert(id.val() + ' is available.');
				}
				$('.singleid .step2 form input[name=password]').focus();
				isSingleIdDupChk = true;
			}
		},
		error: function () { alert(errorMessage); }
	});
};

/* 웹메일 사용여부에 따라 @korea.ac.kr 셋팅 국문*/
setMail = function(obj){
	var email = $('.singleid .step2 form input[name=email]');
	if($(obj).val() == 'Y') {
		email.val($('.singleid .step2 form input[name=id]').val() + '@korea.ac.kr');
		email.attr('disabled', 'disabled');
	} else {
		email.removeAttr("disabled");
		email.val('');
		email.focus();
	}
};
	
getMail = function(){
	var email = $('.singleid .step2 form input[name=email]');
	var useWebMail = $('.singleid .step2 form input[name=useWebMail]:checked'); 

	if(useWebMail.val() == 'Y') {
		email.val($('.singleid .step2 form input[name=id]').val() + '@korea.ac.kr');
		email.attr('disabled', 'disabled');
	} else {
		email.removeAttr("disabled");
		email.val('');
	}
};

/* 기본정보 입력 Submit 2단계 국문*/
doMemberSave = function(f) {
	var empNo = $(f).find('input[name=empNo]');
	var id = $(f).find('input[name=id]');
	var password = $(f).find('input[name=password]');
	var password_confirm = $(f).find('input[name=password_confirm]');
	var mobile = $(f).find('input[name=mobile]');
	var email = $(f).find('input[name=email]');
	var outEmail = $(f).find('input[name=outEmail]');
	var hint = $(f).find('input[name=hint]');
	var hintAnswer = $(f).find('input[name=hintAnswer]');
	var agree = document.getElementsByName("agree");
	
	// 이메일 유효성 체크 정규표현식
	var emailReg = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
	
	if(id.val() == '') {
		if(language == 'ko') {
			alert('Single ID 를 입력해 주십시오.'); id.focus(); return false;
		} else {
			alert('Create your Single ID.'); id.focus(); return false;
		}
	}
	
	if(id.val().length < 4) {
		if(language == 'ko') {
			alert('Single ID 는 4자 이상 30자 이하로 만들어 주십시오.'); id.focus(); return false;
		} else {
			alert('4-character minimum and 30-character maximum.'); id.focus(); return false;
		}
	}
	
	if(/[-_]/g.test(id.val().substring(0,1))) {
		if(language == 'ko') {
			alert("Single-ID 첫 문자는 '-', '_' 로 시작할 수 없습니다."); id.focus(); return false;
		} else {
			alert("Single ID should not begin with '-', '_'"); id.focus(); return false;
		}
	}
	
	if(id.val().indexOf(' ') > -1) {
		if(language == 'ko') {
			alert('Single ID에는 공백문자를 사용할 수 없습니다.'); id.focus(); return false;
		} else {
			alert('Single ID should not allow blank spaces.'); id.focus(); return false;
		}
	}
	
	if(/[^a-z0-9-_]/g.test(id.val())) {
		if(language == 'ko') {
			alert("Single-ID에는 영문 소문자와 숫자, '-', '_'만이 사용가능합니다."); id.focus(); return false;
		} else {
			alert("Only lower case of alphabet, numbers, and '-', '_' can make Single ID."); id.focus(); return false;
		}
	}
	
	if(!isSingleIdDupChk) {
		if(language == 'ko') {
			alert('아이디 중복 확인을 해주십시오.');
		} else {
			alert(id.val() + ' is not available.');
		}
		$('#baseInfoInput #singleIdDupChk').focus();
		return false;
	}
	
	if(password.val() == '') {
		if(language == 'ko') {
			alert('비밀번호를 입력해 주십시오.'); password.focus(); return false;
		} else {
			alert('Create a password.'); password.focus(); return false;
		}
	}
	 
/*	if(password.val().match(/([a-zA-Z0-9].*[!,@,#,$,%,^,&,*,?,_,~])|([!,@,#,$,%,^,&,*,?,_,~].*[a-zA-Z0-9])/)) {
		if(password.val().length < 8 ) {
			if(language == 'ko') {
				alert('특수문자가 섞이지 않은 비밀번호는 10자 이상, 특수문자가 섞인 비밀번호는 8자이상으로 만들어 주십시오.');	password.focus(); return false;
			} else {
				alert('8-character minimum and 20-character maximum.');	password.focus(); return false;
			}
		}
	} else {
		if(password.val().length < 10 ) {
			if(language == 'ko') {
				alert('특수문자가 섞이지 않은 비밀번호는 10자 이상, 특수문자가 섞인 비밀번호는 8자이상으로 만들어 주십시오.');	password.focus(); return false;
			} else {
				alert('8-character minimum and 20-character maximum.');	password.focus(); return false;
			}
		}
	}*/
	
	if( password.val().replace( /(\w)\1+/gi, '' ) == password.val() ){
	} else {
		alert("비밀번호는 중복된 문자 또는 숫자를 사용 할 수 없습니다."); return false;
	}
	
	if (password.val().indexOf(' ') > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 공백문자를 사용할 수 없습니다."); password.focus(); return false;
		} else {
			alert("Password should not allow blank spaces."); password.focus(); return false;
		}
	}			
	
	if (password.val().indexOf(id.val()) > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 Single-ID를 사용할 수 없습니다."); password.focus(); return false;
		} else {
			alert("Single ID should not be used for a password."); password.focus(); return false;
		}
	}
	  
	if (password.val().indexOf(empNo.val()) > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 교번이나 학번을 사용할 수 없습니다."); password.focus(); return false;
		} else {
			alert("Student Number or Staff Number should not be used for a password."); password.focus(); return false;
		}
	}

	for(var i = 0; i < xssfilter.length ; i++){
		if(password.val().indexOf(xssfilter[i]) != -1){
			if(language == 'ko') {
				alert('보안상의 이유로 [' + xssfilter[i] + ']는 비밀번호에 포함될 수 없습니다.'); pw.focus(); return false;
			} else {
				alert('Your password cannot include mark [' + xssfilter[i] + '] because of security problems.');  pw.focus(); return false;
			}
		}
	}
	
	/*
	if (password.val().indexOf(ssn1.val()) > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 주민등록번호를 사용할 수 없습니다."); password.focus(); return false;
		} else {
			alert("National ID Number should not be used for a password."); password.focus(); return false;
		}
	}
	 */	
	if(password_confirm.val() == '') {
		if(language == 'ko') {
			alert('비밀번호를 한번더 입력해 주십시오.'); password_confirm.focus(); return false;
		} else {
			alert('Retype password.'); password_confirm.focus(); return false;
		}
	}
	
	if(password.val() != password_confirm.val()) {
		if(language == 'ko') {
			alert('비밀번호가 일치하지 않습니다. 다시 확인하여 주십시오.'); password.focus(); return false;
		} else {
			alert('This password doesn\'t match the confirmation password. Please check again.'); password.focus(); return false;
		}
	}
	
	 
//	if(mobile.val() == '') {
//		if(language == 'ko') {
//		alert('핸드폰 번호를 입력해 주십시오.'); mobile.focus(); return false;
//		} else {
//			alert('Please enter your mobile number.'); mobile.focus(); return false;
//		}
//	}
	
//	if(/[^0-9-]/g.test(mobile.val())) {
//		if(language == 'ko') {
//			alert("핸드폰 번호는 숫자와 '-' 문자만  입력해 주십시오."); mobile.focus(); return false;
//		} else {
//			alert("Please enter your mobile phone number with using only number and  '-'."); mobile.focus(); return false;
//		}
//	}
	
	var tmpMobile = mobile.val().replace(/-/g, '');
	if (tmpMobile != "" && password.val().indexOf(tmpMobile) > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 핸드폰 번호를 사용할 수 없습니다."); password.focus(); return false;
		} else {
			alert("Your mobile number should not be used for a password."); password.focus(); return false;
		}
	}

	if (tmpMobile != "" && password.val().indexOf(tmpMobile.substring(tmpMobile.length-4 , tmpMobile.length)) > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 핸드폰 번호 뒤 4자리 숫자를 사용할 수 없습니다.");	password.focus(); return false;
		} else {
			alert("Password can't contain the Four-digit behind the phone number.");	password.focus(); return false;
		}
	}
	
	var sum = 0;
	
	 if (/[0-9]/.test(password.val() )) { sum++; }
	 if (/[a-zA-Z]/.test(password.val() )) { sum++; }
	 if (/[^0-9a-zA-Z]/.test(password.val() )) { sum++; }
	 
	 if (sum >= 3) {
		 //길이가 8자리 이상 ok
		 if(password.val().length < 8 ) {
			if(language == 'ko') {
				alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 비밀번호는 8자이상으로 만들어 주십시오.');	password.focus(); return false;
			} else {
				alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 비밀번호는 8자이상으로 만들어 주십시오.');	password.focus(); return false;
			}
		}
	 } else if (sum == 2) {
		 // 길이가 10자리 이상 ok
		 if(password.val().length < 10 ) {
			 if(language == 'ko') {
				 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n2종류로 구성한 경우 비밀번호는 10자이상으로 만들어 주십시오.');	password.focus(); return false;
			 } else {
				 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n2종류로 구성한 경우 비밀번호는 10자이상으로 만들어 주십시오.');	password.focus(); return false;
			 }
		 } 
	 } else {
		 // 조합이 1개 안됨.
		 if(language == 'ko') {
			 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 8자 이상, \n2종류로 구성한 경우 10자 이상으로 만들어 주십시오.');	password.focus(); return false;
		 } else {
			 alert('영대소문자(A~Z, a~z, 52개), \n숫자(0~9, 10개) 및 특수문자(32개) 중 \n3종류로 구성한 경우 8자 이상, \n2종류로 구성한 경우 10자 이상으로 만들어 주십시오.');	password.focus(); return false;
		 }
	 }
	
//	if(email.val() == '') {
//		if(language == 'ko') {
//		alert('이메일을 입력해 주십시오.'); email.focus(); return false;
//		} else {
//			alert('Please enter the E-mail address.'); email.focus(); return false;
//		}
//	}
	
//	if(!emailReg.test(email.val())) {
//		if(language == 'ko') {
//			alert('이메일 형식이 올바르지 않습니다. 다시 입력해 주십시오.'); email.focus(); return false;
//		} else {
//			alert('The alternate e-mail address is incorrect. Please enter again.'); outEmail.focus(); return false;
//		}
//	}
	
//	if(outEmail.val() == '') {
//		if(language == 'ko') {
//			alert('추가 사용 이메일을 입력해 주십시오.'); outEmail.focus(); return false;
//		} else {
//			alert('Please enter a question related to password.'); hint.focus(); return false;
//		}
//	}
	
//	if(!emailReg.test(outEmail.val())) {
//		if(language == 'ko') {
//			alert('추가 사용 이메일 형식이 올바르지 않습니다. 다시 입력해 주십시오.'); outEmail.focus(); return false;
//		} else {
//			alert('The alternate e-mail address is incorrect. Please enter again.'); outEmail.focus(); return false;
//		}
//	}
	
	if(hint.val() == '') {
		if(language == 'ko') {
			alert('비밀번호 힌트 질문을 입력해 주십시오.'); hint.focus(); return false;
		} else {
			alert('Please enter a question related to password.'); hint.focus(); return false;
		}
	}
	
	if(hintAnswer.val() == '') {
		if(language == 'ko') {
			alert('비밀번호 힌트 답을 입력해 주십시오.'); hintAnswer.focus(); return false;
		} else {
			alert('Please enter an answer to the question related to password.'); hintAnswer.focus(); return false;
		}
	}
	
	if(!agree[0].checked && !agree[1].checked) {
		if(language == 'ko') {
			alert('싱글아이디 신청 동의/동의안함을 선택해주세요'); return false;
		} else {
			alert('Please select agreement or not.'); agree.focus(); return false;
		}
	}
	
	if(agree[1].checked) {
		if(language == 'ko') {
			alert('싱글아이디 신청을 완료 하실려면 동의를 눌러주세요'); return false;
		} else {
			alert('Please select agreement as agree.'); agree.focus(); return false;
		}
	}
	
	/* 이메일 필드 디스블 해제(해제안하면 안넘어감..) */
//	email.removeAttr("disabled");
	
	/* 핸드폰 번호 '-' 문자 제거 */
//	mobile.val(mobile.val().replace(/-/g, ''));
	
	//회원가입 처리중에는 버튼('확인','취소')이 작동 되지 않도록 한다.
	$(f).find('button').attr('disabled','disabled');
	
	/* Submit 중복 방지 */
	$(':submit',f).attr('disabled','disabled');
	
	errorMessagePer = "등록된 학적/인사 정보에 오류가 있습니다."
	$.ajax({
		url : '/front/SingleSignOnApp/SingleSignOnApp.kpd',
		type : 'post',
		async: 'false',
		dataType : 'json',
		data : $(f).serialize(),
		success : function(data) {
			if(data.msg != 'Y') {
				alert(data.msg);
				
				/* Submit 중복 방지 제거 */
				$(':submit',f).removeAttr('disabled');

				return false;
			}
				
			// 소속정보 불러오기
			var positionInfo = data.positionInfo;
			
			// 일치하지 않는 소속정보 불러오기
			var notMatchPositionInfo = data.notMatchPositionInfo;
								
			// 소속정보 셋팅
			$('._position').empty();
			
			for(var i=0; i<positionInfo.length; i++) {
				var delimiter = ', ';
				var html = '';
				html += '<label for="info' + i + '">';
				html += '<p' + ( (i+1) == positionInfo.length ? ' class="mt10"' : '' ) + '>';
				html += '<input type="hidden" class="radio" name="positionInfoUpdateKey" id="info' + i + '"';
				html += ' value="' + positionInfo[i].id + ';' + positionInfo[i].empNo + ';' + positionInfo[i].groupId + ';' + positionInfo[i].jobCd + '"';
				html += (i == 0 ? 'checked="checked"' : '') + '>';
				html += '<strong>' + positionInfo[i].groupNm + '</strong> (';
				html += positionInfo[i].empNo;
				html += (positionInfo[i].korNm == '' ? '' : delimiter) + positionInfo[i].korNm;
				html += (positionInfo[i].groupNm == '' ? '' : delimiter) + positionInfo[i].groupNm;
				html += (positionInfo[i].deptNm == '' ? '' : delimiter) + positionInfo[i].deptNm + ')';
				
				html += '</label></p>';
				//alert(html);
				$('._position').append(html);
			}
			
			// 일치하지 않는 소속정보 셋팅				
			$('._nposition').empty();
						
			for(var i=0; i<notMatchPositionInfo.length; i++) {
				var delimiter = ', ';
				var html = '';
				html += '<span>';
				html += notMatchPositionInfo[i].groupNm + ' (';
				html += notMatchPositionInfo[i].empNo;
				html += (notMatchPositionInfo[i].korNm == '' ? '' : delimiter) + notMatchPositionInfo[i].korNm;
				html += (notMatchPositionInfo[i].groupNm == '' ? '' : delimiter) + notMatchPositionInfo[i].groupNm;
				html += (notMatchPositionInfo[i].deptNm == '' ? '' : delimiter) + notMatchPositionInfo[i].deptNm;
				html += ')</span><br/>';

				//alert(html);
				$('._nposition').append(html);
			}

			$('.singleid .step1').hide();
			$('.singleid .step2').hide();
			$('.singleid .step3').show();
		},
		error: function () { alert(errorMessagePer); }
	});
	return false;
};

/* 기본정보 입력 Submit 국문*/
doMemberFinish = function(f) {
	$.ajax({
		url : '/front/SingleSignOnApp/UpdatePositionInfo.kpd',
		type : 'post',
		dataType : 'html',
		data : $(f).serialize(),
		success : function(data) {
			if(data > 0) {
				if(language == 'ko') {
					alert("Single ID 신청이 완료되었습니다.");
				} else {
					alert("Your Single ID has been successfully created.");
				}
				$('.singleid .step1 form').find('.hide').hide();
				$('.singleid .step1 form')[0].reset();
				$('.singleid').dialog('close');
				$('#login form input[name=id]').focus();
				return false;
			} else {
				if(language == 'ko') {
					alert("소속정보 갱신 중 오류가 발생하였습니다. 원스탑으로 문의하시기 바랍니다.");
				} else {
					alert("An error occurs when creating Single ID. Please contact the One-stop service center at 3290-1144.");
				}
				return false;
			}
		},
		error: function () { alert(errorMessage); }
	});		
	return false;
};

dialog_close = function(){
	$('form').each(function(o) {
		this.reset();
	});
	$('.layerpop').dialog('close');
};

passwordChange = function(){
	var new_password = $('#passwordChange form').find('input[name=new_password]');
	var password_confirm = $('#passwordChange form').find('input[name=password_confirm]');		
	var lang = $('#loginform input[name=lang]').val();
	var cur_pw = $('#loginform input[name=pw]').val();
	var id = $('#loginform input[name=id]').val();
	var token = $('#passwordChange form').find('input[name=token]');
	$('#passwordChange form').find('input[name=current_password]').val(cur_pw) ;
	$('#passwordChange form').find('input[name=id]').val(id) ;
	
	if(new_password.val() == '') {
		if(language == 'ko') {
			alert('새로운 비밀번호를 입력해 주십시오.'); new_password.focus(); return false;
		}else if(language == 'en'){
			alert('Please enter the new password'); new_password.focus(); return false;
		}else{
			
		}	
	}
	
	if(new_password.val().length < 8 ) {
		if(language == 'ko') {
			alert('비밀번호는 8자 이상 20자 이하로 만들어 주십시오.');	new_password.focus(); return false;
		}else if(language == 'en'){
			alert('New password must contain between 8 digits and 20 digits');
		}else{
			
		}	
	}
	
	if (new_password.val().indexOf(' ') > -1) {
		if(language == 'ko') {
			alert("비밀번호에는 공백문자를 사용할 수 없습니다."); new_password.focus(); return false;
		}else if(language == 'en'){
			alert("Password can't contain the blank characters.");
		}else{
			
		}
	}
	
	if(new_password.val() == cur_pw) {
		if(language == 'ko') {
			alert('기존 비밀번호와 같습니다. 다시 입력해 주십시오.');
		}else if(language == 'en'){
			alert('New password is identical with existing password. please check again.');
		}else{
			
		}
		$('#passwordChange form')[0].reset();
		new_password.focus(); 
		return false;
	}
	
	if(new_password.val().indexOf(id) > -1) {
		if(language == 'ko') {
			alert('비밀번호에는 Single-ID를 사용할 수 없습니다.');
		}else if(language == 'en'){
			alert("Password can't contain the Single-ID characters.");
		}else{
			
		}
		$('#passwordChange form')[0].reset();
		new_password.focus(); 
		return false;
	}

	if(password_confirm.val() == '') {
		if(language == 'ko') {
			alert('비밀번호를 한번더 입력해 주십시오.'); password_confirm.focus(); return false;
		}else if(language == 'en'){
			alert('Please enter the Password one more.'); password_confirm.focus(); return false;
		}else{
			
		}
	}
	
	if(new_password.val() != password_confirm.val()) {
		if(language == 'ko') {
			alert('비밀번호가 일치하지 않습니다. 다시 확인하여 주십시오.'); new_password.focus(); return false;
		}else if(language == 'en'){
			alert('Entered password does not match. please check again.'); new_password.focus(); return false;
		}else{
			
		}
	}
	
	$.ajax({
		url : '/common/NewPwUpdate.kpd',
		type : 'post',
		dataType : 'json',
		data : $('#passwordChange form').serialize()+"&callback=",
		success : function(data) {
			if(data.msg > 0) {

				//지메일 비밀번호 변경 추가
				$.ajax({
					url : "https://mail.korea.ac.kr/ChangePassword.jsp?callback=callfunc&portalId=" + encodeURIComponent(id) + "&token=" + encodeURIComponent(data.token),
					dataType : 'jsonp',
					contentType : 'application/javascript',
					jsonpCallback : 'callfunc',
					success : function(result) {
						if(result.resultCode == "FAIL") {
							alert ('비밀번호 처리 도중(지메일 연동) 오류가 발생하였습니다. ' + result.failMessage);
							return false;
						} else if (result.resultCode == "NOEMAIL" || result.resultCode == "OK") {
							$('#loginform')[0].pw.value = $('#passwordChange form')[0].password_confirm.value;
							$('#loginform').submit();
						}
					}
				});
				
				
			} else {
				if(language == 'ko') {
					alert('비밀번호가 잘못되었습니다... 다시 확인하시기 바랍니다.');
				}else if(language == 'en'){
					alert('Your password is incorrect. please check again.');
				}else{
					
				}
				$('#passwordChange form')[0].reset();
				$('#passwordChange form input[name=current_password]').focus();
				return false;
			}
		},
		error: function () { alert(errorMessage); }
	});		
	return false;
};

passwordChangeCancel = function() {
	$('#loginform')[0].pw_pass.value = 'Y';
	$('#loginform').submit();
};

var session_keys = "";