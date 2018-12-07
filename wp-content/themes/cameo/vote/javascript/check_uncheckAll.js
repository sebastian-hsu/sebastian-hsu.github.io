function check_uncheckAll(switchX,fieldall) {
  var chkAll = switchX;
  var checks = document.getElementsByName(fieldall);
    if ( chkAll ) {
      for ( i=0; i < checks.length; i++ ) {
        checks[i].checked = true;
      }
    }
    else {
      for ( i=0; i < checks.length; i++ ) {
        checks[i].checked = false;
      }
    }
}

function check_uncheckAllX(fieldall) {
  var chkAll = 1;
  var checks = document.getElementsByName(fieldall);
    for ( i=0; i < checks.length; i++ ) {
    	if(i==0){ if(checks[i].checked == true) chkAll=0; }
    	if(chkAll==1)  checks[i].checked = true;
      else checks[i].checked = false;
    }
}