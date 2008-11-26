{if isset($media.js) }
{foreach from=$media.js item=jsfile}
{include file=$jsfile.tpl filename=$jsfile.file}
{/foreach}
{/if}