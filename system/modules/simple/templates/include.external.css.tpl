{if isset($media.css) }
{strip}
    {assign var="external" value=""}
    {foreach from=$media.css item="cssfile" name="cssFiles"}
    {if $cssfile.join}
        {assign var="currentFile" value=$cssfile.file}
        {assign var="external" value=$external$currentFile,}
    {else}
        {include file=$cssfile.tpl filename=$cssfile.file}
    {/if}
    {/foreach}
    {if $external}
        <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/external.php?type=css&amp;files={$external|substr:0:-1}" />
    {/if}
{/strip}
{/if}