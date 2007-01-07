{if isset($js) }
{foreach from=$js item=jsfile}
{include file="js.xml.tpl" filename=$jsfile.file}
{/foreach}
{/if}
