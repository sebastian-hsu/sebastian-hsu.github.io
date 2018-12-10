function checkRegData(form)
{
  TrimSpace1(form.realname,"NCase");
  if (form.realname.value == "")
  {
    alert("請輸入您的姓名!");
    form.realname.focus();
    return false;
  }
  TrimSpace1(form.email,"NCase");
  if (form.email.value == "")
  {
    alert("請輸入您的E-Mail!");
    form.email.focus();
    return false;
  }
  if (form.email.value != "")
  {
    if (checkEmailAddress(form.email)==false) {
      alert("請檢查E-Mail的格式！");
      form.email.focus();
      return false;
    }
  }
  TrimSpace1(form.title,"NCase");
  if (form.title.value == "")
  {
    alert("請輸入您的發表主題!");
    form.title.focus();
    return false;
  }
  TrimSpace1(form.content,"NCase");
  if (form.content.value == "")
  {
    alert("請輸入您的發表內容!");
    form.content.focus();
    return false;
  }
  TrimSpace1(form.checknum,"NCase");
  if (form.checknum.value == "")
  {
    alert("請輸入驗證碼!");
    form.checknum.focus();
    return false;
  }
  return true;
}