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
     <span class="menu_element"><a href="{url section=news}">{if $current_section eq "news"}<b>{/if}�������{if $current_section eq "news"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url section=page}">{if $current_section eq "page"}<b>{/if}��������{if $current_section eq "page"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url section=user action=list}">{if $current_section eq "user"}<b>{/if}������������{if $current_section eq "user"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url section=admin action=view}">{if $current_section eq "admin"}<b>{/if}������ ����������{if $current_section eq "admin"}</b>{/if}</a></span>
    </div>

    {load module="user" action="login" section="user" args=""}
    <div id="logotip"><a href="{$SITE_PATH}"><img id="img_logotip" src="{url section="templates" params="images/mzz_logo.png"}" width="124" height="29" alt="" /></a></div>
</div>


<div id="content">{$content}</div>
</div>
</div>

<div id="footer">
        <div id="fcontainer">
        <div id="footer_text">{load module="timer" action="view" section="timer"}
2006 &copy; {$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION})</div>
        <div id="footer_image"><img src="{url section="templates" params="images/mzz_footer.png"}" width="79" height="63" alt="" /></div>

     </div>
    </div>
</body>
</html>