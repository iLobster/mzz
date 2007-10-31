<ul>
{foreach from=$menu->getItems() key="id" item="item"}
    <li{if $item->isActive()} class="activeNavElement"{/if}><a href="{$item->getUrl()}">{$item->getTitle()}</a></li>
{/foreach}
</ul>