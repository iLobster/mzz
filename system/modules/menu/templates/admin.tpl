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
        После изменений необходимо сохранить их, нажав на <input id="menuApply_{$menu->getId()}" disabled="disabled" value="Применить" onclick="menu.save('{url route="withId" action="move" module="menu" id=$menu->getId()}', {$menu->getId()});" type="button" />
        </div>
        <div class="menuTree menuMargin">
            <ul class="menuTree" id="menuTree_{$menu->getId()}">{*include file="menu/adminview.tpl" items=$menu->getItems()*}
        {foreach from=$menu->getItems() item="menuItem" key="id" name="menuItemIteration"}
            {strip}{if !$smarty.foreach.menuItemIteration.first}
                {if $menuItem->getTreeLevel() < $lastLevel}
                    {math equation="x - y" x=$lastLevel y=$menuItem->getTreeLevel() assign="levelDown"}
                    {"</li></ul>"|@str_repeat:$levelDown}</li>
                {elseif $lastLevel == $menuItem->getTreeLevel()}
                    </li>
                {else}
                    <ul>
                {/if}
            {/if}{/strip}
            <li id="item_{$id}">
                <div class="menuItem">
                    <div class="menuTreeTitle"><div class="menuHandler"></div>{$menuItem->getTitle()|h} <span class="menuUrl">({$menuItem->getUrl()|h})</span></div>
                    <div class="menuActions">{$menuItem->getJip('menu/jip.tpl')}</div>
                </div>

            {strip}{assign var="lastLevel" value=$menuItem->getTreeLevel()}
            {if $smarty.foreach.menuItemIteration.last}
                {math equation="x - y" x=$lastLevel y=1 assign="levelDown"}
                {"</li></ul>"|@str_repeat:$levelDown}</li>
            {/if}{/strip}
        {foreachelse}
            <li>В этом меню нет элементов</li>
        {/foreach}
            </ul>
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
<img alt="preload" src="{$SITE_PATH}/images/menu/left_side_yellow.gif" width="1" height="1"/>
<img alt="preload" src="{$SITE_PATH}/images/menu/bg_yellow.gif" width="1" height="1"/>
</div>
</div>
