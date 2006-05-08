{if isset($js) }
{foreach from=$js item=jsfile}
{include file=$jsfile.tpl filename=$jsfile.file}
{/foreach}
{/if}