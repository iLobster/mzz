{* main="header.tpl" placeholder="content" *}
<div id="wrapper">
<div id="nonFooter">
<div id="hcontainer">

    <div id="menu">
     <span class="menu_element"><a href="{url section=news}">{if $current_section eq "news"}<b>{/if}�������{if $current_section eq "news"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url section=page}">{if $current_section eq "page"}<b>{/if}��������{if $current_section eq "page"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url section=user action=list}">{if $current_section eq "user"}<b>{/if}������������{if $current_section eq "user"}</b>{/if}</a></span>
     <span class="menu_element"><a href="{url section=admin action=view}">{if $current_section eq "admin"}<b>{/if}������ ����������{if $current_section eq "admin"}</b>{/if}</a></span>
    </div>

    {load module="user" action="login" section="user" id=0}
    <div id="logotip"><a href="{$SITE_PATH}/"><img id="img_logotip" src="{$SITE_PATH}/templates/images/mzz_logo.gif" width="124" height="29" alt="" /></a></div>
</div>


<div id="content">{$content}</div>
</div>
</div>

<div id="footer">
        <div id="fcontainer">
        <div id="footer_text">{load module="timer" action="view" section="timer"}
2007 &copy; {$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION})</div>
        <div id="footer_image"><img src="{$SITE_PATH}/templates/images/mzz_footer.png" width="79" height="63" alt="" /></div>
     </div>
    </div>
</body>
</html>