{foreach from=$items key="id" item="item"}
<div style="padding-left: 50px; border: 1px solid red;">
{$id} -> <a href="{$item->getPropertyValue('url')}">{$item->getTitle()}</a>{$item->getJip()}
{if sizeof($item->getChildrens())}{include file="menu/view.tpl" items=$item->getChildrens()}{/if}
</div>
{/foreach}