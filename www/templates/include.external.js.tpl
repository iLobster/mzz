{if isset($media.js) }
{strip}
    {assign var="external" value=""}
    {foreach from=$media.js item="jsfile" name="jsFiles"}
    {if $jsfile.join}
        {assign var="currentFile" value=$jsfile.file}
        {assign var="external" value=$external$currentFile,}
    {else}
        {include file=$jsfile.tpl filename=$jsfile.file}
    {/if}
    {/foreach}
    {if $external}
        <script type="text/javascript" src="{$SITE_PATH}/templates/external.php?type=js&amp;files={$external|substr:0:-1}"></script>
    {/if}
{/strip}
{/if}