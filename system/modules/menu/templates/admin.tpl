{add file="menuTree.css"}
{add file="menuTree.js"}
<div class="pageTitle">Список меню {$folder->getJip()}</div>
<div class="pageContent">
<div id="resp"></div>
{foreach from=$menus item="menu"}
<ul>
    <li>{$menu->getTitle()}
        <ul id="menuTree_{$menu->getId()}">{include file="menu/adminview2.tpl" items=$menu->getItems()}</ul>
    </li>
</ul>
<input id="menuTree_{$menu->getId()}_apply" type="button" disabled="disabled" value="Применить" onclick="new Ajax.Request('/admin/menu/admin', {literal}{{/literal}
            method: 'post',
            parameters: {literal}{{/literal} menuId: {$menu->getId()}, data: Sortable.serialize('menuTree_{$menu->getId()}') {literal}}{/literal},
            onSuccess: function(transport) {literal}{
                $('resp').update(transport.responseText);
            }{/literal}
        });" />
<script type="text/javascript">
    //<![CDATA[
    Sortable.create('menuTree_{$menu->getId()}', {literal}{{/literal}
        tree:true,
        scroll:window,
        onUpdate: function() {literal}{{/literal}
            $('menuTree_{$menu->getId()}_apply').enable();
        {literal}}{/literal}
    {literal}}{/literal});
    //]]>
</script>
{/foreach}

{*
{foreach from=$menus item="menu"}
<ul id="menuTree_{$menu->getId()}" class="menuTree">
    <li class="treeItem treeItemRoot" id="root-{$menu->getId()}"><div class="menuItem menuItemRoot"><span class="textHolder"><strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()}</span></div>
        <ul>
            {include file="menu/adminview.tpl" menu=$menu items=$menu->getItems()}
        </ul>
    </li>
</ul>
<script type="text/javascript">
    //<![CDATA[
    Sortable.create('menuTree_{$menu->getId()}', {tree:true,scroll:window});
    //]]>
</script>
{/foreach}
*}
{*
<script type="text/javascript">
Event.observe(window, 'load', buildMenuTree);
</script>
*}
</div>