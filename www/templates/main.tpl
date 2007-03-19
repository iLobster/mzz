{* main="header.tpl" placeholder="content" *}
<div id="wrapper">
<div id="nonFooter">
<div id="hcontainer">

    <div id="menu">
     <span class="menu_element"><a href="{url route=default2 section=news action=""}">{if $current_section eq "news"}<b>{/if}Новости{if $current_section eq "news"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=page action=""}">{if $current_section eq "page"}<b>{/if}Страницы{if $current_section eq "page"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=catalogue}">{if $current_section eq "catalogue"}<b>{/if}Каталог{if $current_section eq "catalogue"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=user action=list}">{if $current_section eq "user"}<b>{/if}Пользователи{if $current_section eq "user"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url route=default2 section=admin action=view}">{if $current_section eq "admin"}<b>{/if}Панель управления{if $current_section eq "admin"}</b>{/if}</a></span>
    </div>

    {load module="user" action="login" section="user" id=0 403handle="none"}
    <div id="logotip"><a href="{$SITE_PATH}/"><img id="img_logotip" src="{$SITE_PATH}/templates/images/mzz_logo.gif" width="124" height="29" alt="" /></a></div>
</div>


<div id="content">{$content}</div>
</div>
</div>

<div id="footer">
        <div id="fcontainer">
        <div id="footer_text">{$timer->toString()}
2007 &copy; {$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION})</div>
        <div id="footer_image"><img src="{$SITE_PATH}/templates/images/mzz_footer.png" width="79" height="63" alt="" /></div>
     </div>
    </div>
</body>
</html>