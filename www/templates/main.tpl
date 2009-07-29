{* main="header.tpl" placeholder="content" *}
{load module="user" action="login" section="user" onlyForm=true _side="left"}
<div id="wrapper">
    <div id="nonFooter">
        <div id="hbackground">
            <div id="hcontainer">
                <div class="langs">
                {foreach name="langs" from=$available_langs item="lang"}
                {assign lang_name=$lang->getName()}
                {if $current_lang neq $lang_name}
                    <a href="{url lang=$lang_name}">{$lang_name|strtoupper} {icon sprite="sprite:mzz-flag/`$lang_name`"}</a>
                {else}
                    {$lang_name|strtoupper} {icon sprite="sprite:mzz-flag/`$lang_name`" active=true}
                {/if}
                {if !$smarty.foreach.langs.last} | {/if}
                {/foreach}
                </div>
                <div><a href="{$SITE_PATH}/"><img src="{$SITE_PATH}/templates/images/mzz_logo.gif" width="146" height="42" alt="" /></a></div>
            </div>
        </div>
        <div id="menucontainer">
            <div id="navMenu">
                {load module="menu" action="view" name="hmenu" tplPrefix="header/"}
            </div>
        </div>

        <div class="headerBorderLine"><img src="{$SITE_PATH}/templates/images/spacer.gif" width="1" height="2" alt="" /></div>
        <div id="content">

            <div{if false && $current_section != 'gallery' && $current_section != 'forum'} id="leftMainCol"{/if}>
                <div id="container">
                    <!--  left column  -->
                    <div id="col1">
                        {side->get side="left" assign="leftSide"}
                        {foreach from=$leftSide item="block"}
                        <div class="sideBlock">
                        {$block}
                        </div>
                        {/foreach}
                    </div>

                    <!-- center column -->
                    <div id="col2">
                        {$content}
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
            {if false && $current_section != 'gallery' && $current_section != 'forum'}
            <!-- right column -->
            <div id="col3">

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