<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<title>{$title|default:''}</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
{add file="ajax/yahoo.js"}{add file="ajax/connection.js"}{add file="jip.js"}{add file="style.css"}
{include file='include.css.tpl'}
{include file='include.js.tpl'}
</head>
<body>

<div id="jip"></div>
<div id="blockContent"></div>

<div id="wrapper">
<div id="nonFooter">
<div id="hcontainer">

    <div id="menu">
     <span class="menu_element">{if $current_section ne "news"}<a href="{url section=news}">{else}<b>{/if}Новости{if $current_section ne "news"}</a>{else}</b>{/if}</span>
     <span class="menu_element">{if $current_section ne "page"}<a href="{url section=page}">{else}<b>{/if}Страницы{if $current_section ne "page"}</a>{else}</b>{/if}</span>
     <span class="menu_element">{if $current_section ne "user"}<a href="{url section=user action=list}">{else}<b>{/if}Пользователи{if $current_section ne "user"}</a>{else}</b>{/if}</span>
    </div>
    <!--div id="menu">
     <div id="menu_element{if $current_section eq "news"}_current{/if}"><a href="{url section=news}">Новости</a></div>
     <div id="menu_element{if $current_section eq "page"}_current{/if}"><a href="{url section=page}">Страницы</a></div>
     <div id="menu_element{if $current_section eq "user"}_current{/if}"><a href="{url section=user action=list}">Пользователь</a></div>
    </div-->

    {load module="user" action="login" args="" section="user"}
    <div id="logotip"><a href="/"><img id="img_logotip" src="/templates/images/mzz_logo.png" width="111" height="34" alt="" /></a></div>
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
