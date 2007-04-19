{strip}
{add file="popup.js"}
{add file="jip.css"}
{add file="dtree.css"}
{add file="dtree.js"}
{add file="jip.js"}
{add file="calendar-blue.css"}
{add file="jscalendar/calendar.js"}
{add file="jscalendar/calendar-ru.js"}
{add file="jscalendar/calendar-setup.js"}
{add file="tiny_mce/tiny_mce.js"}
{/strip}
<div id="jip_menu_{$jipMenuId}" class="jipMenu">
<table border="0" cellpadding="3" cellspacing="0" class="jipItems">
{foreach from=$jip item=jipItem}
   <tr onclick="javascript: jipMenu.show(this, '{$jipMenuId}'); return jipWindow.open('{$jipItem.url}');" onmouseout="this.cells[1].className = 'jipItemText';" onmouseover="this.cells[1].className = 'jipItemTextActive';">
     <td class="jipItemIcon"><a href="{$jipItem.url}" onclick="return false;"><img src="{$jipItem.icon}" width="16" height="16" alt="{$jipItem.title}" /></a></td>
     <td class="jipItemText">{$jipItem.title}</td>
   </tr>
{/foreach}
</table>
</div>
<img src="{$SITE_PATH}/templates/images/jip.gif" class="jip" onclick="javascript: jipMenu.show(this, '{$jipMenuId}');" alt="JIP ����" />