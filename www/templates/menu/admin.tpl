<h1>������ ����:{$folder->getJip()}</h1>
{foreach from=$menus item="menu"}
<strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()} 
{include file="menu/adminview.tpl" menu=$menu items=$menu->searchItems()}
<br />
{/foreach}