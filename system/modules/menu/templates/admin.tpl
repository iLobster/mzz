{add file="menuTree.css"}

{add file="prototype.js"}
{add file="prototype_improvements.js"}
{add file="effects.js"}
{add file="dragdrop.js"}
{add file="menuTree.js"}
{add file="hoverObserver.js"}
<div class="pageTitle">Список меню {$folder->getJip()}</div>
<div class="pageContent">

<p></p>

{foreach from=$menus item="menu"}
<div id="menuTree">
<ul id="myTree">
<li class="treeItem treeItemRoot" id="root"><div class="menuItem menuItemRoot"><span class="textHolder"><strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()}</span></div>
<ul style="displa: none;">
{include file="menu/adminview.tpl" menu=$menu items=$menu->getItems()}
</ul>
</li>
</ul>
</div>
<script type="text/javascript">
{literal}
Event.observe(window, 'load', function () {
    buildMenuTree();
    if ($("menuTree"))
    window.hoverObserver = new HoverObserver("menuTree", {activationDelay: 0.2});
});

Event.observe(window, "unload", function() {
    if ($("menuTree"))
    window.hoverObserver.stop();
});
{/literal}
</script>

{/foreach}
</div>