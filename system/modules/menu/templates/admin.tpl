{add file="menuTree.css"}
<div class="pageTitle">Список меню {$folder->getJip()}</div>
<div class="pageContent">
{foreach from=$menus item="menu"}
<ul class="menuTree">
    <li class="treeItem treeItemRoot"><div class="menuItem menuItemRoot"><span class="textHolder"><strong>{$menu->getTitle()} ({$menu->getName()})</strong>{$menu->getJip()}</span></div>
        <ul id="menuTree_{$menu->getId()}">{include file="menu/adminview2.tpl" items=$menu->getItems()}</ul>
    </li>
</ul>
<input id="menuTree_{$menu->getId()}_apply" type="button" disabled="disabled" value="Применить" onclick="new Ajax.Request('{url route="withAnyParam" action="move" name=$menu->getName()}', {literal}{{/literal}
            method: 'post',
            parameters: {literal}{{/literal} data: Sortable.serialize('menuTree_{$menu->getId()}') {literal}}{/literal},
            onSuccess: function(transport) {literal}{{/literal}
                $('menuTree_{$menu->getId()}_apply').setValue('Сохранено...');
                $('menuTree_{$menu->getId()}_apply').disable();
                //$('resp').update(transport.responseText);
            {literal}}{/literal}
        });" />
<script type="text/javascript">
    //<![CDATA[
    Sortable.create('menuTree_{$menu->getId()}', {literal}{{/literal}
        tree:true,
        scroll:window,
        onUpdate: function() {literal}{{/literal}
            $('menuTree_{$menu->getId()}_apply').setValue('Применить');
            $('menuTree_{$menu->getId()}_apply').enable();
        {literal}}{/literal}
    {literal}}{/literal});
    //]]>
</script>
{/foreach}
</div>