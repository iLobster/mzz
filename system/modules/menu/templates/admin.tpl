{add file="menu/menuTree.css"}
{add file="jquery.js"}
{add file="jquery-ui/ui.core.js"}
{add file="dui.js"}
{add file="jquery.ex.js"}
{add file="menu/mzz_ns.js"}
{add file="menu/jmenu.js"}
<div class="title">Список меню {$folder->getJip()}</div>
<div class="pageContent">

<div class="menuHelp">
    Для перемещения элемента нажмите на него и перенесите в нужное место. Измененные элементы будут окрашены в желтый цвет.
    После изменений необходимо сохранить их, нажав на кнопку, которая появится под названием меню. Если не получится перемещать
    с первого раза, не расстраивайтесь.
</div>

<div class="menuList">
    {foreach from=$menus item="menu" name="menu_items"}
        <div>
            <a href="#" id="menuLink-{$menu->getId()}" onclick="menu.toggle({$menu->getId()}); return false;">{$menu->getName()|htmlspecialchars}</a>{$menu->getJip()}
        </div>
    {/foreach}
</div>

{foreach from=$menus item="menu" name="menu_items"}
    <div id="menuContent_{$menu->getId()}" class="menuContent" style="display: none">
        <div class="menuHelp">
        После изменений необходимо сохранить их, нажав на <input id="menuApply_{$menu->getId()}" disabled="disabled" value="Применить" onclick="menu.save('{url route="withAnyParam" action="move" module="menu" name=$menu->getName()}', {$menu->getId()});" type="button" />
        </div>
        <div class="menuTree menuMargin">
           <ul class="menuTree" id="menuTree_{$menu->getId()}">{include file="menu/adminview.tpl" items=$menu->getItems()}</ul>
        </div>

        <script type="text/javascript">
            //<![CDATA[
            menu.create({$menu->getId()});
            {if $smarty.foreach.menu_items.first}menu.toggle({$menu->getId()});{/if}
            //]]>
        </script>
    </div>
{/foreach}
<div style="visibility: hidden;">
<img alt="preload" src="{$SITE_PATH}/templates/images/menu/left_side_yellow.gif" width="1" height="1"/>
<img alt="preload" src="{$SITE_PATH}/templates/images/menu/bg_yellow.gif" width="1" height="1"/>
</div>
</div>
