{foreach from=$item->exportOldProperties() key="property" item="value"}
{assign var=$property value=$value}
{/foreach}
{capture name="tpl"}catalogue/types/{$item->getTypeName()}.tpl{/capture}
{include file=$smarty.capture.tpl  item=$item}