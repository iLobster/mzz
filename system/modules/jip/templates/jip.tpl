{if $jip}
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
{add file="jip/jipCore.css"}
{add file="icons.css"}
{add file="bullets.css"}
{add file="flags.css"}

{add file="fileLoader.js"}
{add file="jip/jipCore.js"}
{add file="jip/jipMenu.js"}
{add file="jip/jipWindow.js"}
{/strip}

<img src="{$SITE_PATH}/images/jip/jip.gif" class="jip" onmouseup="if (jipMenu) {ldelim}jipMenu.show(this, '{$jipId}', [{foreach from=$jip item=jipItem name=jipItems}['{$jipItem.title}', '{$jipItem.url}', {icon sprite=$jipItem.icon jip=true}, '{$jipItem.lang}', {$jipItem.target}]{if !$smarty.foreach.jipItems.last},{/if}{/foreach}], {ldelim}{foreach from=$langs item="langNames" key="langId" name="langs"}{$langId}: ['{$langNames->getName()}', '{$langNames->getLanguageName()}']{if !$smarty.foreach.langs.last},{/if}{/foreach}{rdelim});{rdelim}" alt="JIP Меню" />
{/if}