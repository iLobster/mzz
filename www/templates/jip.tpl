{add file="popup.js"}
{add file="confirm.js"}
{add file="jip.css"}
<div id="jip_menu_{$jipMenuId}" class="jipMenu" onmouseover="javascript: setMouseInJip(true);" onmouseout="javascript: setMouseInJip(false);">
<table border="0" cellpadding="3" cellspacing="0" class="jipItems"> 
{foreach from=$jip item=item}
   <tr onclick="javascript: showJipMenu(this, '{$jipMenuId}'); return {if not empty($item.confirm)}mzz_confirm('{$item.confirm}') &amp;&amp; {/if}showJip('{$item.url}');" onmouseout="this.cells[1].className = 'jipItemText';" onmouseover="this.cells[1].className = 'jipItemTextActive';">
     <td class="jipItemIcon"><img src="{$item.icon}" width="16" height="16" alt="{$item.title}" /></td>
     <td class="jipItemText">{$item.title}</td>
   </tr>
{/foreach}
</table>
</div>
<img src="{$SITE_PATH}templates/images/jip.gif" class="jip" onclick="javascript: showJipMenu(this, '{$jipMenuId}');" alt="JIP Μενώ" />
