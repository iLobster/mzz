{foreach from=$items key="id" item="item"}
    <span class="menu_element"><a href="{$item->getUrl()}">{if $item->isActive()}<b>{/if}{$item->getTitle()}{if $item->isActive()}</b>{/if}</a></span>
{/foreach}
