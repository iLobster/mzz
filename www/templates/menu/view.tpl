{foreach from=$items key="id" item="item"}
    <span class="menu_element"><a href="{$item->getUrl()}">{if $item->isActive()}<b>{/if}{$item->getTitle()}{if $item->isActive()}</b>{/if}</a>{$item->getJip()}</span>
{*
<div style="padding-left: 50px; border: 1px solid red;">
{$id} -> <a href="{$item->getPropertyValue('url')}">{$item->getTitle()}</a>{$item->getJip()}
{if sizeof($item->getChildrens())}{include file="menu/view.tpl" items=$item->getChildrens()}{/if}
</div>
*}
{/foreach}