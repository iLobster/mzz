{foreach from=$items key="id" item="item"}
    <li id="item_{$id}" class="treeItem">
        <div class="menuItem">
            <div class="menuItemContent">
                <div class="menuType">{$item->getTypeTitle()}</div>
                <div style="display: inline; float: left;"><span class="textHolder">{$item->getTitle()}</span> <span class="menuUrl">({$item->getUrl(false)})</span></div>
                {$item->getJip('menu/jip.tpl')}
            </div>
        </div>
    <ul style="padding-bottom:3px;">{if sizeof($item->getChildrens())}{include file="menu/adminview.tpl" items=$item->getChildrens()}{/if}</ul>
    </li>
{/foreach}