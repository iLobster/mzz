{strip}
{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}

{add file="popup.js"}
{add file="jip.css"}
{add file="jip.js"}
{add file="calendar-blue.css"}
{add file="jscalendar/calendar.js"}
{add file="jscalendar/calendar-ru.js"}
{add file="jscalendar/calendar-setup.js"}
{add file="tiny_mce/tiny_mce.js" join=false}
{/strip}
<img src="{$SITE_PATH}/templates/images/jip/jip.gif" class="jip" onmouseup="if (jipMenu) {ldelim}jipMenu.show(this, '{$jipMenuId}', [{foreach from=$jip item=jipItem name=jipItems}['{$jipItem.title}', '{$jipItem.url}', '{$jipItem.icon}', '{$jipItem.lang}']{if !$smarty.foreach.jipItems.last},{/if}{/foreach}], {ldelim}{foreach from=$langs item="langNames" key="langId" name="langs"}{$langId}: ['{$langNames->getName()}', '{$langNames->getLanguageName()}']{if !$smarty.foreach.langs.last},{/if}{/foreach}{rdelim});{rdelim}" alt="JIP Меню" />
