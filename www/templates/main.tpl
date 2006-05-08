{add file="style.css"}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<title>{$title}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
{include file='include.css.tpl'}
{include file='include.js.tpl'}
</head>
<body>
<p class="title">{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION})</p>
<div class="separator">&nbsp;</div>
<p />
{$content}
<p />
{load module="user" action="login"}
<div class="separator">&nbsp;</div>
{load module="timer" action="view"}
</body>
</html>