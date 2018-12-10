function TrimSpace1(formobject,Case){
	var i,strvalue,strlen;

	strvalue=formobject.value;
	strlen=strvalue.length;

	for (i=0;i<strlen;i++){
		 if (strvalue.substring(i,i+1) != " "){
		  strvalue=strvalue.substring(i,strlen);
		  strlen=strvalue.length;
		  break;
		}
		if (i==strlen-1){
		formobject.value="";
		return false;
  	    }
   }

   for (i=0;i<strlen;i++){
		if (strvalue.substring(strlen-i-1,strlen-i) != " "){
		strvalue=strvalue.substring(0,strlen-i);
		break;
	   }
   }

   if (Case == "UCase"){
		formobject.value=strvalue.toUpperCase();
   }else if (Case == "LCase"){
		formobject.value=strvalue.toLowerCase();
   }else if (Case == "NCase"){
		formobject.value=strvalue;
   }
}