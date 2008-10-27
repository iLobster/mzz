{* main="header.tpl" placeholder="content" *}

<div id="wrapper">
    <div id="nonFooter">
        <div id="hbackground">
            <div id="hcontainer">
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
                <div><a href="{$SITE_PATH}/"><img src="{$SITE_PATH}/templates/images/mzz_logo.gif" width="146" height="42" alt="" /></a></div>
            </div>
        </div>
        <div id="menucontainer">
            <div id="navMenu">
                {load module="menu" section="menu" action="view" name="hmenu" tplPrefix="header"}
            </div>
        </div>

        <div class="headerBorderLine"><img src="{$SITE_PATH}/templates/images/spacer.gif" width="1" height="2" alt="" /></div>
        <div id="content">

            <div{if $current_section != 'gallery' && $current_section != 'forum'} id="leftMainCol"{/if}>
                <div id="container">
                    <!--  left column  -->
                    <div id="col1">
                        {load module="menu" section="menu" action="view" name="smenu" tplPrefix="side"}
                        <div class="sideBlock">
                            {load module="user" action="loginForm" section="user" id=0}
                        </div>
                    </div>

                    <!-- center column -->
                    <div id="col2">
                        {$content}
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            {if $current_section != 'gallery' && $current_section != 'forum'}
            <!-- right column -->
            <div id="col3">
                <div class="sideBlock">
                    <p class="sideBlockTitle">Опрос</p>
                    <div class="sideBlockContent">
                        {load module="voting" section="voting" action="viewActual" name="simple" 403handle="none"}
                    </div>
                </div>

            </div>
            {/if}

            <div class="clear"></div>
        </div>
    </div>
</div>
<div id="footer">
    <span>{$smarty.const.MZZ_NAME} v.{$smarty.const.MZZ_VERSION}-{$smarty.const.MZZ_REVISION} &copy; {"Y"|date}.<br />
    {$timer->toString()}</span>
</div>
</body>
</html>
