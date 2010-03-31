{if isset($__media['css'])}
{foreach from=$__media['css'] item="cssitem" key="file"}
{include file=$cssitem.tpl filename=$file}
{/foreach}
{/if}