{foreach from=$pages item=current}
    {if not empty($current.skip)}
        ...
    {elseif not empty($current.current)}
        <b>[{$current.page}]</b>
    {else}
        <a href="{$current.url}">{$current.page}</a>
    {/if}
{/foreach}