{strip}
{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{/strip}
<div class="menuJipItems" id="{$jipMenuId}">
<table border="0" cellpadding="3" cellspacing="0">
    <tbody>
        <tr>
            <td><a href="#" onclick="return menu.left({$id}, {$menu->getId()});"><img src="{$SITE_PATH}/templates/images/menu/arrow_left.gif" alt="left" /></a></td>
            <td><a href="#" onclick="return menu.up({$id}, {$menu->getId()});"><img src="{$SITE_PATH}/templates/images/arrow_up.gif" alt="up" /></a></td>
            <td><a href="#" onclick="return menu.down({$id}, {$menu->getId()});"><img src="{$SITE_PATH}/templates/images/arrow_down.gif" alt="down" /></a></td>
            <td><a href="#" onclick="return menu.right({$id}, {$menu->getId()});"><img src="{$SITE_PATH}/templates/images/menu/arrow_right.gif" alt="right" /></a></td>
            {foreach from=$jip item=jipItem key="name" name=jipItems}<td onmouseover="this.style.backgroundColor = '#F4F4F4';" onmouseout="this.style.backgroundColor = 'transparent';">
            {if $name == 'edit'}
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
            </td>
            {/foreach}
        </tr>
    </tbody>
</table>
</div>