{if isset($media['css'])}
{foreach from=$media['css'] item="cssitem" key="file"}
{include file=$cssitem.tpl filename=$file}
{/foreach}
{/if}