{include file="admin/title.tpl" title="Управление сайтом"}
{foreach from=$dashboard item="action"}
    {$action->run()}
{/foreach}