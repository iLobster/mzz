{foreach from=$items key="id" item="item"}
    <li id="item_{$id}">
        <div class="menuItem">
            <div class="menuTreeTitle"><div class="menuHandler"></div>{$item->getTitle()} <span class="menuUrl">({$item->getUrl()})</span></div>
            <div class="menuActions">{$item->getJip('menu/jip.tpl')}</div>
        </div>
        {if sizeof($item->getChildrens())}<ul>{include file="menu/adminview.tpl" items=$item->getChildrens()}</ul>{/if}
    </li>
{/foreach}