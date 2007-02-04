{if isset($media.css) }
{foreach from=$media.css item=cssfile}
{include file=$cssfile.tpl filename=$cssfile.file}
{/foreach}
{/if}