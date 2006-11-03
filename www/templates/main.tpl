{add file="style.css"}{add file="/fixpng.js"}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>{$title|default:''}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
{include file='include.css.tpl'}
{include file='include.js.tpl'}
{$xajax_js|default:''}
{literal}
<script src="/templates/ajax/yahoo.js"></script>
<script src="/templates/ajax/connection.js"></script>
<script language="JavaScript">
var urlStack = new Array;
var currentUrl;
var formSuccess = false;

document.onkeydown = proccessKey;


var handleSuccess = function(o){
	if(typeof o.responseText !== undefined){
		o.argument.div.innerHTML = "<div style='float: right;'><img alt='Закрыть' width='16' height='16' src='/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
		o.argument.div.innerHTML += o.responseText;
		//div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
	}
}

var handleFormSuccess = function(o){
	if(typeof o.responseText !== undefined){
showJip(o.argument.currentUrl, 1);
		//o.argument.div.innerHTML = "<div style='float: right;'><img alt='Закрыть' width='16' height='16' src='/templates/images/close.gif' onclick='javascript: hideJip();' /></div>";
		//o.argument.div.innerHTML += '<div style="font-size: 100%;color: green;">Данные сохранены</div>' + o.responseText;
		//div.innerHTML += "<li>HTTP status: " + o.status + "</li>";
	}
}

var handleFailure = function(o){
	if(typeof o.responseText !== undefined){
		alert("No response. Server error. \r\n Trans_id: " + o.tId + "; HTTP status: " + o.status + "; Code message: " + o.statusText);
	}
}




function proccessKey(key) {
	var code;
	if (!key) key = window.event;
	if (key.keyCode) code = key.keyCode;
	else if (key.which) code = key.which;
	if (code == 27) hideJip();
}

var lastJipUrl = false;

function showJip(url, flag)
{
        cleanJip(); 
	if (document.getElementById('jip')) {

                document.getElementById('blockContent').style.display = 'block';
                /*if (lastJipUrl != false) {
                    urlStack.push([lastJipUrl]); alert(lastJipUrl);
                    lastJipUrl = false; 
                } else {
                    lastJipUrl = url + '&xajax=true';
                }*/urlStack.push([url]);

		document.getElementById('jip').style.display = 'block';


                var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById('jip') }};
                currentUrl = url;
                 /*   urlStack.push([currentUrl]);
                }*/
	        var request = YAHOO.util.Connect.asyncRequest('GET', url + '&xajax=true', callback);

                delete flag;
		return false;
	}
        delete flag;
	return true;
}


function sendFormWithAjax(form)
{

        urlStack.push([currentUrl]);
        var callback = {success:handleSuccess, failure:handleFailure, argument: { div:document.getElementById('jip'), currentUrl:currentUrl }};
        YAHOO.util.Connect.setForm(form);
	var request = YAHOO.util.Connect.asyncRequest('POST', form.action + '&xajax=true', callback);
        return false;
}


function hideJip()
{ 
	if(document.getElementById('jip')) {

             if (urlStack.length > 0) { 

                 lastJipUrl = urlStack.pop();
                 urlFromStack = urlStack.pop();
                 if (urlFromStack != undefined) {  
                 return showJip(urlFromStack[0], true);}
             }
             
             document.getElementById('blockContent').style.display = 'none';
             document.getElementById('jip').style.display = 'none';
             lastJipUrl = false; 

        }
	return false;
}

function cleanJip()
{
    document.getElementById('jip').innerHTML = 'Загрузка данных. Подождите... <br /> <input type="button" value="Закрыть" onClick="hideJip()">';
}
/*
window.onload = function() {
    cleanJip();
}
*/

</script>
{/literal}


</head>
<body id=body>


<div id="jip"></div>
<div id="blockContent"></div>

<div id="wrapper">
<div id="nonFooter">
<div id="hcontainer">

    <div id="menu">
     <div id="menu_element{if $current_section eq "news"}_current{/if}"><a href="{url section=news}">Новости</a></div>
     <div id="menu_element{if $current_section eq "page"}_current{/if}"><a href="{url section=page}">Страницы</a></div>
     <div id="menu_element{if $current_section eq "user"}_current{/if}"><a href="{url section=user action=list}">Пользователь</a></div>
    </div>

    {load module="user" action="login" args="" section="user"}
    <div id="logotip"><a href="/"><img id="img_logotip" src="/templates/images/mzz_logo.png" width="111" height="34" alt="" border="0" /></a></div>
</div>


<div id="content">{$content}</div>
</div>
</div>

<div id="footer">
        <div id="fcontainer">
        <div id="footer_text">{load module="timer" action="view" section="timer"}
2006 &copy; {$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION})</div>
        <div id="footer_image"><img src="/templates/images/mzz_footer.png" width="79" height="63" alt="" /></div>

     </div>
    </div>
</body>
</html>
