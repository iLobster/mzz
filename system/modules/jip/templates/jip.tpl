{strip}
{add file="jquery.js"}
{add file="jquery-ui/ui.core.js"}
{add file="jquery-ui/effects.core.js"}
{add file="jquery-ui.css"}
{add file="jquery-ui/ui.draggable.js"}
{add file="jquery-ui/ui.resizable.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}

{add file="jip.css"}
{add file="tiny_mce/tiny_mce.js" join=false}

{add file="jip/fileLoader.js"}
{add file="jip/window.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
{/strip}
<img src="{$SITE_PATH}/templates/images/jip/jip.gif" class="jip" onmouseup="if (jipMenu) {ldelim}jipMenu.show(this, '{$jipMenuId}', [{foreach from=$jip item=jipItem name=jipItems}['{$jipItem.title}', '{$jipItem.url}', '{$jipItem.icon}', '{$jipItem.lang}', {$jipItem.target}]{if !$smarty.foreach.jipItems.last},{/if}{/foreach}], {ldelim}{foreach from=$langs item="langNames" key="langId" name="langs"}{$langId}: ['{$langNames->getName()}', '{$langNames->getLanguageName()}']{if !$smarty.foreach.langs.last},{/if}{/foreach}{rdelim});{rdelim}" alt="JIP Меню" />
