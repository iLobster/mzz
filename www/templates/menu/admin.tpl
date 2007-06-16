{foreach from=$menus item="menu"}
<strong>{$menu->getTitle()}</strong>{$menu->getJip()}
{include file="menu/adminview.tpl" items=$menu->searchItems()}
{/foreach}