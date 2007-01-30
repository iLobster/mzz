{add file="popup.js"}
{add file="prototype.js"}
{add file="jip.css"}
{add file="jscalendar/calendar.js"}
{add file="jscalendar/calendar-ru.js"}
{add file="jscalendar/calendar-setup.js"}
{add file="tiny_mce/tiny_mce_src.js"}

<div id="jip_menu_{$jipMenuId}" class="jipMenu">
<table border="0" cellpadding="3" cellspacing="0" class="jipItems">
{foreach from=$jip item=item}
   <tr onclick="javascript: jipMenu.show(this, '{$jipMenuId}'); return jipWindow.open('{$item.url}');" onmouseout="this.cells[1].className = 'jipItemText';" onmouseover="this.cells[1].className = 'jipItemTextActive';">
     <td class="jipItemIcon"><a href="{$item.url}" onclick="return false;"><img src="{$item.icon}" width="16" height="16" alt="{$item.title}" /></a></td>
     <td class="jipItemText">{$item.title}</td>
   </tr>
{/foreach}
</table>
</div>
<img src="{$SITE_PATH}/templates/images/jip.gif" class="jip" onclick="javascript: jipMenu.show(this, '{$jipMenuId}');" alt="JIP Μενώ" />