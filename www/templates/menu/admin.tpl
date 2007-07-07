{add file="menuTree.css"}
{add file="menuTree.js"}

<h1>Список меню:{$folder->getJip()}</h1>
{foreach from=$menus item="menu"}



<div>
<ul id="myTree">
<li class="treeItem" id=root style="width: 100%; height: 15px;"><div class="menuItem"><span class="textHolder"><strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()}</span></div>
<ul>
{include file="menu/adminview.tpl" menu=$menu items=$menu->searchItems()}
</ul>
</li>
</ul>
</div>
<script type="text/javascript">
Event.observe(window, 'load', buildMenuTree);
</script>

{/foreach}