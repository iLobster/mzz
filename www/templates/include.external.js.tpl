{strip}
{if isset($media.js) }
{foreach from=$media.js item="jsfile" name="jsFiles"}
{if $smarty.foreach.jsFiles.first}<script type="text/javascript" src="{$SITE_PATH}/templates/external.php?type=js&amp;files={/if}
{$jsfile.file}{if !$smarty.foreach.jsFiles.last},{/if}
{/foreach}
"></script>
{/if}
{/strip}