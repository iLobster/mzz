{if count($pages) > 1}
{foreach from=$pages item=current}
{if not empty($current.skip)}...{elseif not empty($current.current)}&nbsp;<strong>{$current.page}</strong>&nbsp;{else}&nbsp;<a href="{$current.url}">{$current.page}</a>&nbsp;{/if}
{/foreach}
{/if}