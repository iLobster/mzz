{* main="admin/main/adminHeader.tpl" placeholder="content" *}
<div id="page">
    <div id="header">
        <div class="loginInfo">{load module="user" action="login" section="user" onlyForm=true tplPrefix="admin"}</div>
        <div class="siteName"><div><a href="{$SITE_PATH}/">www.mzz.ru</a></div></div>
        <div class="favorite">
            <div>
                <a href="{$SITE_PATH}/"><img src="{$SITE_PATH}/templates/images/admin/favorite.gif" class="favoriteIcon" width="18" height="16" alt="Site" title="Перейти на сайт" /></a>
                <!--span class="doubleSeparator">&nbsp;</span> <a href="#">Добавить новость</a>
                <span>&nbsp;</span> <a href="#">Добавить страницу</a-->
                <div class="langs">
                {foreach name="langs" from=$available_langs item="lang"}
                {assign lang_name=$lang->getName()}
                {if $current_lang neq $lang_name}
                    <a href="{url lang=$lang_name}">{$lang_name|strtoupper}</a>
                {else}
                    {$lang_name|strtoupper}
                {/if}
                {if !$smarty.foreach.langs.last} | {/if}
                {/foreach}
                </div>
            </div>
        </div>
    </div>
    <div id="sidebar">
        <p class="sideMenuTitle">Модули</p>
        {load module="admin" action="menu"}
        <div class="patch_minheight"></div>
   </div>

    <div id="mainbar">
    {$content}
    <div class="patch_minheight"></div>
    </div>

    <div class="footer_guarantor">&nbsp;</div>
</div>

<div class="footer">{$smarty.const.MZZ_NAME} (v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION}) 2005-{"Y"|date}.
{$timer->toString('timer/admin/timer.tpl')}
</div>

</body>
</html>