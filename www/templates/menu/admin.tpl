<h1>������ ����:{$folder->getJip()}</h1>
{foreach from=$menus item="menu"}
<strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()} <a class="jipLink" href="{url route="withId" section="menu" action="create" id=0}">�� ���</a>
{include file="menu/adminview.tpl" items=$menu->searchItems()}
<br />
{/foreach}