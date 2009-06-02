{foreach from=$jip item=jipItem key="name" name=jipItems}
    {if $jipItem.lang}
        {strip}
        <a href="{$jipItem.url}" title="{$jipItem.title}" onclick="if (jipMenu) jipMenu.show(this, '{$jipMenuId}_itemEdit', [
            {foreach name="langs" from=$available_langs item="lang"}
                [
                '{$lang->getLanguageName()}', '{$jipItem.url}?lang_id={$lang->getId()}', '{$jipItem.icon}', ''
                ]
                {if !$smarty.foreach.langs.last}, {/if}
            {/foreach}
            ], {ldelim}{rdelim}); return false;">
        {/strip}
    {else}
        <a href="{$jipItem.url}" class="mzz-jip-link" title="{$jipItem.title}">
    {/if}

    {if empty($jipItem.icon)}
        <span class="{$jipItem.sprite} {$jipItem.index}"></span>
    {else}
        <img src="{$jipItem.icon}" height="16" width="16" alt="{$jipItem.title}" />
    {/if}
    
        </a>
{/foreach}