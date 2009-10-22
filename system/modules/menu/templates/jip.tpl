{foreach from=$jip item=jipItem key="name" name=jipItems}
    {if $jipItem.lang}
        {strip}
        <a href="{$jipItem.url}" title="{$jipItem.title}" onclick="if (jipMenu) jipMenu.show(this, '{$jipMenuId}_itemEdit', [
            {foreach name="langs" from=$toolkit->getLocale()->searchAll() item="lang"}
                [
                {assign var="langName" value=$lang->getName()}
                '{$lang->getLanguageName()}', '{$jipItem.url}?lang_id={$lang->getId()}', {icon sprite="sprite:mzz-flag/$langName" jip=true}, ''
                ]
                {if !$smarty.foreach.langs.last}, {/if}
            {/foreach}
            ], {ldelim}{rdelim}); return false;">
        {/strip}
    {else}
        <a href="{$jipItem.url}" class="mzz-jip-link" title="{$jipItem.title}">
    {/if}

        {icon sprite=$jipItem.icon}

        </a>
{/foreach}