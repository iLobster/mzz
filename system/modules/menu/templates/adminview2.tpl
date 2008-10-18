{foreach from=$items key="id" item="item"}
    <li id="item_{$id}">{$item->getTitle()}
    <ul style="padding-bottom:3px;">{if sizeof($item->getChildrens())}{include file="menu/adminview2.tpl" items=$item->getChildrens()}{/if}</ul>
    </li>
{/foreach}