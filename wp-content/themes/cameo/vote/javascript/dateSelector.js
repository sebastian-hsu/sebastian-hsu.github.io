<!-- Begin
//set todays date
Now = new Date();
NowDay = Now.getDate();
NowMonth = Now.getMonth();
NowYear = Now.getYear();
if (NowYear < 2000) NowYear += 1900; //for Netscape
yearMax=2031;

//function for returning how many days there are in a month including leap years
function DaysInMonth(WhichMonth, WhichYear)
{
  var DaysInMonth = 31;
  if (WhichMonth == "4" || WhichMonth == "6" || WhichMonth == "9" || WhichMonth == "11") DaysInMonth = 30;
  if (WhichMonth == "2") {
    if ((WhichYear/4) == Math.floor(WhichYear/4) && (WhichYear/100) != Math.floor(WhichYear/100))	DaysInMonth = 29;
    else DaysInMonth = 28;
  }
  return DaysInMonth;
}

//function to change the available days in a months
function ChangeOptionDays(theForm,Which)
{
  DaysObject = eval(theForm + "." + Which + "Day");
  MonthObject = eval(theForm + "." + Which + "Month");
  YearObject = eval(theForm + "." + Which + "Year");

  Month = MonthObject[MonthObject.selectedIndex].text;
  Year = YearObject[YearObject.selectedIndex].value;

  DaysForThisSelection = DaysInMonth(Month, Year);
  CurrentDaysInSelection = DaysObject.length;
  if (CurrentDaysInSelection > DaysForThisSelection)
  {
    for (i=0; i<(CurrentDaysInSelection-DaysForThisSelection); i++)
    {
      DaysObject.options[DaysObject.options.length - 1] = null;
    }
  }
  if (DaysForThisSelection > CurrentDaysInSelection)
  {
    for (i=0; i<(DaysForThisSelection-CurrentDaysInSelection); i++)
    {
      NewOption = new Option(DaysObject.options.length + 1);
      DaysObject.options[DaysObject.options.length] = new Option(CurrentDaysInSelection+i+1);
    }
  }
  if (DaysObject.selectedIndex < 0) DaysObject.selectedIndex = 0;
}

//function to set options to today
function SetToToday(theForm,Which)
{
	var yearOK=0;
  DaysObject = eval(theForm + "." + Which + "Day");
  MonthObject = eval(theForm + "." + Which + "Month");
  YearObject = eval(theForm + "." + Which + "Year");

  for(i=0;i<YearObject.options.length;i++){
    if(YearObject.options[i].value*1==NowYear*1){
    	YearObject.options[i].selected = true;
    	yearOK=1;
    }
  }
  if(yearOK==0){
    for (i=(YearObject.options.length-1); i>=0; i--)
    {
      YearObject.options[i] = null;
    }
    for (i=NowYear-3; i<NowYear+5; i++)
    {
      NewOption = new Option(YearObject.options.length + 1);
      YearObject.options[(i-(NowYear-3))] = new Option((i-1911),i);
    }
    YearObject.options[3].selected = true;
  }
  if(NowMonth>0) MonthObject.options[NowMonth].selected = true;

  ChangeOptionDays(theForm,Which);

  if(NowDay-1>0) DaysObject.options[(NowDay-1)].selected = true;
}

//function to set options to someday
function SetToSomeday(theForm,Which,theYear,theMonth,theDay)
{
	var yearOK=0;
  if(yearMax<(theYear*1+5)) yearMax=(theYear*1+5);
  DaysObject = eval(theForm + "." + Which + "Day");
  MonthObject = eval(theForm + "." + Which + "Month");
  YearObject = eval(theForm + "." + Which + "Year");

  for(i=0;i<YearObject.options.length;i++){
    if(YearObject.options[i].value*1==theYear*1){
    	YearObject.options[i].selected = true;
    	yearOK=1;
    }
  }
  if(yearOK==0 && theYear>1970){
    for (i=(YearObject.options.length-1); i>=0; i--)
    {
      YearObject.options[i] = null;
    }
    for (i=theYear-3; i<yearMax; i++)
    {
      NewOption = new Option(YearObject.options.length + 1);
      YearObject.options[(i-(theYear-3))] = new Option((i-1911),i);
    }
    YearObject.options[3].selected = true;
  }
  if(theMonth-1>0) MonthObject.options[(theMonth-1)].selected = true;

  ChangeOptionDays(theForm,Which);

  if(theDay-1>0)DaysObject.options[(theDay-1)].selected = true;
}

//function to set options to someday
function SetToSomeYEAR(theForm,Which,theYear)
{
	var yearOK=0;
  if(yearMax<(theYear*1+5)) yearMax=(theYear*1+5);
  YearObject = eval(theForm + "." + Which);

  for(i=0;i<YearObject.options.length;i++){
    if(YearObject.options[i].value*1==theYear*1){
    	YearObject.options[i].selected = true;
    	yearOK=1;
    }
  }
  if(yearOK==0 && theYear>1970){
    for (i=(YearObject.options.length-1); i>=0; i--)
    {
      YearObject.options[i] = null;
    }
    for (i=theYear-3; i<yearMax; i++)
    {
      NewOption = new Option(YearObject.options.length + 1);
      YearObject.options[(i-(theYear-3))] = new Option((i-1911),i);
    }
    YearObject.options[3].selected = true;
  }
}

//function to write option years plus x
function WriteYearOptions(YearsAhead)
{
  line = "";
  for (i=0; i<YearsAhead; i++)
  {
    line += "<OPTION value="+(NowYear+i)+">";
    line += (NowYear+i-1911);
    line += "</OPTION>";
  }
  return line;
}

function WriteYearOptionsBack(YearsBack)
{
  line = "";
  for (i=0; i<=YearsBack; i++)
  {
    line += "<OPTION value="+(NowYear-i)+">";
    line += (NowYear-i-1911);
    line += "</OPTION>";
  }
  return line;
}

function WriteYearOptionsBackRange(YearsBackOld,YearsBackYoung)
{
  line = "";
  for (i=YearsBackYoung; i<=YearsBackOld; i++)
  {
    line += "<OPTION value="+(NowYear-i)+">";
    line += (NowYear-i-1911);
    line += "</OPTION>";
  }
  return line;
}

function WriteYearOptionsFrom2000A30()
{
  line = "";
  YearsMax=2030;
  if(YearsMax<NowYear) YearsMax=NowYear;
  for (i=2000; i<=YearsMax; i++)
  {
    line += "<OPTION value="+i+">";
    line += (i-1911);
    line += "</OPTION>";
  }
  return(line);
}
//  End -->