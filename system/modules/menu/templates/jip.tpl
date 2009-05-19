{strip}
{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{/strip}
            {foreach from=$jip item=jipItem key="name" name=jipItems}
            {if $jipItem.lang}
            {strip}
            <a href="{$jipItem.url}" onclick="if (jipMenu) jipMenu.show(this, '{$jipMenuId}_itemEdit', [
                {foreach name="langs" from=$available_langs item="lang"}
                    [
                    '{$lang->getLanguageName()}', '{$jipItem.url}?lang_id={$lang->getId()}', '{$jipItem.icon}', ''
                    ]
                    {if !$smarty.foreach.langs.last}, {/if}
                {/foreach}
                ], {ldelim}{rdelim}); return false;">
            {/strip}
            {else}
            <a href="{$jipItem.url}" class="jipLink">
            {/if}
            <img src="{$jipItem.icon}" height="16" width="16" alt="{$jipItem.title}" title="{$jipItem.title}" /></a>
            {/foreach}