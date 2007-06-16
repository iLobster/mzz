<h1>Список меню:{$folder->getJip()}</h1>
{foreach from=$menus item="menu"}
<strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()} <a class="jipLink" href="{url route="menuCreateAction" menu_name=$menu->getName() id=0}">Не жми</a>
{include file="menu/adminview.tpl" items=$menu->searchItems()}
<br />
{/foreach}