{foreach from=$menus item="menu"}
<h1>{$menu->getTitle()}</h1>
{include file="menu/view.tpl" items=$menu->searchItems()}
{/foreach}