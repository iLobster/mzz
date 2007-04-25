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
<img src="{$SITE_PATH}/templates/images/jip.gif" class="jip" onclick="javascript: jipMenu.show(this, '{$jipMenuId}', [{foreach from=$jip item=jipItem name=jipItems}['{$jipItem.title}', '{$jipItem.url}', '{$jipItem.icon}']{if !$smarty.foreach.jipItems.last},{/if}{/foreach}]);" alt="JIP Μενώ" />