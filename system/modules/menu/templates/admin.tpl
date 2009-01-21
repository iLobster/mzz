{add file="menu/menuTree.css"}
{add file="prototype.js"}
{add file="menu/menu.js"}
<div class="pageTitle">Список меню {$folder->getJip()}</div>
<div class="pageContent">

<div class="menuHelp">
    Для перемещения элемента нажмите на него и перенесите в нужное место. Измененные элементы будут окрашены в желтый цвет.
    После изменений необходимо сохранить их, нажав на кнопку, которая появится под названием меню. Если не получится перемещать
    с первого раза, не расстраивайтесь.
</div>

<div class="menuList">
    {foreach from=$menus item="menu" name="menu_items"}
        <div>
        <a href="#" id="menuToggleLink-{$menu->getId()}" onclick="menu.toggleTree({$menu->getId()}, this); return false;">{$menu->getName()|htmlspecialchars}</a>
        {$menu->getJip()}
        </div>
    {/foreach}
</div>

{foreach from=$menus item="menu" name="menu_items"}
<div id="menuTree_content_{$menu->getId()}" style="display: none;">
<div class="menuHelp">
После изменений необходимо сохранить их, нажав на <input id="menuTree_{$menu->getId()}_apply" value="Применить" onclick="menu.save('{url route="withAnyParam" action="move" name=$menu->getName()}', {$menu->getId()});" type="button" disabled="disabled" />
</div>
<div class="menuTree menuMargin">
   <ul class="menuMargin" id="menuTree_{$menu->getId()}">{include file="menu/adminview.tpl" items=$menu->getItems()}</ul>
</div>

<script type="text/javascript">
    //<![CDATA[
    menu.create({$menu->getId()});
    {if $smarty.foreach.menu_items.first}menu.toggleTree({$menu->getId()}, $('menuToggleLink-{$menu->getId()}'));{/if}
    //]]>
</script>
</div>
{/foreach}

<div style="visibility: hidden;">
<img alt="preload" src="{$SITE_PATH}/templates/images/menu/left_side_yellow.gif" width="1" height="1"/>
<img alt="preload" src="{$SITE_PATH}/templates/images/menu/bg_yellow.gif" width="1" height="1"/>
</div>
</div>
