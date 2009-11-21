{if isset($media['css'])}
{strip}
    {assign var="external" value=""}
    {foreach from=$media.css item="cssitem" key="file" name="cssFiles"}
    {if $cssitem.join}
        {assign var="currentFile" value=$file}
        {assign var="external" value=$external$currentFile,}
    {else}
        {include file=$cssitem.tpl filename=$file}
    {/if}
    {/foreach}
    {if $external}
        <link rel="stylesheet" type="text/css" href="{$SITE_PATH}/templates/external.php?type=css&amp;files={$external|substr:0:-1}" />
    {/if}
{/strip}
{/if}