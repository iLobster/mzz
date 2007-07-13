{strip}
{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{/strip}
<div class="menuJipItems" style="display: none;" id="{$jipMenuId}">
<table border="0" cellpadding="3" cellspacing="0">
    <tbody>
        <tr>
            {foreach from=$jip item=jipItem name=jipItems}
            <td onmouseover="this.style.backgroundColor = '#F4F4F4';" onmouseout="this.style.backgroundColor = 'transparent';"><a href="{$jipItem.url}"><img src="{$jipItem.icon}" height="16" width="16" alt="{$jipItem.title}" title="{$jipItem.title}" /></a></td>
            {/foreach}
        </tr>
    </tbody>
</table>
</div>