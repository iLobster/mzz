{foreach from=$items key="id" item="item"}
    <li id="item_{$id}" class="treeItem treeItemGray">
        <div class="menuItemActions">{$item->getJip('menu/jip.tpl')}</div>
        <div class="menuItemTitle menuItemTitleGray">{$item->getTitle()} <span class="menuUrl">({$item->getUrl()})</span></div>
        <ul>{if sizeof($item->getChildrens())}{include file="menu/adminview.tpl" items=$item->getChildrens()}{/if}</ul>
    </li>
{/foreach}