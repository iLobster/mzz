{add file="style.css"}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ru" xml:lang="ru">
<head>
<title>{$title|default:''}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
{include file='include.css.tpl'}
{include file='include.js.tpl'}
{$xajax_js|default:''}

{literal}
<script language="JavaScript">
document.onkeydown = proccessKey;

function proccessKey(key) {
	var code;
	if (!key) key = window.event;
	if (key.keyCode) code = key.keyCode;
	else if (key.which) code = key.which;
	if (code == 27) hideJip();
}

function showJip(url)
{
        xajaxRequestUri=url;
	if (document.getElementById('jip')) {
		document.getElementById('jip').style.display = 'block';
                xajax_tostring();
		return false;
	}
	return true;
}

function hideJip()
{
	if(document.getElementById('jip')) {
             document.getElementById('jip').style.display = 'none';
        }
	return false;
}

</script>
{/literal}

</head>
<body>

<div id="jip">
Загрузка
<input type="button" value="Закрыть" onClick="hideJip()">
</div>

<p class="title">{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION})</p>

<div class="separator">&nbsp;</div>
<a href="{url section=news}">Новости</a> | <a href="{url section=page}">Страницы</a> | <a href="{url section=user action=list}">Пользователь</a><p />
{$content}
<p />
{load module="user" action="login" args="1" section="user"}
<div class="separator">&nbsp;</div>
{load module="timer" action="view" section="timer"}
</body>
</html>