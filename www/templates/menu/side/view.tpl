{strip}<ul class="sideMenu">
{foreach from=$menu->getItems() key="id" item="item"}
    <li><a href="{$item->getUrl()}">{if $item->isActive()}<strong>{/if}{$item->getTitle()}{if $item->isActive()}</strong>{/if}</a>
    {if $item->getChildrens() && $item->isActive()}<ul>
    {foreach from=$item->getChildrens() item="item"}
        <li><a href="{$item->getUrl()}">{if $item->isActive()}<strong>{/if}{$item->getTitle()}{if $item->isActive()}</strong>{/if}</a>
    {/foreach}</ul>
    {/if}
    </li>
{/foreach}
</ul>{/strip}