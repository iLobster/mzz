{* main="header.tpl" placeholder="content" *}
<div id="wrapper">
<div id="nonFooter">
<div id="hcontainer">

    <div id="menu">
    {load module="menu" section="menu" action="view" name="demo" 403handle="none"}
    </div>
    {* {if $current_section != 'user'} *}
    {load module="user" action="loginForm" section="user" id=0 403handle="none"}
    {* {/if} *}
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