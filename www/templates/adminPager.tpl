{if $pager->getPagesTotal() > 1}
    {if !is_null($pager->getPrev())}<a href="{$pager->getPrev()}">Предыдущая</a>{else}Предыдущая{/if}
    {foreach from=$pages item=current}
    {if not empty($current.skip)}...{elseif not empty($current.current)}&nbsp;<strong>{$current.page}</strong>&nbsp;{else}&nbsp;<a href="{$current.url}">{$current.page}</a>&nbsp;{/if}
    {/foreach}
    {if !is_null($pager->getNext())}<a href="{$pager->getNext()}">Следующая</a>{else}Следующая{/if}
{/if}