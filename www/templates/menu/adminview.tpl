{foreach from=$items key="id" item="item"}
<div style="padding-left: 60px;">
<a href="{$item->getPropertyValue('url')}">{$item->getTitle()}</a>{$item->getJip()}
{if sizeof($item->getChildrens())}{include file="menu/adminview.tpl" items=$item->getChildrens()}{/if}
</div>
{/foreach}