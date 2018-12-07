function checkEmailAddress(field) {
var goodEmail1 = field.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\..{2,2}))$)\b/gi);
var goodEmail2 = false;
if (field.value.indexOf('@', 0) == -1 || field.value.indexOf('.', 0) == -1 || field.value.indexOf(" ") != -1 || field.value.indexOf(",") != -1 || field.value.indexOf("@@") != -1 || field.value.indexOf("@.") != -1 || field.value.indexOf("..") != -1 || field.value.substr((field.value.length-2),2) == ".t" || field.value.substr((field.value.length-1),1) == "." )
  {
    goodEmail2 = false;
  }
else {
    goodEmail2 = true;
  }
if (goodEmail1 && goodEmail2==true) {
    return true;
  }
else {
    return false;
  }
}