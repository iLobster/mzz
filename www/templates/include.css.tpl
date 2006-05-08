{if isset($css) }
{foreach from=$css item=cssfile}
{include file=$cssfile.tpl filename=$cssfile.file}
{/foreach}
{/if}