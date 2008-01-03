{add file="pager.css"}
<span class="pageNumber">{if !is_null($pager->getPrev())}<a href="{$pager->getPrev()}">{_ prev}</a>{else}{_ prev}{/if}</span>
{foreach from=$pages item=current}
<span class="pageNumber">{if not empty($current.skip)}...{elseif not empty($current.current)}&nbsp;<strong>{$current.page}</strong>&nbsp;{else}&nbsp;<a href="{$current.url}">{$current.page}</a>&nbsp;{/if}</span>
{/foreach}
<span class="pageNumber">{if !is_null($pager->getNext())}<a href="{$pager->getNext()}">{_ next}</a>{else}{_ next}{/if}</span>