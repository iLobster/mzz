{foreach from=$jip item=jipItem key="name" name=jipItems}
    {if $jipItem.lang}
        {strip}
        <a href="{$jipItem.url}" title="{$jipItem.title}" onclick="if (jipMenu) jipMenu.show(this, '{$jipMenuId}_itemEdit', [
            {foreach name="langs" from=$available_langs item="lang"}
                [
                {$lang|var_dump}
                {assign var="langCod" value=$lang->getLanguageName()}
                '{$langCod}', '{$jipItem.url}?lang_id={$lang->getId()}', {icon sprite="sprite:mzz-flag/$langCod" jip=true}, ''
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