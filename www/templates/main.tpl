<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
</head>
<body bgcolor="#ffffff">
<font size='+1' face=tahoma color=#111111>{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION})</font>
<hr size="1" style="color: #333333;" />
{dynamic}{$content}{/dynamic}
<br />
{dynamic}{load module="timer" action="view"}{/dynamic}
</body>
</html>