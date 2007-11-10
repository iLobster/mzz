{strip}<ul>
{foreach from=$items item="item"}
    <li><a href="{$item->getUrl()}">{if $item->isActive()}<strong>{/if}{$item->getTitle()}{if $item->isActive()}</strong>{/if}</a>
    {if $item->getChildrens() && $item->isActive()}{include file="menu/$prefix/viewRecursive.tpl" items=$item->getChildrens()}{/if}
    </li>
{/foreach}</ul>{/strip}