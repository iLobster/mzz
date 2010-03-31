{if isset($__media['js'])}
{foreach from=$__media['js'] item="jsitem" key="file"}
{include file=$jsitem.tpl filename=$file}
{/foreach}
{/if}