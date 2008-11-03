{if isset($media.css) }
{strip}
{foreach from=$media.css item="cssfile" name="cssFiles"}
{if $smarty.foreach.cssFiles.first}<link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/external.php?type=css&amp;files={/if}
{$cssfile.file}{if !$smarty.foreach.cssFiles.last},{/if}
{/foreach}
" />
{/strip}
{/if}