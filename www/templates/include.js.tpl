{if isset($js) }
<script type="text/javascript"> var SITE_PATH = '{$SITE_PATH}'; </script>
{foreach from=$js item=jsfile}
{include file=$jsfile.tpl filename=$jsfile.file}
{/foreach}
{/if}
