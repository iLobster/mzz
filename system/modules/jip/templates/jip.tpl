{if $jip}
{strip}
{add file="jip.css"}
{add file="icons.sys.css"}
{add file="icons.flags.css"}

{add file="jip/jipCore.js"}
{add file="jip/jipMenu.js"}
{/strip}

<img src="{$SITE_PATH}/images/spacer.gif" width="18" height="10" class="jip jip-button" onmouseup="if (jipMenu) {ldelim}jipMenu.show(this, '{$jipId}', [{foreach from=$jip item=jipItem name=jipItems}['{$jipItem.title}', '{$jipItem.url}', '{icon sprite=$jipItem.icon jip=true}', '{$jipItem.lang}', {$jipItem.target}]{if !$smarty.foreach.jipItems.last},{/if}{/foreach}], {ldelim}{foreach from=$langs item="langNames" key="langId" name="langs"}{$langId}: ['{$langNames->getName()}', '{$langNames->getLanguageName()}']{if !$smarty.foreach.langs.last},{/if}{/foreach}{rdelim});{rdelim}" alt="JIP Меню" />
{/if}