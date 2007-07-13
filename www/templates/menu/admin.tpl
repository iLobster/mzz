{add file="menuTree.css"}
{add file="menuTree.js"}
<div class="pageTitle">Список меню {$folder->getJip()}</div>
<div class="pageContent">

<p></p>

{foreach from=$menus item="menu"}

<ul id="myTree">
<li class="treeItem treeItemRoot" id="root"><div class="menuItem menuItemRoot"><span class="textHolder"><strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()}</span></div>
<ul style="displa: none;">
{include file="menu/adminview.tpl" menu=$menu items=$menu->searchItems()}
</ul>
</li>
</ul>
<script type="text/javascript">
Event.observe(window, 'load', buildMenuTree);
</script>

{/foreach}
</div>