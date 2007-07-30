{foreach from=$items key="id" item="item"}
    <li class="treeItem hover_container hover_target">
        <div class="menuItem">
        <div class="menuItemContent">
        <div class="menuType">{$item->getTypeTitle()}</div>
        <div style="display: inline; float: left;"><span class="textHolder">{$item->getTitle()}</span> <span class="menuUrl">({$item->getUrl(false)})</span></div>
        {$item->getJip('menu/jip.tpl')}
        </div>
        {*<div class="dragImage"><img src="{$SITE_PATH}/templates/images/drag.gif" width="26" height="15" /></div>*}
    </div>

    {if sizeof($item->getChildrens())}<ul style="display: none;">{include file="menu/adminview.tpl" items=$item->getChildrens()}</ul>{/if}
    </li>
{/foreach}

{*$item->getJip()*}