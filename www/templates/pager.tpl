{add file="pager.css"}
{if !is_null($pager->getPrev())}<span class="pageNumber"><a href="{$pager->getPrev()}">����������</a></span>{/if}
{foreach from=$pages item=current}
<span class="pageNumber">{if not empty($current.skip)}...{elseif not empty($current.current)}&nbsp;<strong>{$current.page}</strong>&nbsp;{else}&nbsp;<a href="{$current.url}">{$current.page}</a>&nbsp;{/if}</span>
{/foreach}
{if !is_null($pager->getNext())}<span class="pageNumber"><a href="{$pager->getNext()}">���������</a></span>{/if}