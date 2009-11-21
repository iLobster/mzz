{if isset($media['js'])}
{foreach from=$media['js'] item="jsitem" key="file"}
{include file=$jsitem.tpl filename=$file}
{/foreach}
{/if}