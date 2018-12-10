function $(id) { return document.getElementById(id); }
var lastpassword='';
var profile_passwd_illegal = '密碼空或包含非法字符, 請重新填寫';
var profile_passwd_notmatch = '兩次輸入的密碼不一致, 請檢查後重試';
function checkpassword(confirm) {
	var password = $('password').value;
	if(!confirm && password == lastpassword) {
		return;
	} else {
		lastpassword = password;
	}
	var cp = $('checkpassword');
	if(password == '' || /[\'\"\\]/.test(password)) {
		warning(cp, profile_passwd_illegal);
		return false;
	} else {
		cp.style.display = 'none';
		if(!confirm) {
			checkpassword2(true);
		}
		return true;
	}
}
function checkpassword2(confirm) {
	var password = $('password').value;
	var password2 = $('passwordconfirm').value;
	var cp2 = $('checkpassword2');
	if(password2 != '') {
		checkpassword(true);
	}
	if(password == '' || (confirm && password2 == '')) {
		cp2.style.display = 'none';
		return;
	}
	if(password != password2) {
		warning(cp2, profile_passwd_notmatch);
		return false;
	} else {
		cp2.style.display = 'none';
		return true;
	}
}
function warning(obj, msg) {
	obj.style.display = '';
	obj.innerHTML = '<font color=#FF0000 size=2>Error:&nbsp;' + msg+ '</font>';
}
function checkForm() {
	if(checkpassword()==false || checkpassword2()==false) return false;
	else return true;
}