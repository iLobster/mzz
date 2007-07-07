{foreach from=$items key="id" item="item"}
    <li class="treeItem">
        <div class="menuItem">
        <div class="menuItemContent">
        <div style="text-align: right;float: right; color: #8D8D8D; font-size: 11px; position: relative" class="menuType">advanced</div>
        <span class="textHolder">{$item->getTitle()}</span>{$item->getJip()}<br /> <span style=" color: #8D8D8D; font-size: 11px;">{$item->getUrl()}</span></div>
    </div>

    {if sizeof($item->getChildrens())}<ul style="display: none;">{include file="menu/adminview.tpl" items=$item->getChildrens()}</ul>{/if}
    </li>
{/foreach}