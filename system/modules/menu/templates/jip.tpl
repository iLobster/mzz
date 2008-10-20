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
            <td><a href="#" onclick="return menu.up({$id}, {$menu->getId()});"><img src="{$SITE_PATH}/templates/images/arrow_up.gif" alt="up" /></a></td>
            <td><a href="#" onclick="return menu.down({$id}, {$menu->getId()});"><img src="{$SITE_PATH}/templates/images/arrow_down.gif" alt="down" /></td>
            {foreach from=$jip item=jipItem name=jipItems}
            <td onmouseover="this.style.backgroundColor = '#F4F4F4';" onmouseout="this.style.backgroundColor = 'transparent';"><a href="{$jipItem.url}" class="jipLink"><img src="{$jipItem.icon}" height="16" width="16" alt="{$jipItem.title}" title="{$jipItem.title}" /></a></td>
            {/foreach}
        </tr>
    </tbody>
</table>
</div>